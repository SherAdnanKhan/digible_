<?php

namespace App\Http\Transformers\Users;

use App\Http\Transformers\BaseTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class TokenTransformer extends BaseTransformer
{
    public function transform($token)
    {
        return [
            'id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'role' => Auth::user()->roles->pluck('name'),
            'name' => Auth::user()->name,
            'timezone' => Auth::user()->timezone,
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $token->token->expires_at
        ];
    }
 }
