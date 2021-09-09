<?php

namespace App\Http\Requests\Collections;

use Illuminate\Foundation\Http\FormRequest;

class CollectionItemUpdateRequest extends FormRequest {
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
   'collection_item_type_id' => 'required',
   'collection_id' => 'required',
   'physical' => 'required',
   'name' => 'required|string|max:255|unique:collection_items',
   'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
   'status' => 'in:Pending,Approved,Rejected',
  ];
 }
}
