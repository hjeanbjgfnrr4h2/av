<?php

namespace Database\Seeders;

use App\Models\Actress;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_premium' => true,
        ]);

        // Create regular users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_premium' => false,
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'premium',
            'is_premium' => true,
        ]);

        // Create channels
        $channel1 = Channel::create([
            'name' => 'Premium Channel',
            'description' => 'High quality content',
            'is_verified' => true,
            'videos_count' => 0,
            'subscribers_count' => 5000,
        ]);

        $channel2 = Channel::create([
            'name' => 'Community Channel',
            'description' => 'Community contributed content',
            'is_verified' => false,
            'videos_count' => 0,
            'subscribers_count' => 1200,
        ]);

        // Create categories
        $categories = [
            ['name' => 'Action', 'description' => 'Action-packed videos', 'sort_order' => 1],
            ['name' => 'Drama', 'description' => 'Dramatic content', 'sort_order' => 2],
            ['name' => 'Comedy', 'description' => 'Funny videos', 'sort_order' => 3],
            ['name' => 'Romance', 'description' => 'Romantic content', 'sort_order' => 4],
            ['name' => 'Thriller', 'description' => 'Thrilling videos', 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['is_active' => true]));
        }

        // Create actresses
        $actresses = [
            ['name' => 'Emma Wilson', 'nationality' => 'USA', 'is_featured' => true],
            ['name' => 'Sofia Rodriguez', 'nationality' => 'Spain', 'is_featured' => true],
            ['name' => 'Yuki Tanaka', 'nationality' => 'Japan', 'is_featured' => false],
            ['name' => 'Maria Silva', 'nationality' => 'Brazil', 'is_featured' => false],
            ['name' => 'Anna Kowalski', 'nationality' => 'Poland', 'is_featured' => false],
        ];

        foreach ($actresses as $actress) {
            Actress::create($actress);
        }

        // Create tags
        $tags = ['Popular', 'Trending', 'New Release', 'Classic', 'Award Winner', 'HD', '4K'];
        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }

        // Create sample videos
        $videos = [
            [
                'title' => 'Epic Adventure Movie',
                'description' => 'An epic adventure through unknown lands',
                'video_url' => 'https://example.com/video1.mp4',
                'channel_id' => $channel1->id,
                'duration' => 7200,
                'rating' => 9.2,
                'is_censored' => false,
                'is_featured' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Romantic Drama',
                'description' => 'A touching love story',
                'video_url' => 'https://example.com/video2.mp4',
                'channel_id' => $channel1->id,
                'duration' => 6300,
                'rating' => 8.5,
                'is_censored' => false,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Comedy Special',
                'description' => 'Hilarious stand-up comedy',
                'video_url' => 'https://example.com/video3.mp4',
                'channel_id' => $channel2->id,
                'duration' => 3600,
                'rating' => 7.8,
                'is_censored' => false,
                'is_featured' => false,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Thriller Night',
                'description' => 'A suspenseful thriller',
                'video_url' => 'https://example.com/video4.mp4',
                'channel_id' => $channel2->id,
                'duration' => 5400,
                'rating' => 8.0,
                'is_censored' => true,
                'is_featured' => false,
                'published_at' => now()->subDay(),
            ],
        ];

        foreach ($videos as $videoData) {
            $video = Video::create($videoData);
            
            // Attach random actresses (1-3)
            $actressIds = Actress::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $video->actresses()->attach($actressIds);
            
            // Attach random categories (1-2)
            $categoryIds = Category::inRandomOrder()->limit(rand(1, 2))->pluck('id');
            $video->categories()->attach($categoryIds);
            
            // Attach random tags (2-4)
            $tagIds = Tag::inRandomOrder()->limit(rand(2, 4))->pluck('id');
            $video->tags()->attach($tagIds);
        }

        $this->command->info('Database seeded successfully!');
    }
}
