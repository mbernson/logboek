<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return Redirect::to('/settings');
	}

	/**
	 * Attempt to log the user in, or display the login view
	 *
	 * @return Response
	 */
	public function login() {
		$input = Input::only('username', 'password');
		$remember = Input::get('remember') || false;

		if(Request::instance()->isMethod('post'))
			return $this->attempt_auth($input, $remember);
		else
			return View::make('layouts.login');
	}

	private function attempt_auth($input, $remember = false) {
		if(Auth::attempt($input, $remember)) {
			return Redirect::intended('/intro')
				->with('message', self::login_success_message());
		} else {
			Session::flash('message', self::login_error_message());

			return View::make('layouts.login');
		}
	}

	private static function login_success_message() {
		if(!Auth::check())
			return false;

		$username = Auth::user()->username;
		$project_name = Setting::get('project_name');
		return [
			'content' => "Welkom bij het $project_name logboek, $username!",
			'class' => 'success'
		];
	}
	private static function login_error_message() {
		return [
			'class' => 'danger',
			'content' => Lang::get('messages.login_incorrect')
		];
	}

	/**
	 * Clear the user's session
	 *
	 * @return Response
	 */
	public function logout() {
		Auth::logout();
		return Redirect::to('/login')->with('message', [
			'content' => 'Je bent uitgelogd.',
			'class' => 'success'
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('users.create', [
			'user' => new User()
		]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$user = new User();

		$user->unguard();
		$user->fill(Input::only('username', 'email', 'password', 'rights', 'first_name', 'last_name', 'student_number'));

		if($user->validate()) {
			$user->password = Hash::make(Input::get('password'));
			$user->save();
		} else {
			$user->password = null; // Don't send the password back over the wire
			return View::make('users.create', ['user' => $user])
				->withErrors($user->validator());
		}

		return Redirect::to(route('settings.index'))
			->with('message', [
				'content' => 'Gebruiker met succes aangemaakt!',
				'class' => 'success'
			]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		$user = User::find($id);
		return View::make('users.show', ['user' => $user]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($user_id) {
		if(Auth::user()['rights'] == 0 && Auth::user()['id'] != $user_id) {
			return Redirect::to(route('settings.index'))
				->with('message', [
					'content' => 'Voor deze handelingen zijn administrator rechten nodig.',
					'class' => 'danger'
				]);
		} else {
			try{
				$user = User::findOrFail($user_id);
				return View::make('users.edit', ['user' => $user]);
			} catch(ModelNotFoundException $e) {
	    	return Redirect::to(route('settings.index'))
					->with('message', [
						'content' => 'Gebruiker niet gevonden!',
						'class' => 'danger'
					]);
			}
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($user_id) {
		$user = User::findOrFail($user_id);

		$user->unguard();
		$user->fill(Input::only('username', 'email', 'rights', 'first_name', 'last_name', 'student_number'));
		if(Input::has('password'))
			$user->password = Input::get('password');

		if($user->validate()) {
			if(Input::has('password'))
				$user->password = Hash::make(Input::get('password'));
			$user->save();
		} else {
			$user->password = null; // Don't send the password back over the wire
			return View::make('users.edit', ['user' => $user])
				->withErrors($user->validator());
		}

		return Redirect::to(route('settings.index'))
			->with('message', [
				'content' => 'Gebruiker met succes geupdated!',
				'class' => 'success'
			]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($user_id) {
		$entry = User::findOrFail($user_id);
		$user = $entry['username'];
		$entry->delete();

		$count = Logbook::where('user_id', '=', $user_id)->count();

		$logbooks = Logbook::where('user_id', '=', $user_id)->update(array('user_id' => 0));
		$tasks = Task::where('user_id', '=', $user_id)->update(array('user_id' => 0));
		$attachments = Attachment::where('user_id', '=', $user_id)->update(array('user_id' => 0));

		if($count == 1){
			return Redirect::to(route('settings.index'))
				->with('message', [
					'content' => 'Gebruiker met succes verwijderd! Let op, '.$count.' logboek van gebruiker '.$user.' is veranderd naar eigenaar Systeem!',
					'class' => 'warning'
				]);
		} else if($count > 1){
			return Redirect::to(route('settings.index'))
				->with('message', [
					'content' => 'Gebruiker met succes verwijderd! Let op, '.$count.' logboeken van gebruiker '.$user.' zijn veranderd naar eigenaar Systeem!',
					'class' => 'warning'
				]);
		}

		return Redirect::to(route('settings.index'))
			->with('message', [
				'content' => 'Gebruiker met succes verwijderd!',
				'class' => 'success'
			]);
	}


}
