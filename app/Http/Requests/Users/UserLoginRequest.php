<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
 public function rules()
 {
  return [
   'email' => 'required|string|max:255|email|exists:users',
   'password' => 'required|string|min:6|max:255',
   'remember_me' => 'boolean',
  ];
 }
}
