<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Hackathon extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo_url',
        'website_url',
        'registration_start',
        'registration_end',
        'event_start',
        'event_end',
        'location',
        'challenges',
        'sponsors',
        'prizes',
        'rules',
        'is_active',
        'organizer_id',
    ];

    protected $casts = [
        'registration_start' => 'datetime',
        'registration_end' => 'datetime',
        'event_start' => 'datetime',
        'event_end' => 'datetime',
        'is_active' => 'boolean',
        'challenges' => 'array',
        'sponsors' => 'array',
        'prizes' => 'array',
        'rules' => 'array',
    ];

    protected $appends = ['logo_url_full'];

    public function getLogoUrlFullAttribute()
    {
        if ($this->logo_url) {
            return asset('storage/' . $this->logo_url);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function isRegistrationOpen()
    {
        $now = now();
        return $now->between($this->registration_start, $this->registration_end);
    }

    public function isEventActive()
    {
        $now = now();
        return $now->between($this->event_start, $this->event_end);
    }
} 