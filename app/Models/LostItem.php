<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LostItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'name',
        'description',
        'location',
        'date_lost',
        'category',
        'image_path',
        'status',
        'tags',
    ];

    protected $casts = [
        'date_lost' => 'date',
        'tags' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function foundItem(): HasOne
    {
        return $this->hasOne(FoundItem::class, 'matched_lost_item_id');
    }
}
