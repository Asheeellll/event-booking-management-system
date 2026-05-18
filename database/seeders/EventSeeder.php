<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

/**
 * EVENT SEEDER
 * ------------
 * 6 sample events at realistic Indian venues.
 * Category IDs (after CategorySeeder): 1=Technology 2=Music 3=Sports 4=Business 5=Education
 */
class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $events = [
            // Technology
            [
                'category_id' => 1,
                'user_id'     => $admin->id,
                'title'       => 'AI & Machine Learning Summit 2025',
                'description' => 'Join leading researchers and engineers for a full-day conference on the latest breakthroughs in Artificial Intelligence and Machine Learning. Topics include large language models, computer vision, generative AI, and real-world deployment in healthcare and fintech. Ideal for developers, data scientists, and students.',
                'date'        => '2025-07-15',
                'time'        => '09:00:00',
                'venue'       => 'Bangalore International Exhibition Centre, Bengaluru',
                'capacity'    => 200,
                'price'       => 1499.00,
                'status'      => 'active',
            ],
            // Music
            [
                'category_id' => 2,
                'user_id'     => $admin->id,
                'title'       => 'Nh7 Weekender — Pune Edition 2025',
                'description' => 'India\'s most loved multi-genre music festival returns to Pune. Featuring indie, rock, electronic, and fusion acts across three stages. Enjoy food courts, art installations, and community experiences under the stars over two evenings.',
                'date'        => '2025-08-10',
                'time'        => '17:00:00',
                'venue'       => 'Mahalunge Ground, Balewadi, Pune',
                'capacity'    => 500,
                'price'       => 799.00,
                'status'      => 'active',
            ],
            // Sports
            [
                'category_id' => 3,
                'user_id'     => $admin->id,
                'title'       => 'IPL Fan Experience — Mumbai 2025',
                'description' => 'An exclusive fan meet-and-greet with Mumbai Indians players. Get autographs, participate in live Q&A sessions, and take part in cricket skill challenges. Complimentary merchandise kit included with every ticket.',
                'date'        => '2025-07-25',
                'time'        => '14:00:00',
                'venue'       => 'Wankhede Stadium, Mumbai',
                'capacity'    => 150,
                'price'       => 1999.00,
                'status'      => 'active',
            ],
            // Business
            [
                'category_id' => 4,
                'user_id'     => $admin->id,
                'title'       => 'India Startup Pitch Day 2025',
                'description' => 'Early-stage startups pitch their ideas to a panel of top angel investors and venture capitalists from across India. Three finalist teams win direct investment consideration. Audience tickets available for aspiring founders and ecosystem enthusiasts.',
                'date'        => '2025-09-05',
                'time'        => '10:00:00',
                'venue'       => 'HICC — Hyderabad International Convention Centre',
                'capacity'    => 100,
                'price'       => 499.00,
                'status'      => 'active',
            ],
            // Education — Free event
            [
                'category_id' => 5,
                'user_id'     => $admin->id,
                'title'       => 'Full Stack Web Development Bootcamp',
                'description' => 'A free 2-day hands-on bootcamp for beginners. Learn HTML, CSS, JavaScript, and the basics of building responsive websites. Certificates provided on completion. Trainers from leading Bengaluru tech companies. Bring your laptop.',
                'date'        => '2025-08-20',
                'time'        => '09:00:00',
                'venue'       => 'IIT Madras Research Park, Chennai',
                'capacity'    => 60,
                'price'       => 0.00,
                'status'      => 'active',
            ],
            // Technology — Cancelled example
            [
                'category_id' => 1,
                'user_id'     => $admin->id,
                'title'       => 'Cybersecurity & Ethical Hacking Workshop',
                'description' => 'An intermediate-level workshop covering penetration testing, network vulnerability assessment, and Capture The Flag challenges. Suitable for IT students and cybersecurity professionals.',
                'date'        => '2025-06-30',
                'time'        => '10:00:00',
                'venue'       => 'Cyber Hub, DLF Phase 2, Gurugram, Delhi NCR',
                'capacity'    => 80,
                'price'       => 1199.00,
                'status'      => 'cancelled',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }

        $this->command->info('✅ 6 Events seeded with Indian venues and ₹ pricing.');
    }
}
