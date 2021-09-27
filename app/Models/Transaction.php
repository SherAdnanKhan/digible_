<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=['collection_item_id','user_id', 'payment_id', 'amount', 'quantity', 'currency'] ;
    const WYRE_AUTH_URL= "https://jsonplaceholder.typicode.com/posts" ;
    const METHOD = "get";
    const PARAM_A = "param_a" ;
    const PARAM_B = "param_b" ;
    const PARAM = [
        PARAM_A,
        PARAM_B
    ] ;
}
