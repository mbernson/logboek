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
        /* Forensische Artikel 1 - COMPUTERVREDEBREUK */
        array(
          'name' => 'Computervredebreuk',
          'body' => '',
          'html_body' => '',
          'abbreviation' => 'Artikel 138ab',
          'code' => 'Wetboek van strafrecht',
        ),

        /* Forensische Artikel 2 - RECHTEN VAN DE MENS (PRIVACY) */
        array(
          'name' => 'Rechten van de mens - Privacy',
          'body' => '',
          'html_body' => '',
          'abbreviation' => 'Artikel 8',
          'code' => 'Europees Verdrag - RVDM',
        ),

        /* Forensische Artikel 3 - INBESLAGNEMING (ALGEMEEN) */
        array(
          'name' => 'Inbeslagneming (algemeen)',
          'body' => '',
          'html_body' => '',
          'abbreviation' => 'Artikel 94',
          'code' => 'Wetboek van Strafvordering',
        ),

        /* Forensische Artikel 4 INBESLAGNEMING (OPSPORINGSAMBTENAREN OF BIJZONDERE PERSONEN) */
        array(
          'name' => 'Inbeslagneming (opsporingsambtenaren of bijzondere personen)',
          'body' => '',
          'html_body' => '',
          'abbreviation' => 'Artikel 95',
          'code' => 'Wetboek van Strafvordering',
        ),

        /* Forensische Artikel 5 VORDERING (COMMUNICATIE TAB) */
        array(
          'name' => 'Vordering (communicatie tab)',
          'body' => '',
          'html_body' => '',
          'abbreviation' => 'Artikel 126n',
          'code' => 'Wetboek van Strafvordering',
        ),

        /* Forensische Artikel 6 VORDERING (COMMUNICATIE GEGEVENS)*/
        array(
          'name' => 'Vordering (communicatie gegevens)',
          'body' => '',
          'html_body' => '',
          'abbreviation' => 'Artikel 126na',
          'code' => 'Wetboek van Strafvordering',
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
