<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    const WYRE_AUTH_URL = "https://jsonplaceholder.typicode.com/posts";
    const METHOD = "get";
    const PARAMS = ['param_a', 'param_a'];

    const NEW_ORDER = 0;
    const SUCCESS = 1;
    const FAILED = 2;
    const REFUNDED = 3;
    
    const DEBIT = 0;
    const CREDIT = 1;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
