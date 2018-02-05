<?php
namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;

use Mail;

use App\User;

use Validator;

use Session;

use Hash;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\LoginFormRequest;

use App\Http\Requests\RegisterFormRequest;

use App\Http\Requests\RegisterFormVetRequest;

use App\Http\Requests\RegisterFormAuthorityRequest;

use Illuminate\Support\Facades\Auth;

use Password;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

//use Illuminate\Auth\Passwords\PasswordBroker;

//use Illuminate\Foundation\Auth\ResetsPasswords;

class UserController extends Controller {
	
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	
	public function showLogin() {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		return view('user.login');
	}
	public function showPreRegister() {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		return view('user.pre-register');
	}
	public function showRegister() {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		return view('user.register');
	}
	
	public function doLogin(LoginFormRequest $request) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		$userdata = array(
			'email' 	=> $request->email,
			'password' 	=> $request->password,
			'status'	=> 0
		);
		$rememberMe	= ($request->persist == 1) ? 'true' : 'false';
		// attempt to do the login
		if (Auth::attempt($userdata, $rememberMe)) {
			Auth::login(User::find(Auth::user()->id));
			if (Auth::check()) {
				$languageArray	= array(1 => 'en', 'fr', 'de', 'it');
				Session::put('locale', $languageArray[Auth::user()->language]);
				\App::setLocale(Session::get('locale'));
				return redirect('index');
			}
		} else {
			// validation not successful, send back to form
			return redirect('login')->withErrors('Login Failed');
		}
	}
	
	public function doConfirm($id) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if($id != '') {
			$user			= User::find($id);
			$user->status	= 0;
			$result			= $user->save();
			$data			= array();
			
			if($result) {
				Mail::send('emails.confirm', $data, function($message) use ($user)
				{
					$message->to($user->email, $user->firstname.' '.$user->lastname )->subject('Account Activation');
				});
			}
			
			return redirect('login')->with('message', 'Your account is activated successfully!');
		}
	}
	
	public function doLogout()	{
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		Auth::logout();
		return redirect()->action('HomeController@showHome');
	}
	
	public function doRegister(RegisterFormRequest $request) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		$user			= new User();
		
		$user->user_type= $request->user_type;
		$user->salutation	= $request->salutation;
		$user->firstname= $request->firstname;
		$user->lastname	= $request->lastname;
		$user->email	= $request->email;
		$user->phone	= $request->phone;
		$user->password	= Hash::make($request->password);
		$user->address	= $request->address;
		$user->zip		= $request->zip;
		$user->city		= $request->city;
		$user->state	= $request->state;
		$user->country	= $request->country;
		$user->language	= $request->language;
		if ($request->has('company')) {
			$user->company	= $request->company;
		} else {
			$user->company	= '';
		}
		$user->status	= 0;
		$user->save();
		
		//$data	= array('name' => $user->firstname.' '.$user->lastname, 'password' => $request->password, 'id' => $user->id);
		
		$data	= array('name' => $user->firstname.' '.$user->lastname, 'email' => $user->email, 'password' => $request->password, 'id' => $user->id);
		Mail::send('emails.register', $data, function($message) use ($user)
		{
			$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_confirmation'));
		});
		//return redirect('register')->with('message', 'Account has been created successfully. We sent you a confirmation mail to activate your account. Please check your inbox.');		*/		
		
		$userdata	= array('email' => $request->email, 'password' => $request->password, 'status' => 0);
		$rememberMe	= 'false';		
		if (Auth::attempt($userdata, $rememberMe)) {			
			Auth::login(User::find(Auth::user()->id));			
			if(Auth::check()) {				
				$languageArray	= array(1 => 'en', 'fr', 'de', 'it');
				Session::put('locale', $languageArray[Auth::user()->language]);
				\App::setLocale(Session::get('locale'));
				return redirect('index')->with('message', 'Thank you! Your account has been created successfully.');			
			}		
		}
	}
	
	public function doRegisterVet(RegisterFormVetRequest $request) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		$user			= new User();
		
		$user->user_type= $request->user_type;
		$user->salutation	= $request->salutation;
		$user->firstname= $request->firstname;
		$user->lastname	= $request->lastname;
		$user->email	= $request->email;
		$user->phone	= $request->phone;
		$user->password	= Hash::make($request->password);
		$user->address	= $request->address;
		$user->zip		= $request->zip;
		$user->city		= $request->city;
		$user->state	= $request->state;
		$user->country	= $request->country;
		$user->language	= $request->language;
		$user->company	= $request->company;
		$user->register_number	= $request->register_number;
		$user->status	= 0;
		$user->save();
		
		//$data	= array('name' => $user->firstname.' '.$user->lastname, 'password' => $request->password, 'id' => $user->id);
		
		$data	= array('name' => $user->firstname.' '.$user->lastname, 'email' => $user->email, 'password' => $request->password, 'id' => $user->id);
		Mail::send('emails.register', $data, function($message) use ($user)
		{
			$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_confirmation'));
		});
		//return redirect('register')->with('message', 'Account has been created successfully. We sent you a confirmation mail to activate your account. Please check your inbox.');		*/		
		
		$userdata	= array('email' => $request->email, 'password' => $request->password, 'status' => 0);
		$rememberMe	= 'false';		
		if (Auth::attempt($userdata, $rememberMe)) {			
			Auth::login(User::find(Auth::user()->id));			
			if(Auth::check()) {				
				return redirect('index')->with('message', 'Thank you! Your account has been created successfully.');			
			}		
		}
	}
	public function doRegisterAuthority(RegisterFormAuthorityRequest $request) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		$user			= new User();
		
		$user->user_type= $request->user_type;
		$user->salutation	= $request->salutation;
		$user->firstname= $request->firstname;
		$user->lastname	= $request->lastname;
		$user->email	= $request->email;
		$user->phone	= $request->phone;
		$user->password	= Hash::make($request->password);
		
		$user->address	= $request->address;
		$user->zip		= $request->zip;
		$user->city		= $request->city;
		$user->state	= $request->state;
		$user->country	= $request->country;
		$user->language	= $request->language;
		$user->authority_name	= $request->authority_name;
		$user->supervisor_name	= $request->supervisor_name;
		$user->supervisor_email	= $request->supervisor_email;
		$user->supervisor_phone	= $request->supervisor_phone;
		$user->status	= 1;
		$user->save();
		
		//$data	= array('name' => $user->firstname.' '.$user->lastname, 'password' => $request->password, 'id' => $user->id);
		
		$data	= array('name' => $user->firstname.' '.$user->lastname, 'email' => $user->email, 'password' => $request->password, 'id' => $user->id, 'customtext' =>  trans('words.reg-authority-message-mail'));
		Mail::send('emails.register', $data, function($message) use ($user)
		{
			$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_confirmation'));
		});
		
		$admins	= User::where('user_type', '=', 4)->get();
		foreach($admins as $key => $value) {
			$user	= new \stdClass;
			$user->email	= $value->email;
			$user->name		= $value->firstname.' '.$value->lastname;
			
			$data	= array('role' => trans('words.authority'), 'name' => $user->name);
			Mail::send('emails.register-admin-notify', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->name)->subject(trans('words.ctrl_notification'));
			});
			
		}
		return redirect('register?user_type=authority')->with('message', trans('words.reg-authority-message'));		
		
	}
	
	public function showProfile() {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		return view('user.my-profile')->with('user', $userArray);
	}
	public function editProfile() {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		return view('user.edit-profile')->with('user', $userArray);
	}
	public function doUpdateProfile(Request $request) {
		\App::setLocale(Session::get('locale'));
		$user			= Auth::user();
		$validator = Validator::make($request->all(), [
            //'user_type'	=> 'required',
			//'salutation'=> 'required',
			//'firstname'	=> 'required|min:3|max:30',
			//'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users,email,'.Auth::user()->id,
			'phone'		=> 'required',
			'password'	=> 'min:6|max:30',
			'confirm_password'	=> 'same:password',
			'address'	=> 'required|min:3|max:200',
			'zip'		=> 'required|min:3|max:30',
			'city'		=> 'required|min:3|max:200',
			'state'		=> 'required|min:3|max:200',
			'country'	=> 'required',
			'language'	=> 'required',
			'company'	=> 'min:3|max:200'
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			if ($request->has('password')) {
				$user->user_type= $request->user_type;
			}
			//$user->salutation	= $request->salutation;
			//$user->firstname= $request->firstname;
			//$user->lastname	= $request->lastname;
			$user->email	= $request->email;
			$user->phone	= $request->phone;
			if ($request->has('password')) {
				$user->password	= Hash::make($request->password);
			}
			$user->address	= $request->address;
			$user->zip		= $request->zip;
			$user->city		= $request->city;
			$user->state	= $request->state;
			$user->country	= $request->country;
			$user->language	= $request->language;
			if($request->language == 1) {
				$locale	= 'en';
			} else if($request->language == 2) {
				$locale	= 'fr';
			} else if($request->language == 3) {
				$locale	= 'de';
			} else if($request->language == 4) {
				$locale	= 'it';
			}
			Session::put('locale', $locale);
			
			if ($request->has('company')) {
				$user->company	= $request->company;
			} else {
				$user->company	= '';
			}
			$user->permission	= $request->permission;
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			return redirect('my-profile')->with('message', trans('words.ctrl_profile_updated'));
		}
	}
	public function doUpdateProfileVet(Request $request) {
		\App::setLocale(Session::get('locale'));
		$user			= Auth::user();
		$validator = Validator::make($request->all(), [
            //'user_type'	=> 'required',
			//'salutation'=> 'required',
			//'firstname'	=> 'required|min:3|max:30',
			//'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users,email,'.Auth::user()->id,
			'phone'		=> 'required',
			'password'	=> 'min:6|max:30',
			'confirm_password'	=> 'same:password',
			'address'	=> 'required|min:3|max:200',
			'zip'		=> 'required|min:3|max:30',
			'city'		=> 'required|min:3|max:200',
			'state'		=> 'required|min:3|max:200',
			'country'	=> 'required',
			'language'	=> 'required',
			'company'	=> 'required|min:3|max:200',
			'register_number'	=> 'required|min:3|max:200',
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			if ($request->has('password')) {
				$user->user_type= $request->user_type;
			}
			//$user->salutation	= $request->salutation;
			//$user->firstname= $request->firstname;
			//$user->lastname	= $request->lastname;
			$user->email	= $request->email;
			$user->phone	= $request->phone;
			if ($request->has('password')) {
				$user->password	= Hash::make($request->password);
			}
			$user->address	= $request->address;
			$user->zip		= $request->zip;
			$user->city		= $request->city;
			$user->state	= $request->state;
			$user->country	= $request->country;
			$user->language	= $request->language;
			if($request->language == 1) {
				$locale	= 'en';
			} else if($request->language == 2) {
				$locale	= 'fr';
			} else if($request->language == 3) {
				$locale	= 'de';
			} else if($request->language == 4) {
				$locale	= 'it';
			}
			Session::put('locale', $locale);
			
			$user->company	= $request->company;
			$user->register_number	= $request->register_number;
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			return redirect('my-profile')->with('message', trans('words.ctrl_profile_updated'));
		}
	}
	public function doUpdateProfileAuthority(Request $request) {
		\App::setLocale(Session::get('locale'));
		$user			= Auth::user();
		$validator = Validator::make($request->all(), [
            //'user_type'	=> 'required',
			//'salutation'=> 'required',
			//'firstname'	=> 'required|min:3|max:30',
			//'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users,email,'.Auth::user()->id,
			'phone'		=> 'required',
			'password'	=> 'min:6|max:30',
			'confirm_password'	=> 'same:password',
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
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			if ($request->has('password')) {
				$user->user_type= $request->user_type;
			}
			//$user->salutation	= $request->salutation;
			//$user->firstname= $request->firstname;
			//$user->lastname	= $request->lastname;
			$user->email	= $request->email;
			$user->phone	= $request->phone;
			if ($request->has('password')) {
				$user->password	= Hash::make($request->password);
			}
			$user->address	= $request->address;
			$user->zip		= $request->zip;
			$user->city		= $request->city;
			$user->state	= $request->state;
			$user->country	= $request->country;
			$user->language	= $request->language;
			if($request->language == 1) {
				$locale	= 'en';
			} else if($request->language == 2) {
				$locale	= 'fr';
			} else if($request->language == 3) {
				$locale	= 'de';
			} else if($request->language == 4) {
				$locale	= 'it';
			}
			Session::put('locale', $locale);
			
			$user->authority_name	= $request->authority_name;
			$user->supervisor_name	= $request->supervisor_name;
			$user->supervisor_phone	= $request->supervisor_phone;
			$user->supervisor_email	= $request->supervisor_email;
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			return redirect('my-profile')->with('message', trans('words.ctrl_profile_updated'));
		}
	}
	public function showForgotPassword() {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		return view('user.forgot-password');
	}
	
	public function doForgotPassword(Request $request) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		// validate the info, create rules for the inputs
		$validator = Validator::make($request->all(), [
			'email'    => 'required|email', // make sure the email is an actual email
		]);

        if ($validator->fails()) {
			return back()->withInput()->withErrors($validator); // send back all errors to the login form
		} else {
			
			$response = Password::sendResetLink($request->only('email'), function($message)
			{
				$message->subject(trans('words.ctrl_password_reminder'));
			});

			switch ($response)
			{
				case PasswordBroker::RESET_LINK_SENT:
					return redirect()->back()->with('message', trans($response));

				case PasswordBroker::INVALID_USER:
					return redirect()->back()->withErrors(['email' => trans($response)]);
			}
		}
		
	}
	
	public function showReset($token) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		return view('user.reset')->with('token', $token);
	}
	
	public function doReset(Request $request) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if(Auth::user()) {
			return redirect('index');
		}
		$messages = [
			'passwords.token'	=> trans('words.ctrl_invalid_token'),
			'passwords.user'	=> trans('words.ctrl_invalid_email'),
		];
		// validate the info, create rules for the inputs
		$validator = Validator::make($request->all(), [
			'email'		=> 'required|email', // make sure the email is an actual email
			'password'	=> 'required|min:6|max:30',
			'password_confirmation'	=> 'required|min:6|max:30|same:password',
		], $messages);
		
		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}
		
		$credentials	= array('email' => $request->input('email'),
								'password' => $request->input('password'),
								'password_confirmation' => $request->input('password_confirmation'),
								'token' => $request->input('token')
								);
		
		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);
			$user->save();
		});
		
		switch ($response)
		{
			case Password::INVALID_PASSWORD:
				return back()->withErrors($response)->withInput();
			case Password::INVALID_TOKEN:
				return back()->withErrors(trans('words.ctrl_password_reset_invalid'))->withInput();
			case Password::INVALID_USER:
				return back()->withErrors(trans('words.ctrl_password_reset_invalid_email'))->withInput();
			case Password::PASSWORD_RESET:
				return redirect('login')->with('message', trans('words.ctrl_password_resetted'));
		}
	}
	
}