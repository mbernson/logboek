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

		return View::make('users.index', array('users' => $users));
	}


	public function login() {
		$input = Input::only('username', 'password');
		$remember = Input::get('remember') || false;

		if(Request::instance()->isMethod('post')) {
			if(Auth::attempt($input, $remember)) {
				return Redirect::intended('/');
			} else {
				Session::flash('message', array(
					'class' => 'error',
					'content' => Lang::get('messages.login_incorrect')
				));
				return View::make('layouts.login');
			}
		} else {
			return View::make('layouts.login');
		}
	}

	public function logout() {
		Auth::logout();
		return Redirect::to('/login');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		$user = User::find($id);

		return View::make('users.show', array('user' => $user));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		//
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
