<?php

namespace App\Http\Requests\Collections;

use Illuminate\Foundation\Http\FormRequest;

class CollectionSaveRequest extends FormRequest {
 /**
  * Determine if the user is authorized to make this request.
  *
  * @return bool
  */
 public function authorize() {
  return true;
 }

 /**
  * Get the validation rules that apply to the request.
  *
  * @return array
  */
 public function rules() {
  return [
   'name' => 'required|string|max:255|unique:collections',
   'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
   'status' => 'in:Pending,Approved,Rejected',
  ];
 }
}
