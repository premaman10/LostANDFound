<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoundItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'name',
        'description',
        'location',
        'date_found',
        'category',
        'image_path',
        'status',
        'tags',
        'lost_item_id',
    ];

    protected $casts = [
        'date_found' => 'date',
        'tags' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lostItem(): BelongsTo
    {
        return $this->belongsTo(LostItem::class, 'lost_item_id');
    }
}
