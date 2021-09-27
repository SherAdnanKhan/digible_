<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerProfile extends Model
{
    use HasFactory;
    const TYPE_INDIVIDUAL = 'individual';
    const TYPE_CARDHOUSE = 'cardhouse';
    const TYPE_DIGI = 'digi';
    const STATUS_PENDING = "pending";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECTED = "rejected";

    protected $guarded = ['created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public static function statuses(): array
    {
        return [
            static::STATUS_PENDING => "pending",
            static::STATUS_APPROVED => "approved",
            static::STATUS_REJECTED => "rejected",
        ];
    }
    public static function types(): array
    {
        return [
            static::TYPE_INDIVIDUAL => "individual",
            static::TYPE_CARDHOUSE => "cardhouse",
            static::TYPE_DIGI => "digi",
        ];
    }
}
