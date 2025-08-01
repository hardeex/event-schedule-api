<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
     use SoftDeletes;
    protected $fillable = ['name', 'start_datetime', 'end_datetime', 'max_participants'];
    
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $event->slug = static::generateUniqueSlug($event->name);
        });
    }

   
    protected static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }


    public function getRouteKeyName()
{
    return 'slug';
}



    public function participants()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function isFull()
    {
        return $this->participants()->count() >= $this->max_participants;
    }

    public function hasOverlap($userId)
    {
        return Event::whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->where(function ($query) {
            $query->whereBetween('start_datetime', [$this->start_datetime, $this->end_datetime])
                  ->orWhereBetween('end_datetime', [$this->start_datetime, $this->end_datetime])
                  ->orWhere(function ($q) {
                      $q->where('start_datetime', '<=', $this->start_datetime)
                        ->where('end_datetime', '>=', $this->end_datetime);
                  });
        })
        ->exists();
    }
}