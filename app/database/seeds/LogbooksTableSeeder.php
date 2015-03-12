<?php
class LogbooksTableSeeder extends Seeder {
	public function run() {
		$exist = DB::table('logbooks')->where('title', 'Algemeen logboek')->first();

		if(!$exist) {
			$general = new Logbook(['title' => 'Algemeen logboek', 'user_id' => 1]);
			$general->save();
		}

		// Create a personal logbook for every user
		foreach(User::all() as $user) {
			if(substr($user->email, 0, 6) === 'system') continue;

			$name = ucfirst($user->username);

			$exist = DB::table('logbooks')->where('title', "$name's logboek")->first();

			if(!$exist) {
				$logbook = new Logbook(['title' => "$name's logboek", 'user_id' => $user->id]);
				$logbook->save();
			}
		}
	}
}
