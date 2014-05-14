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

	public function login() {
		$login_success_message = [
			'class' => 'success'
		];
		$login_error_message = [
			'class' => 'error',
			'content' => Lang::get('messages.login_incorrect')
		];

		$input = Input::only('username', 'password');
		$remember = Input::get('remember') || false;
		$username = Input::get('username');

		if(Request::instance()->isMethod('post')) {
			if(Auth::attempt($input, $remember)) {
				$login_success_message['content'] = "Welkom bij het IPFIT-logboek, $username!";
				return Redirect::intended('/')
					->with('message', $login_success_message);
			} else {
				Session::flash('message', $login_error_message);
				return View::make('layouts.login');
			}
		} else {
			return View::make('layouts.login');
		}
	}

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

		$user->username = Input::get('username');
		$user->email = Input::get('email');

		$password = Input::get('password');
		if(empty($password))
			throw new Exception('Password can not be empty.');

		$user->password = Hash::make($password);

		$user->save();

		return Redirect::to(route('users.index'));
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

		$user->username = Input::get('username');
		$user->email = Input::get('email');

		$password = Input::get('password');
		if(!empty($password)) {
			$user->password = Hash::make($password);
		}

		$user->save();

		return Redirect::to(route('users.index'));
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
