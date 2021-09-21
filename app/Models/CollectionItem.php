<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionItem extends Model
{
    use HasFactory;
    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";
    const TYPE_BACKED = "backed";
    const TYPE_NON_BACKED = "nonbacked";
    const TYPE_NON_NFT = "nonnft";

    protected $guarded = ['created_at'];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function collectionItemType(): BelongsTo
    {
        return $this->belongsTo(CollectionItemType::class);
    }
    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_APPROVED => "approved",
            static::STATUS_REJECTED => "rejected",
        ];
    }
    public static function nfttype(): array
    {
        return [
            static::TYPE_BACKED => "backed",
            static::TYPE_NON_BACKED => "nonbacked",
            static::TYPE_NON_NFT => "nonnft",
        ];
    }
}
