<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'event_date',
        'duration',
        'description',
        'photo_path',
        'sport_type_id',
        'organizer_id',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function sportType()
    {
        return $this->belongsTo(SportType::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }
}