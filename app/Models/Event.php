<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model {
    use HasFactory;
    protected $fillable = [
        'title','description','venue','city','country',
        'event_date','poster_image','tickets_url',
        'ticket_price','is_featured','is_active'
    ];
    protected $casts = [
        'is_featured'=>'boolean',
        'is_active'=>'boolean',
        'event_date'=>'datetime',
        'ticket_price'=>'decimal:2'
    ];

    public function artists() { return $this->belongsToMany(Artist::class); }

    public function getPosterUrlAttribute(): string {
        if (!$this->poster_image) return '';
        return str_starts_with($this->poster_image, 'http')
            ? $this->poster_image
            : asset('storage/'.$this->poster_image);
    }

    public function getFormattedDateAttribute(): string {
        return $this->event_date->format('D, M j, Y · g:i A');
    }

    public function getIsUpcomingAttribute(): bool {
        return $this->event_date->isFuture();
    }
}
