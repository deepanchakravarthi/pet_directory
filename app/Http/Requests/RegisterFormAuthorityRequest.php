<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterFormAuthorityRequest extends Request {

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
			'authority_name'	=> 'required|min:3|max:200',
			'supervisor_name'	=> 'required|min:3|max:200',
			'supervisor_email'	=> 'required|email',
			'supervisor_phone'	=> 'required|min:3|max:200',
		];	
  }

}