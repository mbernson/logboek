<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
class LegalsController extends \BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $legals = DB::table('legals')->select('id', 'name', 'body', 'abbreviation')
                ->where('active', '1')
                ->orderBy('name')
                ->paginate(10);
    return View::make('legals.index', ['legals' => $legals]);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    return View::make('legals.create', ['legal' => new Legal()]);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $legal = new Legal();
    $legal->unguard();
    $legal->fill(Input::only(['name', 'body', 'abbreviation', 'active']));

    if($legal->validate()) {
      $legal->save();
    } else {
      return View::make('legals.edit', ['legal' => $legal])
        ->withErrors($legal->validator());
    }

    return Redirect::to(route('settings.index'))
      ->with('message', [
        'content' => 'Wet met succes aangemaakt!',
        'class' => 'success'
      ]);
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $attachment_id
   * @return Response
   */
  public function show($legal_id) {
    //TO DO LATER
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $attachment_id
   * @return Response
   */
  public function edit($legal_id) {
    try{
      return View::make('legals.edit', [
        'legal' => Legal::findOrFail($legal_id)
      ]);
    } catch(ModelNotFoundException $e) {
      return Redirect::to(route('legals.index'))
        ->with('message', [
          'content' => 'Wet niet gevonden!',
          'class' => 'danger'
        ]);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $attachment_id
   * @return Response
   */
  public function update($legal_id) {
    $legal = Legal::findOrFail($legal_id);

    $legal->unguard();
    $legal->fill(Input::only('name', 'body', 'abbreviation', 'active'));

    if($legal->validate()) {
      $legal->save();
    } else {
      return View::make('legals.edit', ['legal' => $legal])
        ->withErrors($legal->validator());
    }

    return Redirect::to(route('settings.index'))
      ->with('message', [
        'content' => 'Wet met succes geupdated!',
        'class' => 'success'
      ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $attachment_id
   * @return Response
   */
  public function destroy($legal_id) {
    $legal = Legal::findOrFail($legal_id);
    $legal->delete();
    return Redirect::to(route('settings.index'))
      ->with('message', [
        'content' => 'Wet met succes verwijderd!',
        'class' => 'success'
      ]);

  }

}
