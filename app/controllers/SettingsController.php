<?php

class SettingsController extends \BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $settings = DB::table('settings')->get();
    $suspects = DB::table('suspects')->get();
    $users = User::orderBy('username')
      ->paginate(self::$per_page);

    return View::make('settings.index', ['settings' => $settings, 'users' => $users, 'suspects' => $suspects]);
  }

  public function update($setting_id) {
    $users = User::orderBy('username')
      ->paginate(self::$per_page);
    $settings = DB::table('settings')->get();

    $setting = Setting::findOrFail($setting_id);

    $setting->fill(Input::only(['project_name', 'vw_menu_entries', 'vw_menu_logbooks',
                                'vw_menu_logbooks', 'vw_menu_tasks', 'vw_menu_attachments',
                                'vw_menu_evidences', 'vw_menu_exports', 'vw_menu_cipher']));

    if($setting->validate()) {
      $setting->save();
    } else {
      return View::make('settings.index', ['settings' => $settings, 'users' => $users])
        ->withErrors($setting->validator());
    }

    return Redirect::to(route('settings.index'))
      ->with('message', [
        'content' => 'Instellingen met succes geupdated!',
        'class' => 'success'
      ]);
  }

}
