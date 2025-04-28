<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'leader_id',
        'hackathon_id',
        'max_members',
        'is_active',
        'logo_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_members' => 'integer',
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function isFull()
    {
        return $this->members()->count() >= $this->max_members;
    }
} 