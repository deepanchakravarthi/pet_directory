<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterFormRequest extends Request {

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
		return [
			'user_type'	=> 'required',
			'salutation'=> 'required',
			'firstname'	=> 'required|min:3|max:30',
			'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users',
			'phone'		=> 'required',
			'password'	=> 'required|min:6|max:30',
			'confirm_password'	=> 'required|same:password',
			'address'	=> 'required|min:3|max:200',
			'zip'		=> 'required|min:3|max:30',
			'city'		=> 'required|min:3|max:200',
			'state'		=> 'required|min:3|max:200',
			'country'	=> 'required',
			'language'	=> 'required',
			'company'	=> 'min:3|max:200'
		];	
  }

}