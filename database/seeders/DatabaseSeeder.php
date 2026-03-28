<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Conversation;
use App\Models\Mentor;
use App\Models\Message;
use App\Models\Review;
use App\Models\Task;
use App\Models\TaskStep;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $user = User::factory()->create([
                'name' => 'Dennis Nzioki',
                'email' => 'dennis@example.com',
                'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Dennis',
            ]);

            UserSetting::create([
                'user_id' => $user->id,
                'language' => 'en',
                'timezone' => 'UTC',
                'time_format' => '24h',
                'notifications_enabled' => true,
            ]);

            $teammates = User::factory()->count(5)->create();

            $categories = collect([
                ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
                ['name' => 'Frontend Development', 'slug' => 'frontend-development'],
                ['name' => 'Backend Development', 'slug' => 'backend-development'],
                ['name' => 'Product Design', 'slug' => 'product-design'],
                ['name' => 'Mobile Development', 'slug' => 'mobile-development'],
                ['name' => 'Research', 'slug' => 'research'],
                ['name' => 'Full Stack Development', 'slug' => 'full-stack-development'],
                ['name' => 'Design Systems', 'slug' => 'design-systems'],
            ])->mapWithKeys(fn (array $category) => [
                $category['slug'] => Category::create($category),
            ]);

            $mentors = collect([
                [
                    'name' => 'Sarah Johnson',
                    'role' => 'Senior UI/UX Designer',
                    'bio' => 'Experienced designer with 8+ years creating intuitive user interfaces. Specializes in mobile app design and design systems.',
                    'avatar_seed' => 'Sarah',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah',
                    'category_slug' => 'ui-ux-design',
                    'tasks_count' => 24,
                    'rating' => 4.80,
                    'reviews_count' => 120,
                    'is_featured' => true,
                ],
                [
                    'name' => 'Michael Chen',
                    'role' => 'Full Stack Developer',
                    'bio' => 'Full stack expert passionate about building scalable web applications. Proficient in React, Node.js, and cloud technologies.',
                    'avatar_seed' => 'Michael',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Michael',
                    'category_slug' => 'full-stack-development',
                    'tasks_count' => 18,
                    'rating' => 4.90,
                    'reviews_count' => 95,
                    'is_featured' => true,
                ],
                [
                    'name' => 'Emily Rodriguez',
                    'role' => 'Product Designer',
                    'bio' => 'Product designer focused on user-centered design and creating meaningful digital experiences that solve real problems.',
                    'avatar_seed' => 'Emily',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Emily',
                    'category_slug' => 'product-design',
                    'tasks_count' => 32,
                    'rating' => 4.70,
                    'reviews_count' => 156,
                    'is_featured' => false,
                ],
                [
                    'name' => 'David Kim',
                    'role' => 'Frontend Developer',
                    'bio' => 'Frontend specialist with expertise in modern JavaScript frameworks. Creates performant and accessible web applications.',
                    'avatar_seed' => 'David',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=David',
                    'category_slug' => 'frontend-development',
                    'tasks_count' => 15,
                    'rating' => 4.90,
                    'reviews_count' => 88,
                    'is_featured' => false,
                ],
                [
                    'name' => 'Jessica Martinez',
                    'role' => 'UX Researcher',
                    'bio' => 'UX researcher dedicated to understanding user behavior and translating insights into actionable design recommendations.',
                    'avatar_seed' => 'Jessica',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Jessica',
                    'category_slug' => 'research',
                    'tasks_count' => 28,
                    'rating' => 4.60,
                    'reviews_count' => 134,
                    'is_featured' => false,
                ],
                [
                    'name' => 'Robert Taylor',
                    'role' => 'Backend Developer',
                    'bio' => 'Backend engineer specializing in API development, database design, and building robust server-side architectures.',
                    'avatar_seed' => 'Robert',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Robert',
                    'category_slug' => 'backend-development',
                    'tasks_count' => 21,
                    'rating' => 4.80,
                    'reviews_count' => 102,
                    'is_featured' => false,
                ],
                [
                    'name' => 'Amanda Wilson',
                    'role' => 'Design System Lead',
                    'bio' => 'Design system expert who creates cohesive design languages and component libraries for scalable product teams.',
                    'avatar_seed' => 'Amanda',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Amanda',
                    'category_slug' => 'design-systems',
                    'tasks_count' => 35,
                    'rating' => 5.00,
                    'reviews_count' => 178,
                    'is_featured' => true,
                ],
                [
                    'name' => 'James Anderson',
                    'role' => 'Mobile App Developer',
                    'bio' => 'Mobile developer with expertise in iOS and Android development. Creates native and cross-platform mobile applications.',
                    'avatar_seed' => 'James',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=James',
                    'category_slug' => 'mobile-development',
                    'tasks_count' => 19,
                    'rating' => 4.70,
                    'reviews_count' => 91,
                    'is_featured' => false,
                ],
                [
                    'name' => 'Lisa Thompson',
                    'role' => 'Interaction Designer',
                    'bio' => 'Interaction designer focused on creating delightful and intuitive user experiences through thoughtful micro-interactions.',
                    'avatar_seed' => 'Lisa',
                    'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Lisa',
                    'category_slug' => 'ui-ux-design',
                    'tasks_count' => 26,
                    'rating' => 4.80,
                    'reviews_count' => 145,
                    'is_featured' => false,
                ],
            ])->mapWithKeys(function (array $mentor) use ($categories) {
                $category = $categories[$mentor['category_slug']];
                unset($mentor['category_slug']);

                return [
                    $mentor['name'] => Mentor::create([
                        ...$mentor,
                        'category_id' => $category->id,
                    ]),
                ];
            });

            $user->followedMentors()->sync([
                $mentors['Michael Chen']->id,
                $mentors['Jessica Martinez']->id,
                $mentors['Amanda Wilson']->id,
            ]);

            foreach ($mentors as $mentor) {
                Review::factory()->create([
                    'mentor_id' => $mentor->id,
                    'user_id' => $user->id,
                    'rating' => (int) round($mentor->rating),
                    'comment' => sprintf('Helpful guidance from %s.', $mentor->name),
                ]);
            }

            $tasks = collect([
                [
                    'title' => 'Creating Awesome Mobile Apps',
                    'description' => 'Build a mobile-first product workflow from concept to prototype.',
                    'category_slug' => 'ui-ux-design',
                    'mentor_name' => 'Sarah Johnson',
                    'status' => 'in_progress',
                    'progress' => 90,
                    'deadline_at' => now()->addHour(),
                    'started_at' => now()->subDays(4),
                    'is_featured' => true,
                    'steps' => [
                        'Understanding the tools in Figma',
                        'Understand the basics of making designs',
                        'Design a mobile application with figma',
                    ],
                ],
                [
                    'title' => 'Creating Mobile App Design',
                    'description' => 'Design a polished application flow for a modern mobile experience.',
                    'category_slug' => 'ui-ux-design',
                    'mentor_name' => 'Sarah Johnson',
                    'status' => 'in_progress',
                    'progress' => 75,
                    'deadline_at' => now()->addDays(3),
                    'started_at' => now()->subDays(3),
                    'is_featured' => true,
                    'steps' => [
                        'Prepare user flow',
                        'Create high-fidelity frames',
                        'Review with mentor',
                    ],
                ],
                [
                    'title' => 'Building React Application',
                    'description' => 'Implement a responsive frontend for a dashboard experience.',
                    'category_slug' => 'frontend-development',
                    'mentor_name' => 'David Kim',
                    'status' => 'new',
                    'progress' => 30,
                    'deadline_at' => now()->addHours(5),
                    'started_at' => now()->subDay(),
                    'is_featured' => false,
                    'steps' => [
                        'Create layout shell',
                        'Implement component states',
                        'Connect API responses',
                    ],
                ],
                [
                    'title' => 'API Architecture Review',
                    'description' => 'Design repository, action and service boundaries for the backend API.',
                    'category_slug' => 'backend-development',
                    'mentor_name' => 'Robert Taylor',
                    'status' => 'new',
                    'progress' => 20,
                    'deadline_at' => now()->addDays(2),
                    'started_at' => now()->subHours(8),
                    'is_featured' => false,
                    'steps' => [
                        'Define repositories',
                        'Map actions to endpoints',
                        'Review service boundaries',
                    ],
                ],
                [
                    'title' => 'Interview Task API Delivery',
                    'description' => 'Prepare backend responses for overview, tasks, mentors, messages and settings.',
                    'category_slug' => 'backend-development',
                    'mentor_name' => 'Michael Chen',
                    'status' => 'in_progress',
                    'progress' => 45,
                    'deadline_at' => now()->addDays(4),
                    'started_at' => now()->subDays(2),
                    'is_featured' => true,
                    'steps' => [
                        'Prepare domain schema',
                        'Implement list endpoints',
                        'Write feature tests',
                    ],
                ],
            ])->map(function (array $taskData) use ($categories, $mentors, $user, $teammates) {
                $steps = $taskData['steps'];
                $categorySlug = $taskData['category_slug'];
                $mentorName = $taskData['mentor_name'];
                unset($taskData['steps']);
                unset($taskData['category_slug']);
                unset($taskData['mentor_name']);

                $task = Task::create([
                    ...$taskData,
                    'category_id' => $categories[$categorySlug]->id,
                    'mentor_id' => $mentors[$mentorName]->id,
                ]);

                $task->members()->attach($user->id, ['role' => 'owner']);
                $task->members()->attach(
                    $teammates->random(min(3, $teammates->count()))->pluck('id')->all(),
                    ['role' => 'member']
                );

                foreach ($steps as $index => $step) {
                    TaskStep::create([
                        'task_id' => $task->id,
                        'title' => $step,
                        'is_completed' => $index < max(1, (int) floor($task->progress / 40)),
                        'sort_order' => $index + 1,
                    ]);
                }

                return $task;
            });

            $conversationData = [
                [
                    'participant' => User::factory()->create([
                        'name' => 'Angelie Crison',
                        'email' => 'angelie@example.com',
                        'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Angelie',
                    ]),
                    'messages' => [
                        ['sender' => 'other', 'body' => 'Thank you very much. I\'m glad we aligned on the design direction.', 'minutes_ago' => 1],
                    ],
                ],
                [
                    'participant' => User::factory()->create([
                        'name' => 'Jakob Saris',
                        'email' => 'jakob@example.com',
                        'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Jakob',
                    ]),
                    'messages' => [
                        ['sender' => 'self', 'body' => 'Sure! let me tell you about what I am building for the API layer.', 'minutes_ago' => 2],
                    ],
                ],
                [
                    'participant' => User::factory()->create([
                        'name' => 'Sarah Johnson',
                        'email' => 'sarah.mentor@example.com',
                        'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah',
                    ]),
                    'messages' => [
                        ['sender' => 'other', 'body' => 'Great! Looking forward to it.', 'minutes_ago' => 5],
                    ],
                ],
            ];

            foreach ($conversationData as $conversationSeed) {
                $conversation = Conversation::create([
                    'subject' => null,
                    'last_message_at' => now()->subMinutes($conversationSeed['messages'][0]['minutes_ago']),
                ]);

                $conversation->participants()->attach([
                    $user->id,
                    $conversationSeed['participant']->id,
                ]);

                foreach ($conversationSeed['messages'] as $messageSeed) {
                    Message::create([
                        'conversation_id' => $conversation->id,
                        'sender_id' => $messageSeed['sender'] === 'self' ? $user->id : $conversationSeed['participant']->id,
                        'body' => $messageSeed['body'],
                        'sent_at' => now()->subMinutes($messageSeed['minutes_ago']),
                        'read_at' => now(),
                    ]);
                }
            }
        });
    }
}
