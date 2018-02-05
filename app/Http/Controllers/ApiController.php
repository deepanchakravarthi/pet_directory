<?php
namespace App\Http\Controllers;

use DB;

use Mail;

use App\User;

use App\Pet;

use App\SendOffer;

use App\PetNotes;

use App\Subscription;

use App\Payment;

use App\AuthorityLog;

use Validator;

use Session;

use Hash;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\LoginFormRequest;

use App\Http\Requests\RegisterFormRequest;

use Illuminate\Support\Facades\Auth;

class ApiController extends Controller {
	public function doRegisterVet(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
            'user_type'	=> 'required',
			'salutation'=> 'required',
			'firstname'	=> 'required|min:3|max:30',
			'lastname'	=> 'required|min:3|max:30',
			'company'	=> 'required|min:3|max:200',
			'register_number'	=> 'required|min:3|max:200',
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
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
				
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
			$response['vet']	= $user;
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function doRegisterAuthority(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
				
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
			$authority	= $user;
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
			$response['authority']	= $authority;
			$response['code']	= 1;	//	success
			echo json_encode($response);	
		}
	}
	public function doLogin(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
            'email' 	=> 'required|email',
			'password'	=> 'required',
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
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
					$response['code']	= 1;	//	success
					$response['user']	= Auth::user();
					echo json_encode($response);
				}
			} else {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_something_wrong');
				echo json_encode($response);
			}
		}
	}
	public function doForgotPassword(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		// validate the info, create rules for the inputs
		$validator = Validator::make($request->all(), [
			'email'    => 'required|email', // make sure the email is an actual email
		]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			
			$response = Password::sendResetLink($request->only('email'), function($message)
			{
				$message->subject(trans('words.ctrl_password_reminder'));
			});

			switch ($response)
			{
				case PasswordBroker::RESET_LINK_SENT:
					$response['code']	= 0;	// error
					$response['message']= trans($response);
					echo json_encode($response);
				case PasswordBroker::INVALID_USER:
					$response['code']	= 0;	// error
					$response['message']= trans($response) ;
					echo json_encode($response);
			}
		}
		
	}
	public function doRegister(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			
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
			
			$data	= array('name' => $user->firstname.' '.$user->lastname, 'email' => $user->email, 'password' => $request->password, 'id' => $user->id);
			Mail::send('emails.register', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_confirmation'));
			});
			//return redirect('register')->with('message', 'Account has been created successfully. We sent you a confirmation mail to activate your account. Please check your inbox.');		*/		
			$response['owner']	= $user;
			$response['code']	= 1;	//	success
			echo json_encode($response);
			die();
		}
	}
	public function showMyPets(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
            'id'	=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$user	= User::find($request->id);
			if(!$user) {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_something_wrong');
				echo json_encode($response);
			}
			if($user->user_type == 2) {
				$subscription	= Subscription::where('vet_id', '=', $user->id)->where('status', '=', 1)->count();
				if($subscription > 0) {
					$pets		= Pet::where('vet_id', '=', $userArray->id)->get();
				} else {
					if(!$user) {
						$response['code']	= 0;	// error
						$response['message']= trans('words.ctrl_activate_subscription');
						echo json_encode($response);
					}
				}
			} else if($request->user_type == 4) {
				$pets		= Pet::get();
			} else {
				$pets		= Pet::where('owner_id', '=', $user->id)->get();
			}
			
			$response['pets']	= $pets;
			$offers		= SendOffer::where('new_owner_email', '=', $user->email)->where('status', '=', 0)->get();
			$response['offers']	= $offers;
			
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function createPet() {
		\App::setLocale(Session::get('locale'));
		return view('user.create-pet');
	}
	public function doInsertPet(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$validator = Validator::make($request->all(), [
            'name'			=> 'required|min:3|max:250',
			'species'		=> 'required',
			'color'			=> 'required',
			'id'			=> 'required'
		]);
		
        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$user_id	= $request->input('id');
			$userArray	= User::find($user_id);
			if(!$userArray) {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_something_wrong');
				echo json_encode($response);
				die();
			}
			
			if (!$request->has('pet_id') && !$request->has('chip_id') && !$request->has('tattoo_id')) {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_pet_id_must');
				echo json_encode($response);
				die();
			} 
			$pet				= new Pet();
			$pet->name			= $request->input('name');
			$pet->species		= $request->input('species');
			if ($request->has('color')) {
				$pet->color		= $request->input('color');
			}
			if ($request->has('strain')) {
				$pet->strain	= $request->input('strain');
			}
			if ($request->has('gender')) {
				$pet->gender	= $request->input('gender');
			}
			if ($request->has('geld')) {
				$pet->geld		= $request->input('geld');
			}
			if ($request->has('country_of_birth')) {
				$pet->country_of_birth	= $request->input('country_of_birth');
			}
			if ($request->has('date_of_birth')) {
				$date	= explode('/', $request->input('date_of_birth'));
				$pet->date_of_birth		= $date[2].'-'.$date[0].'-'.$date[1];
			}
			if ($request->has('chip_id')) {
				$pet->chip_id		= $request->input('chip_id');
			}
			if ($request->has('pass_id')) {
				$pet->pass_id		= $request->input('pass_id');
			}
			if ($request->has('tattoo_id')) {
				$pet->tattoo_id		= $request->input('tattoo_id');
			}
			if ($request->has('tattoo_location')) {
				$pet->tattoo_location	= $request->input('tattoo_location');
			}
			if ($request->has('pet_id')) {
				$pet->pet_id			= $request->input('pet_id');
			}
			if ($request->has('characteristics')) {
				$pet->characteristics	= $request->input('characteristics');
			}
			if($userArray->user_type == 1) {
				$pet->owner_id		= $userArray->id;
			} else if($userArray->user_type == 2) {
				//	Need to check
				$pet->owner_id		= $userArray->id;
				$pet->vet_id		= $userArray->id;
			} else if($userArray->user_type == 4) {
				//	Need to check
				$pet->owner_id		= $userArray->id;
			} else if($userArray->user_type == 3) {
				$pet->authority_id		= $userArray->id;	
			}
			if ($request->has('permission')) {
				$pet->permission	= $request->input('permission');
			}
			$result	= $pet->save();
			$response['pet']	= $pet;
			$response['code']	= 1;	//	success
			echo json_encode($response);
			die();
		}
	}
	public function editPet($id) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		
		if($userArray->user_type == 2) {
			$pet	= Pet::where('id', '=', $id)->where('vet_id', '=', $userArray->id)->first();
		} else if($userArray->user_type == 1) {
			$pet	= Pet::where('id', '=', $id)->where('owner_id', '=', $userArray->id)->first();
		} else if($userArray->user_type == 4) {
			$pet	= Pet::where('id', '=', $id)->first();
		}
		if(!$pet) {
			return redirect('my-pets')->withErrors(trans('words.ctrl_data_not_avail'));
		}
		if($pet->count() == 0) {
			return redirect('my-pets')->withErrors(trans('words.ctrl_no_access'));
		}
		
		return view('user.edit-pet')->with('pet', $pet);
	}
	public function doUpdatePet(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$validator = Validator::make($request->all(), [
            'name'			=> 'required|min:3|max:250',
			'species'		=> 'required',
			'color'			=> 'required',
			'user_id'		=> 'required',
			'id'			=> 'required'
		]);
		
        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$userArray	= User::find( $request->input('user_id'));
			if (!$request->has('pet_id') && !$request->has('chip_id') && !$request->has('tattoo_id')) {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_pet_id_must');
				echo json_encode($response);
			} 
			$pet				= Pet::find($request->input('id'));
			$pet->name			= $request->input('name');
			$pet->species		= $request->input('species');
			
			if($userArray->user_type != 1) {
				if ($request->has('is_pet_id') && $request->input('is_pet_id') == 1) {
					$pet->is_pet_id	= 1;
				} else {
					$pet->is_pet_id	= 0;
				}
			}
			if ($request->has('color')) {
				$pet->color		= $request->input('color');
			}
			if ($request->has('strain')) {
				$pet->strain	= $request->input('strain');
			}
			if ($request->has('gender')) {
				$pet->gender	= $request->input('gender');
			}
			if ($request->has('geld')) {
				$pet->geld		= $request->input('geld');
			}
			if ($request->has('country_of_birth')) {
				$pet->country_of_birth	= $request->input('country_of_birth');
			}
			if ($request->has('date_of_birth')) {
				$date	= explode('/', $request->input('date_of_birth'));
				$pet->date_of_birth		= $date[2].'-'.$date[0].'-'.$date[1];
			}
			if ($request->has('chip_id')) {
				$pet->chip_id		= $request->input('chip_id');
			}
			if ($request->has('pass_id')) {
				$pet->pass_id		= $request->input('pass_id');
			}
			if ($request->has('tattoo_id')) {
				$pet->tattoo_id		= $request->input('tattoo_id');
			}
			if ($request->has('tattoo_location')) {
				$pet->tattoo_location	= $request->input('tattoo_location');
			}
			if ($request->has('pet_id')) {
				$pet->pet_id			= $request->input('pet_id');
			}
			if ($request->has('characteristics')) {
				$pet->characteristics	= $request->input('characteristics');
			}
			if($userArray->user_type == 1) {
				$pet->owner_id		= $userArray->id;
			} else if($userArray->user_type == 2) {
				$pet->vet_id		= $userArray->id;
			} else if($userArray->user_type == 3) {
				$pet->authority_id		= $userArray->id;	
			}
			$pet->permission	= $request->input('permission');
			$result	= $pet->save();
			$response['code']	= 1;	//	success
			echo json_encode($response);
			die();
		}
	}
	public function doPetFound(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$validator = Validator::make($request->all(), [
            'id'	=> 'required',
			'user_id'	=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$userArray	= User::find($request->input('user_id'));
			if($userArray->user_type == 4) {
				$pet	= Pet::where('id', '=', $request->input('id'))->first();
			} else {
				//$pet				= Pet::where('owner_id', '=', $userArray->id)->where('id', '=', $request->input('pet_id'))->first();
				$pet	= Pet::where('id', '=', $request->input('id'))
							->where(function($query) use ($userArray) {
								return $query->where('owner_id', '=', $userArray->id)
									->orWhere('vet_id', '=', $userArray->id);
							})->first();
			}
			if ($pet) {
				$pet->lost_date		= '';
				$pet->lost_location	= '';
				$pet->lost_time		= '';
				$pet->save();
				$response['code']	= 1;	//	success
				echo json_encode($response);
			} else {
				$response['code']	= 0;	//	success
				$response['message']= trans('words.ctrl_data_not_avail');
				echo json_encode($response);
			}
		}
		die();
	}
	public function doPetLost(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
            'id'		=> 'required',
			'lost_location' => 'required',
			'lost_date' => 'required',
			'lost_time' => 'required',
			'user_id'	=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$userArray	= User::find($request->input('user_id'));
		
			//$pet				= Pet::where('owner_id', '=', $userArray->id)->where('id', '=', $request->input('pet_id'))->first();
			if($userArray->user_type == 4) {
				$pet	= Pet::where('id', '=', $request->input('id'))->first();
			} else {
				$pet	= Pet::where('id', '=', $request->input('id'))
							->where(function($query) use ($userArray) {
								return $query->where('owner_id', '=', $userArray->id)
									->orWhere('vet_id', '=', $userArray->id);
							})->first();
			}
			if ($pet) {
				$date				= explode('/', $request->input('lost_date'));
				$pet->lost_date		= $date[2].'-'.$date[0].'-'.$date[1];
				$pet->lost_location	= $request->input('lost_location');
				$pet->lost_time		= $request->input('lost_time');
				$pet->save();
				$response['code']	= 1;	//	success
				echo json_encode($response);
			} else {
				$response['code']	= 0;	//	success
				$response['message']= trans('words.ctrl_data_not_avail');
				echo json_encode($response);
			}
		}
		die();
	}
	public function viewPet($id, $user_id) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$userArray	= User::find($user_id);
		
		if($userArray->user_type == 2) {
			$pet	= Pet::where('id', '=', $id)->where('vet_id', '=', $userArray->id)->first();
		} else if($userArray->user_type == 1) {
			$pet	= Pet::where('id', '=', $id)->where('owner_id', '=', $userArray->id)->first();
		} else if($userArray->user_type == 4) {
			$pet	= Pet::where('id', '=', $id)->first();
		}
		
		if(!$pet) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_data_not_avail');
			echo json_encode($response);
		}
		if($pet->count() == 0) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_no_access');
			echo json_encode($response);
		}
		
		$notes	= PetNotes::where('pet_id', '=', $id)->get();
		$response['pet']	= $pet;
		$response['notes']	= $notes;
		$response['code']	= 1;	//	success
		echo json_encode($response);
		die();
	}
	//	Users
	public function showMyUsers($id) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$userArray	= User::find($id);
		if($userArray->user_type == 2) {
			$subscription	= Subscription::where('vet_id', '=', $userArray->id)->where('status', '=', 1)->count();
			if($subscription > 0) {
				$pet	= Pet::where('vet_id', '=', $userArray->id)->lists('owner_id');
				$users	= User::whereIn('id', $pet)->get();
			} else {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_activate_subscription');
				echo json_encode($response);
				die();
			}
			$response['owner']	= $users;
		} else if($userArray->user_type == 4) {
			$users		= User::where('user_type', '=', 1)->get();
			$response['owner']	= $users;
			
			$vet		= User::where('user_type', '=', 2)->get();
			$response['vet']	= $vet;
			
			$auth		= User::where('user_type', '=', 3)->get();
			$response['authority']	= $auth;
			
			$admins		= User::where('user_type', '=', 4)->where('id', '!=', Auth::user()->id)->get();
			$response['admin']	= $admins;
			
		}
		$response['code']	= 1;	//	success
		echo json_encode($response);
	}
	public function doViewUser($id) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$user	= User::find($id);
		if(!$user) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		}
		
		$offers		= SendOffer::where('new_owner_email', '=', $user->email)->where('status', '=', 0)->get();
		view()->share('offers', $offers);
		$response['user']	= $user;
		$response['offer']	= $offers;
		$response['code']	= 1;	//	success
		echo json_encode($response);
	}
	public function doEditUser($id) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		if($userArray->user_type == 1) {
			return redirect('index');
		}
		$user	= User::find($id);
		if(!$user) {
			return redirect('index');
		}
		return view('user.edit-user')->with('user', $user);
	}
	public function doEditVet($id) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		if($userArray->user_type == 1) {
			return redirect('index');
		}
		$user	= User::find($id);
		if(!$user) {
			return redirect('index');
		}
		return view('user.edit-vet')->with('user', $user);
	}
	public function doEditAuthority($id) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		if($userArray->user_type == 1) {
			return redirect('index');
		}
		$user	= User::find($id);
		if(!$user) {
			return redirect('index');
		}
		return view('user.edit-authority')->with('user', $user);
	}
	public function doEditAdmin($id) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		if($userArray->user_type == 1) {
			return redirect('index');
		}
		$user	= User::find($id);
		if(!$user) {
			return redirect('index');
		}
		return view('user.edit-admin')->with('user', $user);
	}
	public function doUpdateUser(Request $request) {
		\App::setLocale(Session::get('locale'));
		$validator = Validator::make($request->all(), [
            'user_type'	=> 'required',
			'salutation'=> 'required',
			'firstname'	=> 'required|min:3|max:30',
			'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users,email,'.$request->user_id,
			'phone'		=> 'required',
			'password'	=> 'min:6|max:30',
			'confirm_password'	=> 'same:password',
			'address'	=> 'required|min:3|max:200',
			'zip'		=> 'required|min:3|max:30',
			'city'		=> 'required|min:3|max:200',
			'state'		=> 'required|min:3|max:200',
			'country'	=> 'required',
			'language'	=> 'required',
			'company'	=> 'min:3|max:200',
			'status'	=> 'required'
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$user			= User::find($request->user_id);
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			$user->salutation	= $request->salutation;
			$user->firstname= $request->firstname;
			$user->lastname	= $request->lastname;
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
			$user->permission	= $request->permission;
			if ($request->has('company')) {
				$user->company	= $request->company;
			} else {
				$user->company	= '';
			}
			
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			return redirect('users')->with('message', trans('words.ctrl_data_updated'));
		}
	}
	public function doUpdateVet(Request $request) {
		\App::setLocale(Session::get('locale'));
		$validator = Validator::make($request->all(), [
            'user_type'	=> 'required',
			'salutation'=> 'required',
			'firstname'	=> 'required|min:3|max:30',
			'lastname'	=> 'required|min:3|max:30',
			'company'	=> 'required|min:3|max:200',
			'register_number'	=> 'required|min:3|max:200',
			'email' 	=> 'required|email|unique:users,email,'.$request->user_id,
			'phone'		=> 'required',
			'password'	=> 'min:6|max:30',
			'confirm_password'	=> 'same:password',
			'address'	=> 'required|min:3|max:200',
			'zip'		=> 'required|min:3|max:30',
			'city'		=> 'required|min:3|max:200',
			'state'		=> 'required|min:3|max:200',
			'country'	=> 'required',
			'language'	=> 'required',
			'status'	=> 'required'
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$user			= User::find($request->user_id);
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			$user->salutation	= $request->salutation;
			$user->firstname= $request->firstname;
			$user->lastname	= $request->lastname;
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
			$user->register_number	= $request->register_number;
			$user->language	= $request->language;
			$user->company	= $request->company;
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			return redirect('users')->with('message', trans('words.ctrl_data_updated'));
		}
	}
	public function doUpdateAuthority(Request $request) {
		\App::setLocale(Session::get('locale'));
		$validator = Validator::make($request->all(), [
            'user_type'	=> 'required',
			'salutation'=> 'required',
			'firstname'	=> 'required|min:3|max:30',
			'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users,email,'.$request->user_id,
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
			'status'	=> 'required'
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$user			= User::find($request->user_id);
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			$user->salutation	= $request->salutation;
			$user->firstname= $request->firstname;
			$user->lastname	= $request->lastname;
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
			$user->authority_name	= $request->authority_name;
			$user->supervisor_name	= $request->supervisor_name;
			$user->supervisor_email	= $request->supervisor_email;
			$user->supervisor_phone	= $request->supervisor_phone;
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			return redirect('users')->with('message', trans('words.ctrl_data_updated'));
		}
	}
	public function doUpdateAdmin(Request $request) {
		\App::setLocale(Session::get('locale'));
		$validator = Validator::make($request->all(), [
            'user_type'	=> 'required',
			'salutation'=> 'required',
			'firstname'	=> 'required|min:3|max:30',
			'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users,email,'.$request->user_id,
			'phone'		=> 'required',
			'password'	=> 'min:6|max:30',
			'confirm_password'	=> 'same:password',
			'address'	=> 'required|min:3|max:200',
			'zip'		=> 'required|min:3|max:30',
			'city'		=> 'required|min:3|max:200',
			'state'		=> 'required|min:3|max:200',
			'country'	=> 'required',
			'language'	=> 'required',
			'company'	=> 'min:3|max:200',
			'status'	=> 'required'
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$user			= User::find($request->user_id);
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			$user->salutation	= $request->salutation;
			$user->firstname= $request->firstname;
			$user->lastname	= $request->lastname;
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
			if ($request->has('company')) {
				$user->company	= $request->company;
			} else {
				$user->company	= '';
			}
			
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			return redirect('users')->with('message', trans('words.ctrl_data_updated'));
		}
	}
	public function createUser() {
		\App::setLocale(Session::get('locale'));
		return view('user.create-user');
	}
	public function createVet() {
		\App::setLocale(Session::get('locale'));
		return view('user.create-vet');
	}
	public function createAuthority() {
		\App::setLocale(Session::get('locale'));
		return view('user.create-authority');
	}
	public function createAdmin() {
		\App::setLocale(Session::get('locale'));
		return view('user.create-admin');
	}
	public function doChangeIbanDetails(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
			'iban'	=> 'required',
			'name'	=> 'required',
			'id'	=> 'required'
		]);

		if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			
			\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
			//	Source Creation
			$source = \Stripe\Source::create(array(
			  "type" => "sepa_debit",
			  "sepa_debit" => array("iban" => $request->input('iban')),
			  "currency" => "eur",
			  "owner" => array(
				"name" => $request->input('name'),
			  ),
			));
			
			$sub	= Subscription::where('vet_id', '=', $request->input('id'))->where('is_stripe', '=', 1)->orderBy('created_at', 'desc')->first();
			try {
				$customer = \Stripe\Customer::retrieve($sub->customer_id); // stored in your application
				$customer->source = $source->id; // obtained with Checkout
				$customer->save();
				
				if(isset($customer->sources->data[0]->last4)) {	// iban
					$last4	= $customer->sources->data[0]->last4;
					$sub->last4	= $last4;
				} else if(isset($customer->sources->data[0]->sepa_debit->last4)) { // card
					$last4				= $customer->sources->data[0]->sepa_debit->last4;
					$mandate_reference	= $customer->sources->data[0]->sepa_debit->mandate_reference;
					$mandate_url		= $customer->sources->data[0]->sepa_debit->mandate_url;
					$sub->last4			= $last4;
					$sub->mandate_reference	= $mandate_reference;
					$sub->mandate_url		= $mandate_url;
				}
				$sub->save();
				$response['code']	= 1;	//	success
				echo json_encode($response);
			}
			catch(\Stripe\Error\Card $e) {

				// Use the variable $error to save any errors
				// To be displayed to the customer later in the page
				$body	= $e->getJsonBody();
				$err 	= $body['error'];
				$error	= $err['message'];
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_something_wrong');
				echo json_encode($response);
			}
			
		}
	}
	public function doChangeDetails(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$sub	= Subscription::where('vet_id', '=', $request->input('id'))->where('is_stripe', '=', 1)->orderBy('created_at', 'desc')->first();
		$token	= $request->input('stripeToken');
		$user	= User::find($request->input('id'));
		$email	= $user->email;
		\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
		try {
			$customer = \Stripe\Customer::retrieve($sub->customer_id); // stored in your application
			$customer->source = $token; // obtained with Checkout
			$customer->save();
			
			if(isset($customer->sources->data[0]->last4)) {	// iban
				$last4	= $customer->sources->data[0]->last4;
				$sub->last4	= $last4;
			} else if(isset($customer->sources->data[0]->sepa_debit->last4)) { // card
				$last4				= $customer->sources->data[0]->sepa_debit->last4;
				$mandate_reference	= $customer->sources->data[0]->sepa_debit->mandate_reference;
				$mandate_url		= $customer->sources->data[0]->sepa_debit->mandate_url;
				$sub->last4			= $last4;
				$sub->mandate_reference	= $mandate_reference;
				$sub->mandate_url		= $mandate_url;
			}
			$sub->save();
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
		catch(\Stripe\Error\Card $e) {

			// Use the variable $error to save any errors
			// To be displayed to the customer later in the page
			$body	= $e->getJsonBody();
			$err 	= $body['error'];
			$error	= $err['message'];
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		}
		
	}
	public function doSubscribeCharge(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
		$token	= $request->input('stripeToken');
		$user	= User::find($request->input('id'));
		$email	= $user->email;
		// Customer Creation
		$customer	= \Stripe\Customer::create(array(
			'email'	=> $email,
			'source'=> $token,
			'metadata'	=> array('Firstname' => $user->firstname, 'Lastname' => $user->lastname)
		));
		$euCountries	= array(14, 21, 56, 68, 73, 74, 82, 85, 105, 107, 119, 125, 126, 134, 152, 153, 173, 191, 192, 197);
		if(in_array(Auth::user()->country, $euCountries)) {
			$plan	= SITE_SUBSCRIPTION_PLAN_ID_EUR;
			$currency	= 'EUR';
		} else {
			$plan	= SITE_SUBSCRIPTION_PLAN_ID_USD;
			$currency	= 'USD';
		}
			
		//	Assign Subscription to Customer
		$subscription	= \Stripe\Subscription::create([
			'customer'	=> $customer->id,
			'items'		=> [['plan' => $plan]],
		]);
		$last4	= $customer->sources->data[0]->last4;
		//	Change status of existing plans
		Subscription::where('vet_id', '=', $user->id)->update(['status' => 0]);
		
		//	Add new subscription
		$sub			= new Subscription();
		$sub->vet_id	= $user->id;
		$sub->plan_id	= 1;
		$sub->customer_id		= $customer->id;
		$sub->subscription_id	= $subscription->id;
		$sub->is_stripe	= 1;
		$sub->method	= 1;
		$sub->payment_status	= 0;
		$sub->last4	= $last4;
		$sub->currency	= $currency;
		//$sub->start_date= date('Y-m-d');
		//$sub->end_date	= date('Y-m-d', strtotime('+1 year'));
		//$sub->status	= 1;
		$sub->save();
		
		$data	= array('name' => $user->firstname.' '.$user->lastname);
		Mail::send('emails.subscription-notification', $data, function($message) use ($user)
		{
			$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
		});
		$response['code']	= 1;	//	success
		echo json_encode($response);
	}
	public function doSubscribeChargeIban(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
			'iban'	=> 'required',
			'name'	=> 'required',
			'id'	=> 'required'
		]);

		if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
			die();
		} else {
			$user	= User::find($request->input('id'));
			$email	= $user->email;
			
			\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
			//	Source Creation
			$source = \Stripe\Source::create(array(
			  "type" => "sepa_debit",
			  "sepa_debit" => array("iban" => $request->input('iban')),
			  "currency" => "eur",
			  "owner" => array(
				"name" => $request->input('name'),
			  ),
			));

			//	Customer Creation
			$customer = \Stripe\Customer::create(array(
				"email" 	=> $email,
				"source" 	=> $source->id,
				'metadata'	=> array('Firstname' => $user->firstname, 'Lastname' => $user->lastname)
			  
			));
			$last4				= $customer->sources->data[0]->sepa_debit->last4;
			$mandate_reference	= $customer->sources->data[0]->sepa_debit->mandate_reference;
			$mandate_url		= $customer->sources->data[0]->sepa_debit->mandate_url;
			$euCountries	= array(14, 21, 56, 68, 73, 74, 82, 85, 105, 107, 119, 125, 126, 134, 152, 153, 173, 191, 192, 197);
			if(in_array(Auth::user()->country, $euCountries)) {
				$plan	= SITE_SUBSCRIPTION_PLAN_ID_EUR;
				$currency	= 'EUR';
			} else {
				$plan	= SITE_SUBSCRIPTION_PLAN_ID_USD;
				$currency	= 'USD';
			}
			//	Assign Subscription to Customer
			$subscription	= \Stripe\Subscription::create([
				'customer'	=> $customer->id,
				'items'		=> [['plan' => $plan]],
			]);
			//	Change status of existing plans
			Subscription::where('vet_id', '=', $user->id)->update(['status' => 0]);
			
			//	Add new subscription
			$sub			= new Subscription();
			$sub->vet_id	= $user->id;
			$sub->plan_id	= 1;
			$sub->customer_id		= $customer->id;
			$sub->subscription_id	= $subscription->id;
			$sub->method	= 2;
			$sub->is_stripe	= 1;
			//$sub->start_date= date('Y-m-d');
			//$sub->end_date	= date('Y-m-d', strtotime('+1 year'));
			$sub->payment_status	= 0;
			$sub->last4				= $last4;
			$sub->mandate_reference	= $mandate_reference;
			$sub->mandate_url		= $mandate_url;
			$sub->currency	= $currency;
			//$sub->status	= 1;
			$sub->save();
			
			$data	= array('name' => $user->firstname.' '.$user->lastname);
			Mail::send('emails.subscription-notification', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
			});
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function showSubscriptions($id) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$planArray	= array(1 => trans('words.1_year_plan'), trans('words.free_plan'), trans('words.voucher'));
		view()->share('planArray', $planArray);
		$userArray	= User::find($id);
		if($userArray->user_type == 2) {
			$subscriptions		= Subscription::where('vet_id', '=', $userArray->id)->orderBy('id', 'desc')->get();
		} else if($userArray->user_type == 4) {
			$subscriptions		= Subscription::where('status', '=', 1)->orderBy('id', 'desc')->get();
		}
		$response['subscriptions']	= $subscriptions;
		$response['code']	= 1;	//	success
		echo json_encode($response);
	}
	public function doCreateUser(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
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
			'company'	=> 'min:3|max:200',
			'status'	=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$user			= new User();
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			$user->salutation	= $request->salutation;
			$user->firstname= $request->firstname;
			$user->lastname	= $request->lastname;
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
			if ($request->has('company')) {
				$user->company	= $request->company;
			} else {
				$user->company	= '';
			}
			
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			
			$data	= array('name' => $user->firstname.' '.$user->lastname, 'email' => $user->email, 'password' => $request->password, 'id' => $user->id);
			Mail::send('emails.register', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_confirmation'));
			});
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function doCreateVet(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
            'user_type'	=> 'required',
			'salutation'=> 'required',
			'firstname'	=> 'required|min:3|max:30',
			'lastname'	=> 'required|min:3|max:30',
			'company'	=> 'required|min:3|max:200',
			'register_number'	=> 'required|min:3|max:200',
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
			'status'	=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$user			= new User();
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			$user->salutation	= $request->salutation;
			$user->firstname= $request->firstname;
			$user->lastname	= $request->lastname;
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
			$user->company	= $request->company;
			$user->register_number	= $request->register_number;
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			
			$data	= array('name' => $user->firstname.' '.$user->lastname, 'email' => $user->email, 'password' => $request->password, 'id' => $user->id);
			Mail::send('emails.register', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_confirmation'));
			});
			
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function doCreateAuthority(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
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
			'status'	=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$user			= new User();
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			$user->salutation	= $request->salutation;
			$user->firstname= $request->firstname;
			$user->lastname	= $request->lastname;
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
			$user->authority_name	= $request->authority_name;
			$user->supervisor_name	= $request->supervisor_name;
			$user->supervisor_email	= $request->supervisor_email;
			$user->supervisor_phone	= $request->supervisor_phone;
			
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			
			$data	= array('name' => $user->firstname.' '.$user->lastname, 'email' => $user->email, 'password' => $request->password, 'id' => $user->id);
			Mail::send('emails.register', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_confirmation'));
			});
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function doCreateAdmin(Request $request) {
		\App::setLocale(Session::get('locale'));
		
		$validator = Validator::make($request->all(), [
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
			'company'	=> 'min:3|max:200',
			'status'	=> 'required'
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$user			= new User();
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			$user->salutation	= $request->salutation;
			$user->firstname= $request->firstname;
			$user->lastname	= $request->lastname;
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
			if ($request->has('company')) {
				$user->company	= $request->company;
			} else {
				$user->company	= '';
			}
			
			if ($request->has('status')) {
				$user->status	= $request->status;
			}
			$user->save();
			
			$data	= array('name' => $user->firstname.' '.$user->lastname, 'email' => $user->email, 'password' => $request->password, 'id' => $user->id);
			Mail::send('emails.register', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_confirmation'));
			});
			
			return redirect('users')->with('message', trans('words.ctrl_user_profile_created'));
		}
	}
	public function showAboutus() {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		return view('aboutus');
	}
	public function showContactus() {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		return view('contactus');
	}
	public function showImprint() {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		return view('imprint');
	}
	public function createPoster($id) {
		\App::setLocale(Session::get('locale'));
		$countries = array(
			1 => 'Afghanistan',
			'Albania',
			'Algeria',
			'American Samoa',
			'Andorra',
			'Angola',
			'Anguilla',
			'Antarctica',
			'Antigua and Barbuda',
			'Argentina',
			'Armenia',
			'Aruba',
			'Australia',
			'Austria',
			'Azerbaijan',
			'Bahamas',
			'Bahrain',
			'Bangladesh',
			'Barbados',
			'Belarus',
			'Belgium',
			'Belize',
			'Benin',
			'Bermuda',
			'Bhutan',
			'Bolivia',
			'Bosnia and Herzegowina',
			'Botswana',
			'Bouvet Island',
			'Brazil',
			'British Indian Ocean Territory',
			'Brunei Darussalam',
			'Bulgaria',
			'Burkina Faso',
			'Burundi',
			'Cambodia',
			'Cameroon',
			'Canada',
			'Cape Verde',
			'Cayman Islands',
			'Central African Republic',
			'Chad',
			'Chile',
			'China',
			'Christmas Island',
			'Cocos (Keeling) Islands',
			'Colombia',
			'Comoros',
			'Congo',
			'Congo, the Democratic Republic of the',
			'Cook Islands',
			'Costa Rica',
			'Cote d\'Ivoire',
			'Croatia (Hrvatska)',
			'Cuba',
			'Cyprus',
			'Czech Republic',
			'Denmark',
			'Djibouti',
			'Dominica',
			'Dominican Republic',
			'East Timor',
			'Ecuador',
			'Egypt',
			'El Salvador',
			'Equatorial Guinea',
			'Eritrea',
			'Estonia',
			'Ethiopia',
			'Falkland Islands (Malvinas)',
			'Faroe Islands',
			'Fiji',
			'Finland',
			'France',
			'France Metropolitan',
			'French Guiana',
			'French Polynesia',
			'French Southern Territories',
			'Gabon',
			'Gambia',
			'Georgia',
			'Germany',
			'Ghana',
			'Gibraltar',
			'Greece',
			'Greenland',
			'Grenada',
			'Guadeloupe',
			'Guam',
			'Guatemala',
			'Guinea',
			'Guinea-Bissau',
			'Guyana',
			'Haiti',
			'Heard and Mc Donald Islands',
			'Holy See (Vatican City State)',
			'Honduras',
			'Hong Kong',
			'Hungary',
			'Iceland',
			'India',
			'Indonesia',
			'Iran (Islamic Republic of)',
			'Iraq',
			'Ireland',
			'Israel',
			'Italy',
			'Jamaica',
			'Japan',
			'Jordan',
			'Kazakhstan',
			'Kenya',
			'Kiribati',
			'Korea, Democratic People\'s Republic of',
			'Korea, Republic of',
			'Kuwait',
			'Kyrgyzstan',
			'Lao, People\'s Democratic Republic',
			'Latvia',
			'Lebanon',
			'Lesotho',
			'Liberia',
			'Libyan Arab Jamahiriya',
			'Liechtenstein',
			'Lithuania',
			'Luxembourg',
			'Macau',
			'Macedonia, The Former Yugoslav Republic of',
			'Madagascar',
			'Malawi',
			'Malaysia',
			'Maldives',
			'Mali',
			'Malta',
			'Marshall Islands',
			'Martinique',
			'Mauritania',
			'Mauritius',
			'Mayotte',
			'Mexico',
			'Micronesia, Federated States of',
			'Moldova, Republic of',
			'Monaco',
			'Mongolia',
			'Montserrat',
			'Morocco',
			'Mozambique',
			'Myanmar',
			'Namibia',
			'Nauru',
			'Nepal',
			'Netherlands',
			'Netherlands Antilles',
			'New Caledonia',
			'New Zealand',
			'Nicaragua',
			'Niger',
			'Nigeria',
			'Niue',
			'Norfolk Island',
			'Northern Mariana Islands',
			'Norway',
			'Oman',
			'Pakistan',
			'Palau',
			'Panama',
			'Papua New Guinea',
			'Paraguay',
			'Peru',
			'Philippines',
			'Pitcairn',
			'Poland',
			'Portugal',
			'Puerto Rico',
			'Qatar',
			'Reunion',
			'Romania',
			'Russian Federation',
			'Rwanda',
			'Saint Kitts and Nevis',
			'Saint Lucia',
			'Saint Vincent and the Grenadines',
			'Samoa',
			'San Marino',
			'Sao Tome and Principe',
			'Saudi Arabia',
			'Senegal',
			'Seychelles',
			'Sierra Leone',
			'Singapore',
			'Slovakia (Slovak Republic)',
			'Slovenia',
			'Solomon Islands',
			'Somalia',
			'South Africa',
			'South Georgia and the South Sandwich Islands',
			'Spain',
			'Sri Lanka',
			'St. Helena',
			'St. Pierre and Miquelon',
			'Sudan',
			'Suriname',
			'Svalbard and Jan Mayen Islands',
			'Swaziland',
			'Sweden',
			'Switzerland',
			'Syrian Arab Republic',
			'Taiwan, Province of China',
			'Tajikistan',
			'Tanzania, United Republic of',
			'Thailand',
			'Togo',
			'Tokelau',
			'Tonga',
			'Trinidad and Tobago',
			'Tunisia',
			'Turkey',
			'Turkmenistan',
			'Turks and Caicos Islands',
			'Tuvalu',
			'Uganda',
			'Ukraine',
			'United Arab Emirates',
			'United Kingdom',
			'United States',
			'United States Minor Outlying Islands',
			'Uruguay',
			'Uzbekistan',
			'Vanuatu',
			'Venezuela',
			'Vietnam',
			'Virgin Islands (British)',
			'Virgin Islands (U.S.)',
			'Wallis and Futuna Islands',
			'Western Sahara',
			'Yemen',
			'Yugoslavia',
			'Zambia',
			'Zimbabwe'
		);
		view()->share('countries', $countries);
		$pet_countries = array(
			1 => trans('words.unknown'),
			'Afghanistan',
			'Albania',
			'Algeria',
			'American Samoa',
			'Andorra',
			'Angola',
			'Anguilla',
			'Antarctica',
			'Antigua and Barbuda',
			'Argentina',
			'Armenia',
			'Aruba',
			'Australia',
			'Austria',
			'Azerbaijan',
			'Bahamas',
			'Bahrain',
			'Bangladesh',
			'Barbados',
			'Belarus',
			'Belgium',
			'Belize',
			'Benin',
			'Bermuda',
			'Bhutan',
			'Bolivia',
			'Bosnia and Herzegowina',
			'Botswana',
			'Bouvet Island',
			'Brazil',
			'British Indian Ocean Territory',
			'Brunei Darussalam',
			'Bulgaria',
			'Burkina Faso',
			'Burundi',
			'Cambodia',
			'Cameroon',
			'Canada',
			'Cape Verde',
			'Cayman Islands',
			'Central African Republic',
			'Chad',
			'Chile',
			'China',
			'Christmas Island',
			'Cocos (Keeling) Islands',
			'Colombia',
			'Comoros',
			'Congo',
			'Congo, the Democratic Republic of the',
			'Cook Islands',
			'Costa Rica',
			'Cote d\'Ivoire',
			'Croatia (Hrvatska)',
			'Cuba',
			'Cyprus',
			'Czech Republic',
			'Denmark',
			'Djibouti',
			'Dominica',
			'Dominican Republic',
			'East Timor',
			'Ecuador',
			'Egypt',
			'El Salvador',
			'Equatorial Guinea',
			'Eritrea',
			'Estonia',
			'Ethiopia',
			'Falkland Islands (Malvinas)',
			'Faroe Islands',
			'Fiji',
			'Finland',
			'France',
			'France Metropolitan',
			'French Guiana',
			'French Polynesia',
			'French Southern Territories',
			'Gabon',
			'Gambia',
			'Georgia',
			'Germany',
			'Ghana',
			'Gibraltar',
			'Greece',
			'Greenland',
			'Grenada',
			'Guadeloupe',
			'Guam',
			'Guatemala',
			'Guinea',
			'Guinea-Bissau',
			'Guyana',
			'Haiti',
			'Heard and Mc Donald Islands',
			'Holy See (Vatican City State)',
			'Honduras',
			'Hong Kong',
			'Hungary',
			'Iceland',
			'India',
			'Indonesia',
			'Iran (Islamic Republic of)',
			'Iraq',
			'Ireland',
			'Israel',
			'Italy',
			'Jamaica',
			'Japan',
			'Jordan',
			'Kazakhstan',
			'Kenya',
			'Kiribati',
			'Korea, Democratic People\'s Republic of',
			'Korea, Republic of',
			'Kuwait',
			'Kyrgyzstan',
			'Lao, People\'s Democratic Republic',
			'Latvia',
			'Lebanon',
			'Lesotho',
			'Liberia',
			'Libyan Arab Jamahiriya',
			'Liechtenstein',
			'Lithuania',
			'Luxembourg',
			'Macau',
			'Macedonia, The Former Yugoslav Republic of',
			'Madagascar',
			'Malawi',
			'Malaysia',
			'Maldives',
			'Mali',
			'Malta',
			'Marshall Islands',
			'Martinique',
			'Mauritania',
			'Mauritius',
			'Mayotte',
			'Mexico',
			'Micronesia, Federated States of',
			'Moldova, Republic of',
			'Monaco',
			'Mongolia',
			'Montserrat',
			'Morocco',
			'Mozambique',
			'Myanmar',
			'Namibia',
			'Nauru',
			'Nepal',
			'Netherlands',
			'Netherlands Antilles',
			'New Caledonia',
			'New Zealand',
			'Nicaragua',
			'Niger',
			'Nigeria',
			'Niue',
			'Norfolk Island',
			'Northern Mariana Islands',
			'Norway',
			'Oman',
			'Pakistan',
			'Palau',
			'Panama',
			'Papua New Guinea',
			'Paraguay',
			'Peru',
			'Philippines',
			'Pitcairn',
			'Poland',
			'Portugal',
			'Puerto Rico',
			'Qatar',
			'Reunion',
			'Romania',
			'Russian Federation',
			'Rwanda',
			'Saint Kitts and Nevis',
			'Saint Lucia',
			'Saint Vincent and the Grenadines',
			'Samoa',
			'San Marino',
			'Sao Tome and Principe',
			'Saudi Arabia',
			'Senegal',
			'Seychelles',
			'Sierra Leone',
			'Singapore',
			'Slovakia (Slovak Republic)',
			'Slovenia',
			'Solomon Islands',
			'Somalia',
			'South Africa',
			'South Georgia and the South Sandwich Islands',
			'Spain',
			'Sri Lanka',
			'St. Helena',
			'St. Pierre and Miquelon',
			'Sudan',
			'Suriname',
			'Svalbard and Jan Mayen Islands',
			'Swaziland',
			'Sweden',
			'Switzerland',
			'Syrian Arab Republic',
			'Taiwan, Province of China',
			'Tajikistan',
			'Tanzania, United Republic of',
			'Thailand',
			'Togo',
			'Tokelau',
			'Tonga',
			'Trinidad and Tobago',
			'Tunisia',
			'Turkey',
			'Turkmenistan',
			'Turks and Caicos Islands',
			'Tuvalu',
			'Uganda',
			'Ukraine',
			'United Arab Emirates',
			'United Kingdom',
			'United States',
			'United States Minor Outlying Islands',
			'Uruguay',
			'Uzbekistan',
			'Vanuatu',
			'Venezuela',
			'Vietnam',
			'Virgin Islands (British)',
			'Virgin Islands (U.S.)',
			'Wallis and Futuna Islands',
			'Western Sahara',
			'Yemen',
			'Yugoslavia',
			'Zambia',
			'Zimbabwe'
		);
		view()->share('pet_countries', $pet_countries);
		
		$languages	= array(1 => trans('words.header_english'), trans('words.header_french'), trans('words.header_german'), trans('words.header_italian'));
		view()->share('languages', $languages);
		
		$salutationArray	= array(1 => trans('words.mister'), 2 => trans('words.misses'));
		view()->share('salutationArray', $salutationArray);
		
		$userTypes	= array(1 => trans('words.owner'), 2 => trans('words.veterinary'), 3 => trans('words.authority'));
		view()->share('userTypes', $userTypes);
		
		$speciesArray	= array(1 => trans('words.dog'), trans('words.cat'), trans('words.bird'), trans('words.rodent'), trans('words.snake'), trans('words.horse'), trans('words.donkey'), trans('words.sheep'), trans('words.goat'), trans('words.cow'), trans('words.pig'));
		view()->share('speciesArray', $speciesArray);
		
		$genderArray	= array(1 => trans('words.unknown'), trans('words.male'), trans('words.female'));
		view()->share('genderArray', $genderArray);
		
		$geldArray	= array(1 =>  trans('words.unknown'), trans('words.gelded'), trans('words.doctored'), trans('words.nothing'));
		view()->share('geldArray', $geldArray);
		
		$planArray	= array(1 => trans('words.1_year_plan'), trans('words.free_plan'), trans('words.voucher'));
		view()->share('planArray', $planArray);
		
		// register PHPRtfLite class loader
		\PHPRtfLite::registerAutoloader();
		
		$times12	= new \PHPRtfLite_Font(13, 'Times new Roman');
		$arial14	= new \PHPRtfLite_Font(14, 'Arial', '#000066');

		$parFormat	= new \PHPRtfLite_ParFormat();

		//rtf document
		$rtf		= new \PHPRtfLite();

		//borders
		$borderFormatBlue	= new \PHPRtfLite_Border_Format(1, '#0000ff');
		$borderFormatRed	= new \PHPRtfLite_Border_Format(2, '#ff0000');
		$border				= new \PHPRtfLite_Border($rtf, $borderFormatBlue, $borderFormatRed, $borderFormatBlue, $borderFormatRed);
		$rtf->setBorder($border);
		$rtf->setBorderSurroundsHeader();
		$rtf->setBorderSurroundsFooter();

		//section 2
		$sect = $rtf->addSection();
		$sect->setBorderSurroundsHeader();
		$sect->setBorderSurroundsFooter();
		
		$petData	= Pet::find($id);
		
		//Borders overridden: Green border
		$border = \PHPRtfLite_Border::create($rtf, 1, '#00ff00', \PHPRtfLite_Border_Format::TYPE_DASH, 1);
		$sect->setBorder($border);
		$sect->writeText('<b>'.trans('words.please_find_my_pet').'</b><br>', $arial14, new \PHPRtfLite_ParFormat(\PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
		
		$sect->writeText(trans('words.pet_info').'<br>', $arial14, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.name').': '.$petData->name, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.species').': '.$speciesArray[$petData->species], $times12, new \PHPRtfLite_ParFormat());

		if($petData->color != '') {
			$sect->writeText(trans('words.color').': '.$petData->color, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->gender != 0) {
			$sect->writeText(trans('words.gender').': '.$genderArray[$petData->gender], $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->geld != 0) {
			$sect->writeText(trans('words.geld').': '.$geldArray[$petData->geld], $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->country_of_birth != 0) {
			$sect->writeText(trans('words.country_of_birth').': '.$pet_countries[$petData->country_of_birth], $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->date_of_birth != '0000-00-00') {
			$date	= date('m/d/Y', strtotime($petData->date_of_birth));
			$sect->writeText(trans('words.dob').': '.$date, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->chip_id != '') {
			$sect->writeText(trans('words.chip_id').': '.$petData->chip_id, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->pass_id != '') {
			$sect->writeText(trans('words.pass_id').': '.$petData->pass_id, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->tattoo_id != '') {
			$sect->writeText(trans('words.tattoo_id').': '.$petData->tattoo_id, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->tattoo_location != '') {
			$sect->writeText(trans('words.tattoo_location').': '.$petData->tattoo_location, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->pet_id != '') {
			$sect->writeText(trans('words.pet_id').': '.$petData->pet_id, $times12, new \PHPRtfLite_ParFormat());
		}
		if($petData->characteristics != '') {
			$sect->writeText(trans('words.characteristics').': '.$petData->characteristics, $times12, new \PHPRtfLite_ParFormat());
		}
		$sect->writeText('<br><br>', $times12, new \PHPRtfLite_ParFormat());
		
		$ownerData	= User::find($petData->owner_id);
		$sect->writeText(trans('words.owner_info').'<br>', $arial14, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.name').': '.$salutationArray[$ownerData->salutation].'. '.$ownerData->firstname.' '.$ownerData->lastname, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.email').': '.$ownerData->email, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.phone').': '.$ownerData->phone, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.address').': '.$ownerData->address, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.zip').': '.$ownerData->zip, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.city').': '.$ownerData->city, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.state').': '.$ownerData->state, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.country').': '.$countries[$ownerData->country], $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.language').': '.$languages[$ownerData->language], $times12, new \PHPRtfLite_ParFormat());
		if($ownerData->company != '') {
			$sect->writeText(trans('words.company').': '.$ownerData->company, $times12, new \PHPRtfLite_ParFormat());
		}
		$sect->writeText('<br><br>', $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.lost_info').'<br>', $arial14, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.location').': '.$petData->lost_location, $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.date').': '.date('m-d-Y', strtotime($petData->lost_date.' 00:00:00')), $times12, new \PHPRtfLite_ParFormat());
		$sect->writeText(trans('words.time').': '.$petData->lost_time, $times12, new \PHPRtfLite_ParFormat());
		$file	= time().'.rtf';
		// save rtf document
		$rtf->save(getcwd().'/data/posters/' . $file);
		$filepath = getcwd()."/data/posters/" . $file;
		// Process download
		if(file_exists($filepath)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));
			flush(); // Flush system output buffer
			readfile($filepath);
			exit;
		}
	}
	public function doPetDeath(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$validator = Validator::make($request->all(), [
            'id'			=> 'required',
			'date_of_death'	=> 'required',
			'cause_of_death'=> 'required',
			'user_id'		=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$userArray	= User::find($request->input('user_id'));
			if($userArray->user_type == 4) {
				$pet	= Pet::where('id', '=', $request->input('id'))->first();
			} else {
				$pet	= Pet::where('owner_id', '=', $userArray->id)->where('id', '=', $request->input('id'))->first();
			}
			if ($pet) {
				$date				= explode('/', $request->input('date_of_death'));
				$pet->date_of_death	= $date[2].'-'.$date[0].'-'.$date[1];
				$pet->cause_of_death= $request->input('cause_of_death');
				$pet->save();
				$response['code']	= 1;	//	success
				echo json_encode($response);
			} else {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_data_not_avail');
				echo json_encode($response);
			}
		}
		die();
	}
	public function doAddNote(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
            'id'=> 'required',
			'notes'	=> 'required',
			'user_id'	=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$userArray	= User::find($request->input('user_id'));
			$pet				= Pet::where('vet_id', '=', $userArray->id)->where('id', '=', $request->input('id'))->first();
			
			if ($pet) {
				$notes			= new PetNotes();
				$notes->pet_id	= $request->input('id');
				$notes->vet_id	= $userArray->id;
				$notes->notes	= $request->input('notes');
				$notes->save();
				$response['code']	= 1;	//	success
				echo json_encode($response);
			} else {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_something_wrong');
				echo json_encode($response);
			}
		}
		die();
	}
	public function doUpdateProfile(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
			'email' 	=> 'required|email|unique:users,email,'.$request->input('id'),
			'phone'		=> 'required',
			'password'	=> 'min:6|max:30',
			'confirm_password'	=> 'same:password',
			'address'	=> 'required|min:3|max:200',
			'zip'		=> 'required|min:3|max:30',
			'city'		=> 'required|min:3|max:200',
			'state'		=> 'required|min:3|max:200',
			'country'	=> 'required',
			'language'	=> 'required',
			'company'	=> 'min:3|max:200',
			'id'		=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
			die();
		} else {
			$user	= User::find($request->input('id'));
			if ($request->has('password')) {
				$user->user_type= $request->user_type;
			}
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			if ($request->has('firstname')) {
				$user->firstname= $request->firstname;
			}
			if ($request->has('lastname')) {
				$user->lastname= $request->lastname;
			}
			if ($request->has('salutation')) {
				$user->salutation= $request->salutation;
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
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function doUpdateProfileVet(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
            //'user_type'	=> 'required',
			//'salutation'=> 'required',
			//'firstname'	=> 'required|min:3|max:30',
			//'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users,email,'.$request->input('id'),
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
			'id'		=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$user	= User::find($request->input('id'));
			if ($request->has('password')) {
				$user->user_type= $request->user_type;
			}
			
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			if ($request->has('firstname')) {
				$user->firstname= $request->firstname;
			}
			if ($request->has('lastname')) {
				$user->lastname= $request->lastname;
			}
			if ($request->has('salutation')) {
				$user->salutation= $request->salutation;
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
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function doUpdateProfileAuthority(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
            //'user_type'	=> 'required',
			//'salutation'=> 'required',
			//'firstname'	=> 'required|min:3|max:30',
			//'lastname'	=> 'required|min:3|max:30',
			'email' 	=> 'required|email|unique:users,email,'.$request->input('id'),
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
			'id'		=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$user	= User::find($request->input('id'));
			if ($request->has('password')) {
				$user->user_type= $request->user_type;
			}
			if ($request->has('user_type')) {
				$user->user_type= $request->user_type;
			}
			if ($request->has('firstname')) {
				$user->firstname= $request->firstname;
			}
			if ($request->has('lastname')) {
				$user->lastname= $request->lastname;
			}
			if ($request->has('salutation')) {
				$user->salutation= $request->salutation;
			}
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
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function doPetOffer(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$validator = Validator::make($request->all(), [
            'id'				=> 'required',
			'new_owner_email'	=> 'required|email',
			'user_id'			=> 'required'
        ]);

        if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$userArray	= User::find($request->input('user_id'));
			if($userArray->user_type == 4) {
				$pet	= Pet::where('id', '=', $request->input('id'))->first();
			} else {
				//$pet	= Pet::where('owner_id', '=', $userArray->id)->where('id', '=', $request->input('pet_id'))->first();
				$pet	= Pet::where('id', '=', $request->input('id'))
								->where(function($query) use ($userArray) {
									return $query->where('owner_id', '=', $userArray->id)
										->orWhere('vet_id', '=', $userArray->id);
								})->first();
			}
			if ($pet) {
				
				$offerExist	= SendOffer::where('pet_id', '=', $pet->id)->where('user_id', '=', $userArray->id)->where('new_owner_email', '=', $request->input('new_owner_email'))->where('status', '=', 0)->count();
				if($offerExist == 0) {
					$offer					= new SendOffer();
					$offer->user_id			= $userArray->id;
					$offer->new_owner_email	= $request->input('new_owner_email');
					$offer->pet_id			= $request->input('id');
					$offer->save();
					
					if(Auth::user()->user_type == 1) {
						$textmessage	= trans('words.ctrl_received_request_verify');
					} else {
						$textmessage	= trans('words.ctrl_received_offer');
					}
					$data	= array('email' => $request->input('new_owner_email'), 'textmessage' => $textmessage);
					$user	= new \stdClass;
					$user->email	= $request->input('new_owner_email');
					if(Mail::send('emails.send-offer', $data, function($message) use ($user)
					{
						$message->to($user->email, $user->email)->subject(trans('words.ctrl_notification'));
					})) {
						$response['code']	= 1;	// error
						echo json_encode($response);
						die();
					} else {
						$response['code']	= 0;	// error
						echo json_encode($response);
						die();
					}
				} else {
					$response['code']	= 3;	// error
					echo json_encode($response);
					die();
				}
			} else {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_data_not_avail');
				echo json_encode($response);
			}
		}
		die();
	}
	public function doAcceptOffer($id, $user_id) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$userArray	= User::find($user_id);
		if($userArray->user_type == 4) {
			$offer		= SendOffer::where('id', '=', $id)->first();
		} else {
			$offer		= SendOffer::where('new_owner_email', '=', $userArray->email)->where('id', '=', $id)->first();
		}
		if ($offer) {
			$pet			= Pet::find($offer->pet_id);
			if($userArray->user_type == 4) {
				$userData	= User::where('email', '=', $offer->new_owner_email)->first();
				if($userData->user_type == 2) {
					$pet->vet_id	= $userData->id;
				} else {
					$pet->owner_id	= $userData->id;
				}
			} else {
				if($userArray->user_type == 2) {
					$pet->vet_id	= $userArray->id;
				} else {
					$pet->owner_id	= $userArray->id;
				}
			}
			$pet->save();
			
			$offer->status	= 1;
			$offer->save();
			$response['code']	= 1;	//	success
			echo json_encode($response);
		} else {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_no_access');
			echo json_encode($response);
		}
		die();
	}
	public function doPetSearch(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$validator = Validator::make($request->all(), [
            'id'		=> 'required',
			'id_type'	=> 'required'
        ]);
        if ($validator->fails()) {
			//print_r($validator->errors());
			//die();
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			if(Auth::check()){
				$userArray	= Auth::user();
				if($userArray->user_type == 3) {
					$log	= new AuthorityLog();
					$log->authority_id	= $userArray->id;
					$log->search_id		= $request->input('id');
					$log->id_type		= $request->input('id_type');
					$log->save();
				}
			}
			$pet	= Pet::where($request->input('id_type'), '=', $request->input('id'))->first();
			
			if ($pet) {
				$response['code']		= 1;	//	success
				$response['petData']	= $pet;
				$owner	= User::find($pet->owner_id);
				$response['ownerData']	= $owner;
				$petnotes	= PetNotes::where('pet_id', '=', $pet->id)->get();
				$response['petNotes']	= $petnotes;
				echo json_encode($response);
			} else {
				$response['code']	= 0;	// error
				$response['message']= trans('words.ctrl_something_wrong');
				echo json_encode($response);
			}
		}
		die();
	}
	public function doPostSearchResult(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		
		$validator = Validator::make($request->all(), [
			'pet_id'		=> 'required',
            'your_name'		=> 'required',
			'your_email'	=> 'required|email',
			'your_phone'	=> 'required',
			'location'		=> 'required',
			'your_message'	=> 'required'
        ]);

        if ($validator->fails()) {
			//print_r($validator->errors());
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$pet	= Pet::find($request->input('pet_id'));
			//	Send to owner
			$user	= User::find($pet->owner_id);
			$data	= array('pet_name' => $pet->name, 'name' => $user->firstname.' '.$user->lastname, 'your_name' => $request->input('your_name'), 'your_email' => $request->input('your_email'), 'your_phone' => $request->input('your_phone'), 'location' => $request->input('location'), 'your_message' => $request->input('your_message'));
			Mail::send('emails.search-result-response', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
			});
			//	Send to admins
			$admins	= User::where('user_type', '=', 4)->where('status', '=', 0)->lists('id');
			foreach($admins as $key => $value) {
				$user	= User::find($value);
				$data	= array('pet_name' => $pet->name, 'name' => $user->firstname.' '.$user->lastname, 'your_name' => $request->input('your_name'), 'your_email' => $request->input('your_email'), 'your_phone' => $request->input('your_phone'), 'location' => $request->input('location'), 'your_message' => $request->input('your_message'));
				Mail::send('emails.search-result-response-to-admin', $data, function($message) use ($user)
				{
					$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
				});
			}
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
		die();
	}
	public function doPostSearchResultAuthority(Request $request) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		$validator = Validator::make($request->all(), [
			'your_message'	=> 'required',
			'id'			=> 'required'
		]);
		$userArray	= User::find($request->input('id'));
		if ($validator->fails()) {
			$response['code']	= 0;	// error
			$response['message']= trans('words.ctrl_something_wrong');
			echo json_encode($response);
		} else {
			$pet	= Pet::find($request->input('pet_id'));
			//	Send to owner
			$user	= User::find($pet->owner_id);
			$data	= array('pet_name' => $pet->name, 'name' => $user->firstname.' '.$user->lastname, 'your_name' => $userArray->firstname.' '.$userArray->lastname, 'your_email' => $userArray->email, 'your_phone' => $userArray->phone, 'your_message' => $request->input('your_message'));
			Mail::send('emails.search-result-response', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
			});
			//	Send to admins
			$admins	= User::where('user_type', '=', 4)->where('status', '=', 0)->lists('id');
			foreach($admins as $key => $value) {
				$user	= User::find($value);
				$data	= array('pet_name' => $pet->name, 'name' => $user->firstname.' '.$user->lastname, 'your_name' => $userArray->firstname.' '.$userArray->lastname, 'your_email' => $userArray->email, 'your_phone' => $userArray->phone, 'your_message' => $request->input('your_message'));
				Mail::send('emails.search-result-response-to-admin', $data, function($message) use ($user)
				{
					$message->to($user->email, $user->firstname.' '.$user->lastname)->subject(trans('words.ctrl_notification'));
				});
			}
			$response['code']	= 1;	//	success
			echo json_encode($response);
		}
	}
	public function cancelSubscription($id, $user_id) {
		$response	= array();
		\App::setLocale($_GET['locale']);
		\Stripe\Stripe::setApiKey(SITE_STRIPE_SK);
		$user	= User::find($user_id);
		
		if($user->user_type == 4) {
			$sub	= Subscription::where('id', '=', $id)->first();
			if($sub) {
				$subscription = \Stripe\Subscription::retrieve($sub->subscription_id);
				$subscription->cancel(['at_period_end' => true]);
				$sub->cancel_status	= 1;
				$sub->save();
				$response['code']	= 1;	//	success
				echo json_encode($response);
			} else {
				$response['code']	= 0;
				$response['message']= trans('words.footer_script_you_are_restricted');
				echo json_encode($response);
			}
		} else if(Auth::user()->user_type == 2) {
			$sub	= Subscription::where('vet_id', '=', $user->id)->where('id', '=', $id)->first();
			if($sub) {
				$subscription = \Stripe\Subscription::retrieve($sub->subscription_id);
				$subscription->cancel(['at_period_end' => true]);
				$sub->cancel_status	= 1;
				$sub->save();
				$response['code']	= 1;	//	success
				echo json_encode($response);
			} else {
				$response['code']	= 0;	//	error
				$response['message']= trans('words.footer_script_you_are_restricted');
				echo json_encode($response);
			}
		} else {
			$response['code']	= 0;
			$response['message']= trans('words.footer_script_you_are_restricted');
			echo json_encode($response);
			
		}
	}
	
}