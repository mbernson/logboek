<?php

class LegalsTableSeeder extends Seeder {

  public function run() {

    /* see code below the laws */
    /* Import legal array */
    if(!@include("./app/database/includes/legalArr.php"))
      throw new Exception('Failed to include the legal file');
    /* Import legal data */
    if(!@include("./app/database/includes/legals.php"))
      throw new Exception('Failed to include the legal file');
    /* end legals */

    $query = DB::table('legals')->get();
    $exist = count($query);

    if($exist == 0) {
      for($i=0;$i<count($legals);$i++) {
        $legals[$i]['body'] = $legal[$i];
        $legals[$i]['html_body'] = Markdown::string($legals[$i]['body']);
      }

      Legal::insert($legals);
    } elseif(count($legals) != $exist) {
      throw new Exception('Difference legal rows. Delete rows for new import.');
    }
  }
}
