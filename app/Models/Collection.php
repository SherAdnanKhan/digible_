<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model {
 use HasFactory;
 protected $fillable = [
  'name',
 ];

 protected $hidden = ['created_at', 'updated_at'];

 public function user(): BelongsTo {
  return $this->belongsTo(User::class);
 }
}
