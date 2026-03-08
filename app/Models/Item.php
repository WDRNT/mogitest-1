<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Condition;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'brand',
        'condition_id',
        'description',
        'price',
        'status'
    ];

    public function getImageUrlAttribute()
    {
        return str_starts_with($this->image, 'items/')
        ? asset('storage/' . $this->image)
        : asset($this->image);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function buyers()
    {
        return $this->belongsToMany(User::class, 'purchases')
            ->withPivot(['amount','payment_method','status'])
            ->withTimestamps();
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }


}
