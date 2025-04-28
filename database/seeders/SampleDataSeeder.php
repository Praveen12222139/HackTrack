<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use App\Models\Hackathon;
use App\Models\Application;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Create a sample user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create sample hackathons
        $hackathons = [
            Hackathon::create([
                'name' => 'AI Innovation Challenge',
                'description' => 'Build innovative AI solutions',
                'logo_url' => 'https://example.com/ai-hackathon-logo.png',
                'website_url' => 'https://aihackathon.example.com',
                'registration_start' => now(),
                'registration_end' => now()->addDays(20),
                'event_start' => now()->addDays(30),
                'event_end' => now()->addDays(33),
                'location' => 'Virtual',
                'challenges' => json_encode([
                    'Best AI Application',
                    'Most Innovative Solution',
                    'Best Use of Machine Learning'
                ]),
                'sponsors' => json_encode([
                    'TechCorp',
                    'AI Solutions Ltd'
                ]),
                'prizes' => json_encode([
                    'First Place: $10,000',
                    'Second Place: $5,000',
                    'Third Place: $2,500'
                ]),
                'rules' => json_encode([
                    'Teams must have 2-4 members',
                    'All code must be written during the hackathon',
                    'Must use AI/ML technologies'
                ]),
                'is_active' => true
            ]),
            Hackathon::create([
                'name' => 'Web3 Development',
                'description' => 'Create decentralized applications',
                'logo_url' => 'https://example.com/web3-hackathon-logo.png',
                'website_url' => 'https://web3hackathon.example.com',
                'registration_start' => now()->addDays(10),
                'registration_end' => now()->addDays(40),
                'event_start' => now()->addDays(60),
                'event_end' => now()->addDays(63),
                'location' => 'Virtual',
                'challenges' => json_encode([
                    'Best DApp',
                    'Most Innovative Blockchain Solution',
                    'Best Smart Contract Implementation'
                ]),
                'sponsors' => json_encode([
                    'Blockchain Corp',
                    'Web3 Foundation'
                ]),
                'prizes' => json_encode([
                    'First Place: $15,000',
                    'Second Place: $7,500',
                    'Third Place: $3,000'
                ]),
                'rules' => json_encode([
                    'Teams must have 2-5 members',
                    'Must use blockchain technology',
                    'Must be decentralized'
                ]),
                'is_active' => true
            ]),
            Hackathon::create([
                'name' => 'Mobile App Hackathon',
                'description' => 'Build innovative mobile applications',
                'logo_url' => 'https://example.com/mobile-hackathon-logo.png',
                'website_url' => 'https://mobilehackathon.example.com',
                'registration_start' => now()->addDays(20),
                'registration_end' => now()->addDays(50),
                'event_start' => now()->addDays(90),
                'event_end' => now()->addDays(93),
                'location' => 'Virtual',
                'challenges' => json_encode([
                    'Best Mobile App',
                    'Most User-Friendly Interface',
                    'Best Performance'
                ]),
                'sponsors' => json_encode([
                    'MobileTech Inc',
                    'App Solutions'
                ]),
                'prizes' => json_encode([
                    'First Place: $8,000',
                    'Second Place: $4,000',
                    'Third Place: $2,000'
                ]),
                'rules' => json_encode([
                    'Teams must have 2-4 members',
                    'Must be a mobile application',
                    'Must work on both iOS and Android'
                ]),
                'is_active' => true
            ]),
        ];

        // Create sample teams
        $teams = [
            Team::create([
                'name' => 'AI Masters',
                'description' => 'Expert team in AI and machine learning',
                'hackathon_id' => $hackathons[0]->id,
                'leader_id' => $user->id,
            ]),
            Team::create([
                'name' => 'Web3 Warriors',
                'description' => 'Blockchain and Web3 enthusiasts',
                'hackathon_id' => $hackathons[1]->id,
                'leader_id' => $user->id,
            ]),
        ];

        // Add user to teams
        $user->teams()->attach($teams[0]->id);
        $user->teams()->attach($teams[1]->id);

        // Create sample applications with different statuses
        Application::create([
            'user_id' => $user->id,
            'hackathon_id' => $hackathons[0]->id,
            'status' => 'accepted',
            'motivation' => 'I am passionate about AI and want to contribute to innovative solutions.',
        ]);

        Application::create([
            'user_id' => $user->id,
            'hackathon_id' => $hackathons[1]->id,
            'status' => 'pending',
            'motivation' => 'I want to learn more about Web3 development.',
        ]);

        Application::create([
            'user_id' => $user->id,
            'hackathon_id' => $hackathons[2]->id,
            'status' => 'rejected',
            'motivation' => 'I am interested in mobile app development.',
        ]);
    }
} 