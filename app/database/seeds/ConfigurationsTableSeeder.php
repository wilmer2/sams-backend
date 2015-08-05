<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

use Sams\Entity\Configuration;

class ConfigurationsTableSeeder extends Seeder {

	public function run()
	{
			Configuration::create([
				 'id' => 1,
				 'name_institution' => 'Sams',
				 'maximum_delay'    =>  5,
				 'control_menu'     =>  1,
				 'control_employee' =>  1,
				 'max_hours'        =>  '08:00',
				 'max_permits'      =>  4,
				 'max_impeachment'  =>  20,
				 'min_time'         =>  30
				]);
	}

}