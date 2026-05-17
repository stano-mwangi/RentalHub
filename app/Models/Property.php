<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'address',
        'price',
        'status',
        'latitude',
        'longitude',
        'image_path',
        'user_id'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
