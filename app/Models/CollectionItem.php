<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CollectionItem extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *     schema="CollectionItem",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="collection_item_type_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="collection_id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Cresselia"
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="string",
     *         example="sdasdwre32r.jpg"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         example="Digtal asset backed by 160 physical asset"
     *     ),
     *     @OA\Property(
     *         property="edition",
     *         type="string",
     *         example="ist"
     *     ),
     *     @OA\Property(
     *         property="graded",
     *         type="enum",
     *         example="yes"
     *     ),
     *     @OA\Property(
     *         property="year",
     *         type="date",
     *         example="2019-03-10 02:00:39"
     *     ),
     *     @OA\Property(
     *         property="population",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="publisher",
     *         type="string",
     *         example="2019-03-10 02:00:39"
     *     ),
     *     @OA\Property(
     *         property="available_for_sale",
     *         type="boolean",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="price",
     *         type="double",
     *         example=10
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-10-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         example="22020-10-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="collection",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/Collection")
     *         }
     *     ),
     *     @OA\Property(
     *         property="collectionItemType",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/CollectionItemType")
     *         }
     *     ),
     * )
     */

    protected $guarded = ['created_at'];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return $this->image ? asset('/' . $this->image) : null;
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function collectionItemType(): BelongsTo
    {
        return $this->belongsTo(CollectionItemType::class);
    }

    public function auction(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    public function lastBet(): HasOne
    {
        return $this->hasOne(Auction::class)->where('status', 'pending')->orderBy('created_at', 'DESC');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->where(['status' => 'approved']);
    }

    public function favoriteUsers()
    {
        return Favourite::with('user')->where('collection_item_id', $this->id)
            ->get();
    }

    public function favorites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function setAvailableAtAttribute($value)
    {
        $user_date = date('Y-m-d H:i:s', strtotime($value));
        # convert user date to utc date
        $utc_date = Carbon::createFromFormat('Y-m-d H:i:s', $user_date, auth()->user()->timezone);

        $utc_date->setTimezone('UTC');
        $this->attributes['available_at'] = $utc_date;
    }

    public function getAvailableAtAttribute($value)
    {
        if ($value != null && auth()->user()) {
            # using utc date convert date to user date
            $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $value, 'UTC');
            $user_date->setTimezone(auth()->user()->timezone);
            return $user_date;
        }
        return $value;
    }

    public function setStartDateAttribute($value)
    {
        // dd($value);
        $user_date = date('Y-m-d H:i:s', strtotime($value));
        # convert user date to utc date
        $utc_date = Carbon::createFromFormat('Y-m-d H:i:s', $user_date, auth()->user()->timezone);

        $utc_date->setTimezone('UTC');
        $this->attributes['start_date'] = $utc_date;
    }

    public function getStartDateAttribute($value)
    {
        if ($value != null && auth()->user()) {
            # using utc date convert date to user date
            $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $value, 'UTC');
            $user_date->setTimezone(auth()->user()->timezone);
            return $user_date;
        }
        return $value;
    }

    public function setEndDateAttribute($value)
    {
        $user_date = date('Y-m-d H:i:s', strtotime($value));
        # convert user date to utc date
        $utc_date = Carbon::createFromFormat('Y-m-d H:i:s', $user_date, auth()->user()->timezone);

        $utc_date->setTimezone('UTC');
        $this->attributes['end_date'] = $utc_date;
    }

    public function getEndDateAttribute($value)
    {
        if ($value != null && auth()->user()) {
            # using utc date convert date to user date
            $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $value, 'UTC');
            $user_date->setTimezone(auth()->user()->timezone);
            return $user_date;
        }
        return $value;
    }

}
