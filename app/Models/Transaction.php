<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    const WYRE_AUTH_URL= "https://jsonplaceholder.typicode.com/posts" ;
    const METHOD = "get";
    const PARAMS = ['param_a', 'param_a'] ;
    protected $fillable=['collection_item_id','user_id', 'payment_id', 'amount', 'quantity', 'currency'] ;
}
