<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use HasFactory;

    const STATUS_PENDING = "pending";
    const STATUS_WON = "won";
    const STATUS_LOST = "lost";
    const STATUS_PURCHASED = "purchased";
    const STATUS_EXPIRED = "expired";

    protected $guarded = ['created_at'];

    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_WON => "success",
            static::STATUS_LOST => "failed",
            static::STATUS_EXPIRED => "expired",
        ];
    }

    public function collectionItem(): BelongsTo
    {
        return $this->belongsTo(CollectionItem::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }
}
