<?php

namespace Database\Seeders;

use App\Models\Hackathon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HackathonLogosSeeder extends Seeder
{
    public function run()
    {
        // Sample hackathon logos
        $logos = [
            'hackathon1.jpg' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800',
            'hackathon2.jpg' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800',
            'hackathon3.jpg' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800',
            'hackathon4.jpg' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800',
            'hackathon5.jpg' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800',
        ];

        // Create the hackathon-logos directory if it doesn't exist
        Storage::disk('public')->makeDirectory('hackathon-logos');

        // Get all hackathons
        $hackathons = Hackathon::all();

        foreach ($hackathons as $index => $hackathon) {
            // Get a logo URL from the array (cycling through them)
            $logoName = array_keys($logos)[$index % count($logos)];
            $logoUrl = $logos[$logoName];

            // Download and save the image
            $imageContent = file_get_contents($logoUrl);
            Storage::disk('public')->put('hackathon-logos/' . $logoName, $imageContent);

            // Update the hackathon with the new logo URL
            $hackathon->update([
                'logo_url' => 'hackathon-logos/' . $logoName
            ]);

            $this->command->info("Added logo for hackathon: " . $hackathon->name);
        }
    }
} 