<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'hackathon_id',
        'team_id',
        'motivation',
        'experience',
        'skills',
        'status',
        'resume_url',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isWaitlisted()
    {
        return $this->status === 'waitlisted';
    }
} 