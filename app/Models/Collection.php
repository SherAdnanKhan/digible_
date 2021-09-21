<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasFactory;

    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    protected $guarded = [
        'created_at',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->where(['status' => 'approved']);
    }

     public function collectionitems()
    {
        return $this->hasMany(CollectionItem::class);
    }

    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_APPROVED => "approved",
            static::STATUS_REJECTED => "rejected",
        ];
    }
}
