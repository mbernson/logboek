<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
class CustodyController extends \BaseController {

  public function __construct() {
    parent::__construct();

    $users = User::all();
		$responsible = [];
		foreach($users as $user) {
			if($user->first_name != '' && $user->last_name != '') {
        $responsible[$user->first_name .' '. $user->last_name] = $user->first_name .' '. $user->last_name;
      }
    }

    $authUser = NULL;
    try{
      if(Auth::user()->first_name != '' && Auth::user()->last_name != '')
        $authUser = Auth::user()->first_name .' '. Auth::user()->last_name;
    } catch(Exception $e) { }

    View::share('responsible', $responsible);
    View::share('authUser', $authUser);
	}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    return Redirect::to('/evidences');
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    return View::make('custody.create', ['custody' => new Custody()]);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $custody = new Custody();
    $custody->unguard();

    $custody->fill(Input::only(['name', 'characteristic', 'location', 'responsible', 'seized', 'date', 'time', 'description', 'html_description', 'details', 'html_details', 'return']));

    $custody['time'] = date('Y-m-d H:m:s');
    $custody['html_description'] = Markdown::string($custody['description']);
    $custody['html_details'] = Markdown::string($custody['details']);

    if($custody->validate()) {
      $custody->save();
    } else {
      return View::make('custody.edit', ['custody' => $custody])
        ->withErrors($custody->validator());
    }

    return Redirect::to(route('evidences.index'))
      ->with('message', [
        'content' => 'Chain of Custody met succes aangemaakt!',
        'class' => 'success'
      ]);
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $attachment_id
   * @return Response
   */
  public function show($custody_id) {
    try{
				$custody = Custody::findOrFail($custody_id);
        return View::make('custody.show', [
					'custody' => $custody
				]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody niet gevonden!',
					'class' => 'danger'
				]);
		}
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $attachment_id
   * @return Response
   */
  public function edit($custody_id) {
    try{
			$custody = Custody::findOrFail($custody_id);
			return View::make('custody.edit', ['custody' => $custody]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody niet gevonden!',
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
  public function update($custody_id) {
    $custody = Custody::findOrFail($custody_id);

    if($custody->signature == 1) {
      return Redirect::to(route('evidences.index'))
  			->with('message', [
  				'content' => 'Chain of Custody door opdrachtgever getekend. Kan niet worden bewerkt!',
  				'class' => 'danger'
  			]);
    }

    $custody->fill(Input::only(['name', 'characteristic', 'location', 'responsible', 'seized', 'date', 'time', 'description', 'html_description', 'details', 'html_details', 'return']));

    $custody['time'] = date('Y-m-d H:m:s');
    $custody['html_description'] = Markdown::string($custody['description']);
    $custody['html_details'] = Markdown::string($custody['details']);

		if($custody->validate()) {
			$custody->save();
		} else {
			return View::make('custody.edit', ['custody' => $custody])
				->withErrors($custody->validator());
		}

		return Redirect::to(route('evidences.index'))
			->with('message', [
				'content' => 'Chain of Custody met succes geupdated!',
				'class' => 'success'
			]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $attachment_id
   * @return Response
   */
  public function destroy($custody_id) {
    $custody = Custody::findOrFail($custody_id);

    if($custody->signature == 1) {
      return Redirect::to(route('evidences.index'))
  			->with('message', [
  				'content' => 'Chain of Custody door opdrachtgever getekend. Kan niet worden verwijderd!',
  				'class' => 'danger'
  			]);
    } else {
      $custody->delete();
    }
		return Redirect::to(route('evidences.index'))
			->with('message', [
				'content' => 'Chain of Custody met succes verwijderd!',
				'class' => 'success'
			]);
  }

  public function sign($custody_id) {
    try{
        $custody = Custody::findOrFail($custody_id);
        if($custody['signed'] == 0) {
          return View::make('custody.sign', [
  					'custody' => $custody
  				]);
        } else {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody al getekend!',
    					'class' => 'danger'
    				]);
        }
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody niet gevonden!',
					'class' => 'danger'
				]);
		}
  }

  public function signUpdate($custody_id) {
    try{
        $custody = Custody::findOrFail($custody_id);
        if($custody['signed'] == 0) {

          $custody->fill(Input::only(['signed', 'signed_ip', 'signed_hash', 'signed_sign']));

          $custody['signed'] = 1;
          $custody['signed_ip'] = Request::getClientIp();
          $custody['signed_hash'] = md5(uniqid(rand(), true));
          $custody['signed_sign'] = Input::get('signed_sign');
          $custody['signed_date'] = date('Y-m-d');
          $custody['signed_time'] = date('Y-m-d H:m:s');

          if($custody->save()) {
            return Redirect::to(route('evidences.index'))
      				->with('message', [
      					'content' => 'Chain of Custody met succes ondertekend!',
      					'class' => 'success'
      				]);
          }

        } else {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody al getekend!',
    					'class' => 'danger'
    				]);
        }
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody kan niet worden ondertekend!',
					'class' => 'danger'
				]);
		}
  }

  public function signature($custody_id, $custody_hash) {
    try{
        $custody = Custody::findOrFail($custody_id);

        if($custody['signed'] == 1 && $custody['signature'] == 0) {
          if($custody['signed_hash'] == $custody_hash) {
            return View::make('custody.signature', [
    					'custody' => $custody
    				]);
          } else {
            return Redirect::to(route('evidences.index'))
      				->with('message', [
      					'content' => 'Chain of Custody hash komt niet overeen!',
      					'class' => 'danger'
      				]);
          }

        } else if ($custody['signed'] == 1 && $custody['signature'] == 1) {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody door opdrachtgever al getekend!',
    					'class' => 'danger'
    				]);
        } else if ($custody['signed'] == 0 && $custody['signature'] == 0) {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody nog niet getekend!',
    					'class' => 'danger'
    				]);
        } else {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Er is een fout opgetreden!',
    					'class' => 'danger'
    				]);
        }
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody niet gevonden!',
					'class' => 'danger'
				]);
		}
  }

  public function signatureUpdate($custody_id, $custody_hash) {
    try{
        $custody = Custody::findOrFail($custody_id);
        if($custody['signed'] == 1 && $custody['signature'] == 0) {

          $custody->fill(Input::only(['signature_name', 'signature_remark', 'html_signature_remark',
                              'signature_sign', 'signature_ip', 'signature_date', 'signature_time']));

          $custody['signed_hash'] = md5(uniqid(rand(), true)); //Create new hash
          $custody['signature'] = 1;
          $custody['signature_name'] = Input::get('signature_name');
          $custody['signature_remark'] = Input::get('signature_remark');
          $custody['html_signature_remark'] = Markdown::string($custody['signature_remark']);
          $custody['signature_sign'] = Input::get('signed_sign');
          $custody['signature_ip'] = Request::getClientIp();
          $custody['signature_date'] = date('Y-m-d');
          $custody['signature_time'] = date('Y-m-d H:m:s');

          if($custody['return'] == 1) {
            $custody['returned_hash'] = md5(uniqid(rand(), true));
          }

          if($custody->save()) {

            return View::make('custody.view', ['custody' => $custody]);

          }

        } else if($custody['signed'] == 1 && $custody['signature'] == 1) {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody al door opdrachtgever getekend!',
    					'class' => 'danger'
    				]);
        } else {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody kan niet worden ondertekend!',
    					'class' => 'danger'
    				]);
        }
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody kan niet worden ondertekend!',
					'class' => 'danger'
				]);
		}
  }

  public function log($custody_id) {
    try{
			$custody = Custody::findOrFail($custody_id);
			return View::make('custody.log', ['custody' => $custody]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody niet gevonden!',
					'class' => 'danger'
				]);
		}
  }

  public function logUpdate($custody_id) {
    try{
      $custody = Custody::findOrFail($custody_id);

      $custody['log'] = Input::get('log');
      $custody['html_log'] = Markdown::string(Input::get('log'));

  		$custody->save();

  		return Redirect::to(route('evidences.index'))
  			->with('message', [
  				'content' => 'Log Chain of Custody met succes geupdated!',
  				'class' => 'success'
  			]);
    } catch(ModelNotFoundException $e) {
      return Redirect::to(route('evidences.index'))
        ->with('message', [
          'content' => 'Chain of Custody niet gevonden!',
          'class' => 'danger'
        ]);
    }
  }

  public function returned($custody_id, $custody_hash) {
    try{
        $custody = Custody::findOrFail($custody_id);

        if($custody['return'] == 1 && $custody['returned'] == 0) {
          if($custody['returned_hash'] == $custody_hash) {
            return View::make('custody.return', [
    					'custody' => $custody
    				]);
          } else {
            return Redirect::to(route('evidences.index'))
      				->with('message', [
      					'content' => 'Chain of Custody hash komt niet overeen!',
      					'class' => 'danger'
      				]);
          }

        } else if ($custody['return'] == 1 && $custody['returned'] == 1) {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody al geretourneerd!',
    					'class' => 'danger'
    				]);
        } else if ($custody['signed'] == 0 && $custody['signature'] == 0) {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody hoeft niet retour!',
    					'class' => 'danger'
    				]);
        } else {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Er is een fout opgetreden!',
    					'class' => 'danger'
    				]);
        }
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody niet gevonden!',
					'class' => 'danger'
				]);
		}
  }

  public function returnedUpdate($custody_id, $custody_hash) {
    try{
        $custody = Custody::findOrFail($custody_id);
        if($custody['return'] == 1 && $custody['returned'] == 0) {

          $custody->fill(Input::only(['returned_remark']));

          $custody['returned_hash'] = md5(uniqid(rand(), true)); //Create new hash
          $custody['returned'] = 1;
          $custody['returned_remark'] = Input::get('signature_remark');
          $custody['html_returned_remark'] = Markdown::string($custody['returned_remark']);
          $custody['returned_sign'] = Input::get('signed_sign');
          $custody['returned_ip'] = Request::getClientIp();
          $custody['returned_date'] = date('Y-m-d');
          $custody['returned_time'] = date('Y-m-d H:m:s');

          if($custody->save()) {
            return View::make('custody.view', ['custody' => $custody]);
          }

        } else if($custody['signed'] == 1 && $custody['signature'] == 1) {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody al retour naar opdrachtgever!',
    					'class' => 'danger'
    				]);
        } else {
          return Redirect::to(route('evidences.index'))
    				->with('message', [
    					'content' => 'Chain of Custody kan niet worden ondertekend!',
    					'class' => 'danger'
    				]);
        }
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('evidences.index'))
				->with('message', [
					'content' => 'Chain of Custody kan niet worden ondertekend!',
					'class' => 'danger'
				]);
		}
  }

}
