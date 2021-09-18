<?php

namespace App\Http\Requests\Comments;

use App\Models\Comment;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['string', 'max:255', Rule::in(array_keys(Comment::statuses()))],
        ];
    }
}
