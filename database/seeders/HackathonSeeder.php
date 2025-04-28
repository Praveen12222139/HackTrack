<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hackathon;
use Carbon\Carbon;

class HackathonSeeder extends Seeder
{
    public function run()
    {
        $hackathons = [
            [
                'name' => 'Global AI Hackathon 2024',
                'description' => 'Join the world\'s largest AI hackathon where developers, data scientists, and innovators come together to build the future of artificial intelligence.',
                'logo_url' => 'https://example.com/ai-hackathon-logo.png',
                'website_url' => 'https://globalaihackathon.com',
                'event_start' => Carbon::now()->addDays(30),
                'event_end' => Carbon::now()->addDays(32),
                'registration_start' => Carbon::now()->subDays(10),
                'registration_end' => Carbon::now()->addDays(25),
                'location' => 'Virtual',
                'challenges' => json_encode([
                    'Best AI Application',
                    'Most Innovative Solution',
                    'Best Use of Machine Learning',
                    'Best Data Visualization'
                ]),
                'sponsors' => json_encode([
                    'Tech Giant Inc.',
                    'AI Solutions Ltd.',
                    'Data Science Corp'
                ]),
                'prizes' => json_encode([
                    'First Place: $25,000',
                    'Second Place: $15,000',
                    'Third Place: $10,000'
                ]),
                'rules' => json_encode([
                    'Teams must consist of 2-5 members',
                    'All code must be written during the hackathon',
                    'Projects must use AI/ML technologies',
                    'Submissions must include a demo video'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'ClimateTech Challenge 2024',
                'description' => 'Build innovative solutions to combat climate change. This hackathon focuses on sustainable technology, renewable energy, and environmental conservation.',
                'logo_url' => 'https://example.com/climate-tech-logo.png',
                'website_url' => 'https://climatetechchallenge.org',
                'event_start' => Carbon::now()->addDays(45),
                'event_end' => Carbon::now()->addDays(47),
                'registration_start' => Carbon::now()->subDays(5),
                'registration_end' => Carbon::now()->addDays(40),
                'location' => 'San Francisco, CA',
                'challenges' => json_encode([
                    'Best Renewable Energy Solution',
                    'Most Sustainable Technology',
                    'Best Carbon Footprint Reduction',
                    'Most Innovative Green Tech'
                ]),
                'sponsors' => json_encode([
                    'Green Energy Corp',
                    'Sustainable Solutions Inc.',
                    'EcoTech Foundation'
                ]),
                'prizes' => json_encode([
                    'First Place: $15,000',
                    'Second Place: $10,000',
                    'Third Place: $5,000'
                ]),
                'rules' => json_encode([
                    'Teams must consist of 2-4 members',
                    'Projects must address climate change',
                    'Solutions must be sustainable',
                    'Include environmental impact analysis'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'FinTech Innovation Hack',
                'description' => 'Revolutionize the financial industry with cutting-edge technology. Focus areas include blockchain, digital payments, and financial inclusion.',
                'logo_url' => 'https://example.com/fintech-hack-logo.png',
                'website_url' => 'https://fintechinnovationhack.com',
                'event_start' => Carbon::now()->addDays(60),
                'event_end' => Carbon::now()->addDays(62),
                'registration_start' => Carbon::now()->addDays(10),
                'registration_end' => Carbon::now()->addDays(55),
                'location' => 'New York, NY',
                'challenges' => json_encode([
                    'Best Blockchain Solution',
                    'Most Innovative Payment System',
                    'Best Financial Inclusion App',
                    'Most Secure FinTech Solution'
                ]),
                'sponsors' => json_encode([
                    'BankTech Solutions',
                    'FinTech Ventures',
                    'Digital Payments Inc.'
                ]),
                'prizes' => json_encode([
                    'First Place: $20,000',
                    'Second Place: $12,000',
                    'Third Place: $8,000'
                ]),
                'rules' => json_encode([
                    'Teams must consist of 3-6 members',
                    'Projects must be financial technology related',
                    'Include security considerations',
                    'Must have a working prototype'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'HealthTech Solutions Challenge',
                'description' => 'Develop innovative healthcare solutions using technology. Areas include telemedicine, patient care, medical devices, and health data analytics.',
                'logo_url' => 'https://example.com/healthtech-logo.png',
                'website_url' => 'https://healthtechchallenge.org',
                'event_start' => Carbon::now()->addDays(75),
                'event_end' => Carbon::now()->addDays(77),
                'registration_start' => Carbon::now()->addDays(20),
                'registration_end' => Carbon::now()->addDays(70),
                'location' => 'Boston, MA',
                'challenges' => json_encode([
                    'Best Telemedicine Solution',
                    'Most Innovative Medical Device',
                    'Best Health Data Analytics',
                    'Most Impactful Patient Care App'
                ]),
                'sponsors' => json_encode([
                    'HealthTech Innovations',
                    'Medical Solutions Corp',
                    'Digital Health Foundation'
                ]),
                'prizes' => json_encode([
                    'First Place: $17,500',
                    'Second Place: $10,000',
                    'Third Place: $7,500'
                ]),
                'rules' => json_encode([
                    'Teams must consist of 2-5 members',
                    'Projects must be healthcare related',
                    'Must consider HIPAA compliance',
                    'Include user testing results'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'EdTech Innovation Summit',
                'description' => 'Create the future of education technology. Focus on learning platforms, educational tools, and innovative teaching methods.',
                'logo_url' => 'https://example.com/edtech-logo.png',
                'website_url' => 'https://edtechsummit.org',
                'event_start' => Carbon::now()->addDays(90),
                'event_end' => Carbon::now()->addDays(92),
                'registration_start' => Carbon::now()->addDays(30),
                'registration_end' => Carbon::now()->addDays(85),
                'location' => 'Austin, TX',
                'challenges' => json_encode([
                    'Best Learning Platform',
                    'Most Innovative Teaching Tool',
                    'Best Student Engagement Solution',
                    'Most Accessible Education Tech'
                ]),
                'sponsors' => json_encode([
                    'EduTech Solutions',
                    'Learning Innovations Inc.',
                    'Digital Education Foundation'
                ]),
                'prizes' => json_encode([
                    'First Place: $12,500',
                    'Second Place: $7,500',
                    'Third Place: $5,000'
                ]),
                'rules' => json_encode([
                    'Teams must consist of 2-4 members',
                    'Projects must be education focused',
                    'Must consider accessibility',
                    'Include teacher/student feedback'
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($hackathons as $hackathon) {
            Hackathon::create($hackathon);
        }

        Hackathon::create([
            'name' => 'CodeFest 2024',
            'description' => 'Join us for an exciting 48-hour coding competition where developers, designers, and innovators come together to create amazing solutions.',
            'logo_url' => 'hackathon-logos/codefest2024.png',
            'website_url' => 'https://codefest2024.example.com',
            'registration_start' => Carbon::now(),
            'registration_end' => Carbon::now()->addDays(30),
            'event_start' => Carbon::now()->addDays(45),
            'event_end' => Carbon::now()->addDays(47),
            'location' => 'Virtual Event',
            'challenges' => json_encode([
                'AI & Machine Learning',
                'Web Development',
                'Mobile App Development',
                'Blockchain & Web3',
                'IoT & Hardware'
            ]),
            'sponsors' => json_encode([
                'TechCorp',
                'InnovateLabs',
                'FutureTech',
                'CodeMasters'
            ]),
            'prizes' => json_encode([
                '1st Place: $10,000',
                '2nd Place: $5,000',
                '3rd Place: $2,500',
                'Best Design: $1,000',
                'Most Innovative: $1,000'
            ]),
            'rules' => json_encode([
                'Teams must have 2-4 members',
                'All code must be written during the hackathon',
                'No pre-built solutions allowed',
                'Must use at least one sponsor API',
                'Presentations must be 5 minutes or less'
            ]),
            'is_active' => true
        ]);

        Hackathon::create([
            'name' => 'HackTheFuture 2024',
            'description' => 'A global hackathon focused on solving real-world problems using cutting-edge technology.',
            'logo_url' => 'hackathon-logos/hackthefuture2024.png',
            'website_url' => 'https://hackthefuture2024.example.com',
            'registration_start' => Carbon::now()->addDays(15),
            'registration_end' => Carbon::now()->addDays(45),
            'event_start' => Carbon::now()->addDays(60),
            'event_end' => Carbon::now()->addDays(62),
            'location' => 'Hybrid Event (Virtual + Physical)',
            'challenges' => json_encode([
                'Sustainable Technology',
                'Healthcare Innovation',
                'Education Technology',
                'Smart Cities',
                'Financial Technology'
            ]),
            'sponsors' => json_encode([
                'GlobalTech',
                'InnovateHub',
                'FutureSolutions',
                'TechPioneers'
            ]),
            'prizes' => json_encode([
                '1st Place: $15,000',
                '2nd Place: $7,500',
                '3rd Place: $3,000',
                'Best Social Impact: $2,000',
                'Best Technical Solution: $2,000'
            ]),
            'rules' => json_encode([
                'Teams must have 3-5 members',
                'All code must be open source',
                'Must address a real-world problem',
                'Must use at least two sponsor technologies',
                'Final presentations must be 7 minutes or less'
            ]),
            'is_active' => true
        ]);
    }
} 