<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PENDING = 0;
    const COMPLETED = 1;

    public function currency(): string
    {
        switch ($this->currency) {
            case 'USD':return '$';
            case 'SAR':return 'SR';
            default:return $this->currency;
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collectionItem(): BelongsToMany
    {
        return $this->belongsToMany(CollectionItem::class)->withPivot('quantity');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(OrderTransaction::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public static function statuses(): array
    {
        return [
            static::PENDING => 0,
            static::COMPLETED => 1,
        ];
    }

}
