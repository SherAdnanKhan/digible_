<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=['collection_item_id','user_id', 'payment_id', 'amount', 'quantity', 'currency'] ;
}
