<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionItemType extends Model {
 use HasFactory;
 /**
  * @OA\Schema(
  *     schema="Collectible",
  *     @OA\Property(
  *         property="name",
  *         type="string",
  *         example="John"
  *     )
  * )
  */

 /**
  * The attributes that are mass assignable.
  *
  * @var string[]
  */
 protected $fillable = [
  'name',
 ];

 protected $hidden = ['created_at', 'updated_at'];
}
