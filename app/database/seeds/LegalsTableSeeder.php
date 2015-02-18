<?php

class LegalsTableSeeder extends Seeder {

  public function run() {

    /* see code below the laws */
    if(!@include("./app/database/includes/legals.php"))
      throw new Exception('Failed to include the legal file');
    /* end legals */

    $query = DB::table('legals')->get();
    $exist = count($query);

    if($exist == 0) {
      $legals = array(
        array(
          'name' => 'Computervredebreuk',
          'body' => '',
          'html_body' => '',
          'abbreviation' => 'Artikel 138ab',
          'code' => 'Wetboek van strafrecht',
        ),
        array(
          'name' => 'biuer',
          'body' => '',
          'html_body' => 'test',
          'abbreviation' => 'hai',
          'code' => 'Wetboek van strafvordering',
        )
      );

      for($i=0;$i<count($legals);$i++) {
        $legals[$i]['body'] = $legal[$i];
        $legals[$i]['html_body'] = Markdown::string($legals[$i]['body']);
      }

      Legal::insert($legals);
    }
  }
}
