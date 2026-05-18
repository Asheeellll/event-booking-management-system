<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Event;

/**
 * BOOKING SEEDER
 * --------------
 * 10 sample bookings linking Indian users to events.
 * Prices are calculated dynamically from event price.
 *
 * Status distribution:
 *   Confirmed: 5 | Pending: 3 | Cancelled: 2
 */
class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $arjun = User::where('email', 'arjun@example.com')->first();
        $priya = User::where('email', 'priya@example.com')->first();
        $rohit = User::where('email', 'rohit@example.com')->first();

        $aiEvent       = Event::where('title', 'like', '%AI & Machine Learning%')->first();
        $musicEvent    = Event::where('title', 'like', '%Nh7 Weekender%')->first();
        $cricketEvent  = Event::where('title', 'like', '%IPL Fan%')->first();
        $startupEvent  = Event::where('title', 'like', '%Startup Pitch%')->first();
        $bootcampEvent = Event::where('title', 'like', '%Full Stack%')->first();

        $bookings = [
            // Arjun
            ['user_id' => $arjun->id, 'event_id' => $aiEvent->id,      'tickets' => 2, 'total_price' => 2 * $aiEvent->price,       'status' => 'confirmed', 'notes' => 'Please arrange front-row seating.'],
            ['user_id' => $arjun->id, 'event_id' => $musicEvent->id,   'tickets' => 3, 'total_price' => 3 * $musicEvent->price,    'status' => 'confirmed', 'notes' => null],
            ['user_id' => $arjun->id, 'event_id' => $startupEvent->id, 'tickets' => 1, 'total_price' => 1 * $startupEvent->price,  'status' => 'pending',   'notes' => 'I am a B.Tech final-year student building a startup.'],
            ['user_id' => $arjun->id, 'event_id' => $bootcampEvent->id,'tickets' => 1, 'total_price' => 0.00,                       'status' => 'confirmed', 'notes' => 'Looking forward to the session!'],

            // Priya
            ['user_id' => $priya->id, 'event_id' => $aiEvent->id,      'tickets' => 1, 'total_price' => 1 * $aiEvent->price,       'status' => 'confirmed', 'notes' => null],
            ['user_id' => $priya->id, 'event_id' => $cricketEvent->id, 'tickets' => 2, 'total_price' => 2 * $cricketEvent->price,  'status' => 'pending',   'notes' => 'Can we get a team photo opportunity?'],
            ['user_id' => $priya->id, 'event_id' => $bootcampEvent->id,'tickets' => 1, 'total_price' => 0.00,                       'status' => 'cancelled', 'notes' => 'Cannot attend due to exam schedule.'],

            // Rohit
            ['user_id' => $rohit->id, 'event_id' => $musicEvent->id,   'tickets' => 4, 'total_price' => 4 * $musicEvent->price,    'status' => 'confirmed', 'notes' => 'Booking for family outing.'],
            ['user_id' => $rohit->id, 'event_id' => $startupEvent->id, 'tickets' => 1, 'total_price' => 1 * $startupEvent->price,  'status' => 'pending',   'notes' => null],
            ['user_id' => $rohit->id, 'event_id' => $cricketEvent->id, 'tickets' => 1, 'total_price' => 1 * $cricketEvent->price,  'status' => 'cancelled', 'notes' => 'Travel plans changed.'],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }

        $this->command->info('✅ 10 Bookings seeded (5 confirmed, 3 pending, 2 cancelled).');
    }
}
