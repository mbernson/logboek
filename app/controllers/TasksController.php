<?php

class TasksController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$users_options = [];
		foreach(User::all() as $user)
			$users_options[$user->id] = $user->username;

		View::share(['users_options' => $users_options]);
	}

	public function dashboard() {

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return View::make('tasks.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('tasks.create', [
                        'task' => new Task(),
		]);

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$task = new Task();

		$task->fill(Input::only(['name', 'user_id', 'desc']));
		$task->deadline = new DateTime(Input::get('deadline'));
                $task->save();

                return Redirect::to(route('tasks.index'))
			->with('message', [
				'content' => 'Taak toegevoegd',
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
		$task = Task::find($id);
		return View::make('tasks.show', array( 'task' => $task));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($task_id) {
		$task = Task::findOrFail($task_id);
		return View::make('tasks.edit', [ 'task' => $task ]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($task_id) {
		$task = Task::findOrFail($task_id);

		$task->fill(Input::only(['name', 'user_id']));
                $task->save();

                return Redirect::to(route('tasks.index'));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($task_id) {
		$entry = Task::findOrFail($task_id);
                $entry->delete();

		return Redirect::to(route('tasks.index'));
	}


}