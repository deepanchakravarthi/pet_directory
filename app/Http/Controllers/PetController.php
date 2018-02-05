<?php
namespace App\Http\Controllers;

use DB;

use Mail;

use App\User;

use App\Pet;

use App\SendOffer;

use App\PetNotes;

use App\Subscription;

use App\AuthorityLog;

use Validator;

use Session;

use Hash;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\LoginFormRequest;

use App\Http\Requests\RegisterFormRequest;

use Illuminate\Support\Facades\Auth;

class PetController extends Controller {
	public function showMyPets() {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		if($userArray->user_type == 2) {
			$subscription	= Subscription::where('vet_id', '=', $userArray->id)->where('status', '=', 1)->count();
			if($subscription > 0) {
				$pets		= Pet::where('vet_id', '=', $userArray->id)->get();
			} else {
				return redirect('subscription')->with('message', trans('words.ctrl_activate_subscription'));
			}
		} else if($userArray->user_type == 4) {
			$pets		= Pet::get();
		} else {
			$pets		= Pet::where('owner_id', '=', $userArray->id)->get();
		}
		view()->share('pets', $pets);
		
		$offers		= SendOffer::where('new_owner_email', '=', $userArray->email)->where('status', '=', 0)->get();
		view()->share('offers', $offers);
		
		return view('user.my-pets');
	}
	public function createPet() {
		\App::setLocale(Session::get('locale'));
		return view('user.create-pet');
	}
	public function doInsertPet(Request $request) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		
		$validator = Validator::make($request->all(), [
            'name'			=> 'required|min:3|max:250',
			'species'		=> 'required',
			'color'			=> 'required'
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			
			if (!$request->has('pet_id') && !$request->has('chip_id') && !$request->has('tattoo_id')) {
				return back()->withErrors(trans('words.ctrl_pet_id_must'))->withInput();
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
			$pet->permission	= $request->input('permission');
			$result	= $pet->save();
			return redirect('my-pets')->with('message', trans('words.ctrl_pet_added'));
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
	public function doUpdatePet(Request $request, $id) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		
		$validator = Validator::make($request->all(), [
            'name'			=> 'required|min:3|max:250',
			'species'		=> 'required',
			'color'			=> 'required'
        ]);

        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			if (!$request->has('pet_id') && !$request->has('chip_id') && !$request->has('tattoo_id')) {
				return back()->withErrors(trans('words.ctrl_pet_id_must'))->withInput();
			} 
			$pet				= Pet::find($id);
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
			return redirect('my-pets')->with('message', trans('words.ctrl_data_updated'));
		}
	}
	public function doPetFound(Request $request) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		
		$validator = Validator::make($request->all(), [
            'pet_id'	=> 'required'
        ]);

        if ($validator->fails()) {
			echo 0;
		} else {
			if($userArray->user_type == 4) {
				$pet	= Pet::where('id', '=', $request->input('pet_id'))->first();
			} else {
				//$pet				= Pet::where('owner_id', '=', $userArray->id)->where('id', '=', $request->input('pet_id'))->first();
				$pet	= Pet::where('id', '=', $request->input('pet_id'))
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
				echo 1;
			} else {
				echo 2;
			}
		}
	}
	public function doPetLost(Request $request) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		
		$validator = Validator::make($request->all(), [
            'pet_id'	=> 'required',
			'lost_location' => 'required',
			'lost_date' => 'required',
			'lost_time' => 'required'
        ]);

        if ($validator->fails()) {
			echo 0;
		} else {
			//$pet				= Pet::where('owner_id', '=', $userArray->id)->where('id', '=', $request->input('pet_id'))->first();
			if($userArray->user_type == 4) {
				$pet	= Pet::where('id', '=', $request->input('pet_id'))->first();
			} else {
				$pet	= Pet::where('id', '=', $request->input('pet_id'))
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
				echo 1;
			} else {
				echo 2;
			}
		}
	}
	public function viewPet($id) {
		$userArray	= Auth::user();
		\App::setLocale(Session::get('locale'));
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
		
		$notes	= PetNotes::where('pet_id', '=', $id)->get();
		view()->share('notes', $notes);
		
		return view('user.view-pet')->with('pet', $pet);
	}
	//	Users
	public function showMyUsers() {
		$userArray	= Auth::user();
		\App::setLocale(Session::get('locale'));
		if($userArray->user_type == 2) {
			$subscription	= Subscription::where('vet_id', '=', $userArray->id)->where('status', '=', 1)->count();
			if($subscription > 0) {
				$pet	= Pet::where('vet_id', '=', $userArray->id)->lists('owner_id');
				$users	= User::whereIn('id', $pet)->get();
			} else {
				return redirect('subscription')->with('message', trans('words.ctrl_activate_subscription'));
			}
			view()->share('users', $users);
		} else if($userArray->user_type == 4) {
			$users		= User::where('user_type', '=', 1)->get();
			view()->share('users', $users);
			
			$vet		= User::where('user_type', '=', 2)->get();
			view()->share('vet', $vet);
			
			$auth		= User::where('user_type', '=', 3)->get();
			view()->share('authority', $auth);
			
			$admins		= User::where('user_type', '=', 4)->where('id', '!=', Auth::user()->id)->get();
			view()->share('admins', $admins);
			
		}
		
		
		return view('user.users');
	}
	public function doViewUser($id) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		if($userArray->user_type == 1) {
			return redirect('index');
		}
		$user	= User::find($id);
		if(!$user) {
			return redirect('index');
		}
		
		$offers		= SendOffer::where('new_owner_email', '=', $user->email)->where('status', '=', 0)->get();
		view()->share('offers', $offers);
		return view('user.my-profile')->with('user', $user);
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
	public function doCreateUser(Request $request) {
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
	public function doCreateVet(Request $request) {
		\App::setLocale(Session::get('locale'));
		
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
			
			return redirect('users')->with('message', trans('words.ctrl_user_profile_created'));
		}
	}
	public function doCreateAuthority(Request $request) {
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
			'authority_name'	=> 'required|min:3|max:200',
			'supervisor_name'	=> 'required|min:3|max:200',
			'supervisor_email'	=> 'required|email',
			'supervisor_phone'	=> 'required|min:3|max:200',
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
			
			return redirect('users')->with('message', trans('words.ctrl_user_profile_created'));
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
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		
		$validator = Validator::make($request->all(), [
            'pet_id'		=> 'required',
			'date_of_death'	=> 'required',
			'cause_of_death'=> 'required'
        ]);

        if ($validator->fails()) {
			echo 0;
		} else {
			if($userArray->user_type == 4) {
				$pet	= Pet::where('id', '=', $request->input('pet_id'))->first();
			} else {
				$pet	= Pet::where('owner_id', '=', $userArray->id)->where('id', '=', $request->input('pet_id'))->first();
			}
			if ($pet) {
				$date				= explode('/', $request->input('date_of_death'));
				$pet->date_of_death	= $date[2].'-'.$date[0].'-'.$date[1];
				$pet->cause_of_death= $request->input('cause_of_death');
				$pet->save();
				echo 1;
			} else {
				echo 2;
			}
		}
	}
	public function doAddNote(Request $request) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		
		$validator = Validator::make($request->all(), [
            'pet_id'=> 'required',
			'notes'	=> 'required'
        ]);

        if ($validator->fails()) {
			echo 0;
		} else {
			$pet				= Pet::where('vet_id', '=', $userArray->id)->where('id', '=', $request->input('pet_id'))->first();
			
			if ($pet) {
				$notes			= new PetNotes();
				$notes->pet_id	= $request->input('pet_id');
				$notes->vet_id	= $userArray->id;
				$notes->notes	= $request->input('notes');
				$notes->save();
				echo 1;
			} else {
				echo 2;
			}
		}
	}
	public function doPetOffer(Request $request) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
		
		$validator = Validator::make($request->all(), [
            'pet_id'			=> 'required',
			'new_owner_email'	=> 'required|email'
        ]);

        if ($validator->fails()) {
			echo 0;
		} else {
			if($userArray->user_type == 4) {
				$pet	= Pet::where('id', '=', $request->input('pet_id'))->first();
			} else {
				//$pet	= Pet::where('owner_id', '=', $userArray->id)->where('id', '=', $request->input('pet_id'))->first();
				$pet	= Pet::where('id', '=', $request->input('pet_id'))
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
					$offer->pet_id			= $request->input('pet_id');
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
						echo 1;
					} else {
						echo 0;
					}
				} else {
					echo 3;
				}
			} else {
				echo 2;
			}
		}
	}
	public function doAcceptOffer($id) {
		\App::setLocale(Session::get('locale'));
		$userArray	= Auth::user();
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
			return redirect('my-pets')->with('message', trans('words.ctrl_pet_added'));
		} else {
			return redirect('my-pets')->withErrors(trans('words.ctrl_no_access'));
		}
	}
	public function doPetSearch(Request $request) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		$validator = Validator::make($request->all(), [
            'id'		=> 'required',
			'id_type'	=> 'required'
        ]);
        if ($validator->fails()) {
			return redirect('index')->withErrors(trans('words.ctrl_something_wrong'));
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
				view()->share('petData', $pet);
				
				$owner	= User::find($pet->owner_id);
				view()->share('ownerData', $owner);
				
				$petnotes	= PetNotes::where('pet_id', '=', $pet->id)->get();
				view()->share('notesData', $petnotes);
			} else {
				
			}
			
			if($pet) {
				$notes	= PetNotes::where('pet_id', '=', $pet->id)->get();
				view()->share('notes', $notes);
			}
			return view('search-pet');
		}
	}
	public function doPostSearchResult(Request $request) {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		$validator = Validator::make($request->all(), [
            'your_name'		=> 'required',
			'your_email'	=> 'required|email',
			'your_phone'	=> 'required',
			'location'		=> 'required',
			'your_message'	=> 'required'
        ]);

        if ($validator->fails()) {
			echo 0;
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
			echo 1;
			
		}
	}
	public function doPostSearchResultAuthority(Request $request) {
		$userArray	= Auth::user();
		\App::setLocale(Session::get('locale'));
		$validator = Validator::make($request->all(), [
			'your_message'	=> 'required'
		]);

		if ($validator->fails()) {
			echo 0;
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
			echo 1;
		}
	}
	
}