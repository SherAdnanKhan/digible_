<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionItem extends Model
{
    use HasFactory;
    const STATUS_PENDING = "Pending";
    const STATUS_APPROVED = "Approved";
    const STATUS_REJECTED = "Rejected";

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
}
