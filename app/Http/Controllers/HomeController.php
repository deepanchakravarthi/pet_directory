<?php
namespace App\Http\Controllers;

use DB;

use Mail;

use Validator;

use Session;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller {
	
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
	public function __construct() {
		//$this->beforeFilter('csrf', array('on' => 'post'));
	    //$this->beforeFilter('auth', array('only' => array('showHome')));
		//$this->middleware('csrf');
	}
	public function postContact(Request $request) {
		$validator = Validator::make($request->all(), [
            'name'		=> 'required|min:3|max:30',
			'email'		=> 'required|email',
			'message'	=> 'required|min:20|max:1000'
        ]);
		
        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		} else {
			$user	= new \Stdclass;
			$user->email	= 'deepanchakravarthi.k@gmail.com';
			$data	= array('name' => $request->input('name'), 'email' => $request->input('email'), 'contactmessage' => $request->input('message'));
			Mail::send('emails.notification', $data, function($message) use ($user)
			{
				$message->to($user->email, $user->email)->subject(trans('words.ctrl_notification'));
			});
			return redirect('contact')->with('message', trans('words.thank_msg_contact'));
		}
	}
	public function showHome() {
		if(Session::has('locale')) {
			\App::setLocale(Session::get('locale'));
		}
		if (Auth::check()) {
			$userArray	= Auth::user();
		}
		return view('index');
	}
	
	public function showEnv()
	{
		//Session::flush();
		//	To find the environment
		$environment = App::environment();
		echo 'Env: '.$environment;
		echo "<pre>==>"; print_r(Session::get('temp_itinerary')); echo "</pre>";
		die();
		echo '<br>='.$this->dateDiff('12/05/2014 08:41:04', '12/05/2014 11:41:04');
		die();
		$hashedPassword	= Hash::make('testing');
		$hashedPassword	= '$2y$10$UWuVLig5BfkYZ/aqL/qw7OY5eL/pH4z1n5RM4oTuRT27msBmleT8y';
		echo '<br>Password: '.$hashedPassword;
		
		if (Auth::check())
		{
		    echo '<br>The user is logged in...';
		}
		
		if (Hash::check('testing', $hashedPassword))
		{
		    // The passwords match...
			echo '<br>===>matched';
		}
		//	To find the version
		$laravel = app();
		$version = $laravel::VERSION;
		echo '<br>Version: '.$version;
		die();
	}
	
	function dateDiff($start, $end = false)
	{
		$return = array();
		try {
			$start	= new DateTime($start);
			$end	= new DateTime($end);
			$form	= $start->diff($end);
		} catch (Exception $e) {
			return $e->getMessage();
		}
   		
		$display = array('h'=>'hour',
						'i'=>'minute',
						's'=>'second');
		foreach($display as $key => $value){
			if($form->$key > 0){
				//$return[] = $form->$key.' '.($form->$key > 1 ? $value.'s' : $value);
				$return[] = sprintf("%02d", $form->$key);
			} else {
				$return[] = '00';
			}
		}
		return implode($return, ':');
	}
	
}