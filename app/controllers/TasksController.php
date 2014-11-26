<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
class TasksController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$users = User::all();
		$users_options = [];
		foreach($users as $user)
			$users_options[$user->id] = $user->username;

		View::share('users_options', $users_options);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$tasks = Task::newest()->paginate(static::$per_page);
		return View::make('tasks.index', ['tasks' => $tasks]);

	}

	public function toggle($id) {
		if(Request::ajax()) {
			$task = Task::findOrFail($id);
			$task->status = ! $task->status;
			if($task->save())
				return Response::json([
					'status' => $task->status
				]);
		} else {
			App::abort(404);
		}
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
		$task->unguard();
		$task->fill(Input::only(['name', 'user_id', 'description', 'status']));

		try {
			$task->deadline = new DateTime(Input::get('deadline'));
		} catch(Exception $exception)	{
			return Redirect::to(route('tasks.create'))
			->with('message', [
				'content' => 'Deadline (datum) verkeerde notatie',
				'class' => 'danger'
				]);
		}

		if($task->validate()) {
			$task->save();
		} else {
			return View::make('tasks.edit', ['task' => $task])
				->withErrors($task->validator());
		}

		return Redirect::to(route('tasks.index'))
			->with('message', [
				'content' => 'Taak met succes aangemaakt!',
				'class' => 'success'
			]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($task_id) {
		try{
			$task = Task::findOrFail($task_id);
			return View::make('tasks.show', ['task' => $task]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('tasks.index'))
				->with('message', [
					'content' => 'Taak niet gevonden!',
					'class' => 'danger'
				]);
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($task_id) {
		try{
			$task = Task::findOrFail($task_id);
			return View::make('tasks.edit', ['task' => $task]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('tasks.index'))
				->with('message', [
					'content' => 'Taak niet gevonden!',
					'class' => 'danger'
				]);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($task_id) {
		$task = Task::findOrFail($task_id);

		$task->fill(Input::only(['name', 'user_id', 'description', 'status']));

		if(Input::has('deadline')) {
			try {
				$task->deadline = new DateTime(Input::get('deadline'));
			} catch(Exception $exception)	{
				return Redirect::to(route('tasks.index'))
				->with('message', [
					'content' => 'Deadline (datum) verkeerde notatie',
					'class' => 'danger'
					]);
			}
		}

		if($task->validate()) {
			$task->save();
		} else {
			return View::make('tasks.edit', ['task' => $task])
				->withErrors($task->validator());
		}

		return Redirect::to(route('tasks.index'))
			->with('message', [
				'content' => 'Taak met succes geupdated!',
				'class' => 'success'
			]);
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

		return Redirect::to(route('tasks.index'))
			->with('message', [
				'content' => 'Taak met succes verwijderd!',
				'class' => 'success'
			]);
	}


}
