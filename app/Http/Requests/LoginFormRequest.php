<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginFormRequest extends Request {

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
		return [
			'email' 	=> 'required|email',
			'password'	=> 'required',
		];	
  }

}