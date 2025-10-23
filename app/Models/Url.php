<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_url',
        'short_code',
        'access_count',
    ];

    protected $casts = [
        'access_count' => 'integer',
    ];

    /**
     * Generate a unique short code for the URL
     */
    public static function generateShortCode(): string
    {
        do {
            $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
        } while (self::where('short_code', $code)->exists());

        return $code;
    }

    /**
     * Increment the access count
     */
    public function incrementAccessCount(): void
    {
        $this->increment('access_count');
    }

    /**
     * Get the full short URL
     */
    public function getShortUrlAttribute(): string
    {
        return url('/s/' . $this->short_code);
    }
}
