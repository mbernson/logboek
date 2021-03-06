<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
class LegalsController extends \BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $legals = DB::table('legals')->select('id', 'name', 'html_body', 'abbreviation', 'code')
                ->where('active', '1')
                ->orderBy('id')
                ->paginate(25);

    $all = 0;
    $criminalLaw = 0;
    $criminalProcedure = 0;
    $europeanRights = 0;

    foreach($legals as $legal) {
      if($legal->code == 'Wetboek van Strafrecht') {
        /* Count Strafrecht */
        $criminalLaw++;
      } else if($legal->code == 'Wetboek van Strafvordering') {
        /* Count Strafvordering */
        $criminalProcedure++;
      } else if($legal->code == 'Europees Verdrag') {
        /* Count Europees verdrag */
        $europeanRights++;
      }
      $all++;
    }

    return View::make('legals.index', ['legals' => $legals, 'all' => $all, 'criminalLaw' => $criminalLaw,
                      'criminalProcedure' => $criminalProcedure, 'europeanRights' => $europeanRights]);
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

    $legal->fill(Input::only(['name', 'body', 'html_body', 'abbreviation', 'active']));

    $legal['html_body'] = Markdown::string($legal['body']);

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
    return Redirect::to('/legals');
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
    $legal->fill(Input::only('name', 'body', 'html_body', 'abbreviation', 'active'));

    $legal['html_body'] = Markdown::string($legal['body']);

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
