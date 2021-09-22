<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollectionItem extends Model
{
    use HasFactory;
    const STATUS_PENDING = "Pending";
    const STATUS_APPROVED = "Approved";
    const STATUS_REJECTED = "Rejected";
    const NFT_TYPE_BACKED = "backed";
    const NFT_TYPE_NON_BACKED = "non_backed";
    const NFT_TYPE_NON_NFT = "non_nft";

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
            static::STATUS_PENDING => "Pending",
            static::STATUS_APPROVED => "Approved",
            static::STATUS_REJECTED => "Rejected",
        ];
    }
    public static function nfttype(): array
    {
        return [
            static::NFT_TYPE_BACKED => "backed",
            static::NFT_TYPE_NON_BACKED => "non_backed",
            static::NFT_TYPE_NON_NFT => "non_nft",
        ];
    }
    public function favoriteUsers()
    {
        return Favourite::with('user')->where('collection_item_id', $this->id)
            ->get();
    }

}
