<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$users = User::orderBy('username')
			->paginate(self::$per_page);

		return View::make('users.index', ['users' => $users]);
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
		return [
			'content' => "Welkom bij het IPFIT-logboek, $username!",
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
		$user->fill(Input::only('username', 'email', 'password'));

		if($user->validate()) {
			$user->password = Hash::make(Input::get('password'));
			$user->save();
		} else {
			$user->password = null; // Don't send the password back over the wire
			return View::make('users.create', ['user' => $user])
				->withErrors($user->validator());
		}

		return Redirect::to(route('users.index'))
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
		$user = User::findOrFail($user_id);
		return View::make('users.edit', ['user' => $user]);
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
		$user->fill(Input::only('username', 'email'));
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

		return Redirect::to(route('users.index'))
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
	public function destroy($id) {
		//
	}


}
