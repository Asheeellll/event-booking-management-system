<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    /**
     * Generate an AI event plan using OpenRouter API.
     */
    public function generate(Request $request)
    {
        // 1. Validate the incoming request data
        $validated = $request->validate([
            'event_title'      => 'required|string|max:255',
            'expected_guests'  => 'required|numeric|min:1',
            'estimated_budget' => 'required|string|max:255',
            'package'          => 'required|string',
            'theme_preference' => 'nullable|string|max:255',
        ]);

        // 2. Retrieve OpenRouter configuration from .env
        $apiKey = env('OPENROUTER_API_KEY');
        $model = env('OPENROUTER_MODEL', 'openrouter/auto'); // Fallback model

        if (empty($apiKey)) {
            Log::error('OpenRouter API key is missing.');
            return response()->json([
                'success' => false,
                'message' => 'AI Service is currently unavailable. (Missing Configuration)'
            ], 500);
        }

        // 3. Parse budget and calculate budget per guest
        $rawBudget = strtolower(preg_replace('/[^a-z0-9.]/i', '', $validated['estimated_budget']));
        $numericBudget = 0;
        
        if (str_contains($rawBudget, 'lakh') || str_contains($rawBudget, 'l')) {
            $val = (float) str_replace(['lakhs', 'lakh', 'l'], '', $rawBudget);
            $numericBudget = $val * 100000;
        } elseif (str_contains($rawBudget, 'k')) {
            $val = (float) str_replace('k', '', $rawBudget);
            $numericBudget = $val * 1000;
        } elseif (str_contains($rawBudget, 'cr') || str_contains($rawBudget, 'crore')) {
            $val = (float) str_replace(['crores', 'crore', 'cr'], '', $rawBudget);
            $numericBudget = $val * 10000000;
        } else {
            $numericBudget = (float) preg_replace('/[^0-9.]/', '', $validated['estimated_budget']);
        }

        $guests = max(1, (int) $validated['expected_guests']);
        $budgetPerGuest = $numericBudget > 0 ? round($numericBudget / $guests) : 0;
        $budgetFormatted = $numericBudget > 0 ? '₹' . number_format($numericBudget) : $validated['estimated_budget'];
        $bpgFormatted = $budgetPerGuest > 0 ? '₹' . number_format($budgetPerGuest) : 'Unknown';

        $theme = $validated['theme_preference'] ? $validated['theme_preference'] : 'No specific theme';
        
        $prompt = "You are an experienced professional event planner.\n\n"
                . "Generate a concise event plan.\n\n"
                . "Event Details:\n"
                . "- Event: {$validated['event_title']}\n"
                . "- Guests: {$guests}\n"
                . "- Total Budget: {$budgetFormatted}\n"
                . "- Budget Per Guest: {$bpgFormatted}\n"
                . "- Package: " . ucfirst($validated['package']) . "\n"
                . "- Theme: {$theme}\n\n"
                . "Rules:\n"
                . "- Maximum 250 words.\n"
                . "- Plain text only.\n"
                . "- No greetings.\n"
                . "- No email format.\n"
                . "- No markdown.\n"
                . "- Use ONLY these headings:\n\n"
                . "Event Theme:\n"
                . "Decoration:\n"
                . "Food & Drinks:\n"
                . "Entertainment:\n"
                . "Timeline:\n"
                . "Budget Allocation:\n"
                . "Additional Suggestions:\n\n"
                . "Strict Theme Rule:\n"
                . "If the user provides a Theme Preference, you MUST build the entire event around that theme. Do not replace it with another concept.\n\n"
                . "Recommendations MUST match:\n"
                . "- selected package\n"
                . "- total budget\n"
                . "- guest count\n"
                . "- budget per guest\n\n"
                . "Never recommend:\n"
                . "- celebrities\n"
                . "- luxury performers\n"
                . "- premium catering\n"
                . "- luxury décor\n"
                . "- expensive venues\n"
                . "unless the budget genuinely supports them.\n\n"
                . "If the budget is low compared to the guest count:\n"
                . "- recommend economical catering\n"
                . "- recommend local vendors\n"
                . "- recommend simple decoration\n"
                . "- recommend realistic entertainment\n\n"
                . "Package rules:\n"
                . "Silver:\nBasic venue, simple decoration, local catering, DJ or emcee only.\n\n"
                . "Gold:\nBetter decoration, upgraded buffet, professional host, better AV.\n\n"
                . "Premium:\nLuxury venue, premium catering, elaborate decoration, premium entertainment.\n\n"
                . "Timeline:\n"
                . "Timeline must contain actual event times (e.g., 2:00 PM Registration, 3:00 PM Ceremony).\n\n"
                . "Budget Allocation:\n"
                . "Instead of only percentages, generate both absolute monetary amounts and percentages calculated dynamically from the Total Budget. Example:\n"
                . "Venue: ₹120000 (20%)\n"
                . "The percentages must always total 100%.\n\n"
                . "Keep every section between 1 and 3 short lines.";

        try {
            // 4. Call OpenRouter API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
                'HTTP-Referer'  => url('/'), 
                'X-Title'       => 'Event Booking Management System'
            ])->timeout(30)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert corporate and wedding event planner.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
            ]);

            // 5. Handle response and errors
            if ($response->successful()) {
                $data = $response->json();
                
                // Extract the AI's message
                $plan = $data['choices'][0]['message']['content'] ?? null;
                
                if ($plan) {
                    return response()->json([
                        'success' => true,
                        'plan'    => trim($plan)
                    ]);
                } else {
                    Log::error('OpenRouter API returned success but empty content.', ['response' => $data]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Received an empty response from AI.'
                    ], 502);
                }
            }

            Log::error('OpenRouter API request failed.', [
                'status' => $response->status(),
                'body'   => $response->body()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate plan. AI service returned an error.'
            ], $response->status() > 0 ? $response->status() : 500);

        } catch (\Exception $e) {
            Log::error('OpenRouter API exception: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while connecting to the AI service.'
            ], 500);
        }
    }
}
