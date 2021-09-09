<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollectionItem extends Model {
 use HasFactory;

 public function collection(): BelongsTo {
  return $this->belongsTo(Collection::class);
 }

 public function collectionItemType(): BelongsTo {
  return $this->belongsTo(CollectionItemType::class);
 }
}
