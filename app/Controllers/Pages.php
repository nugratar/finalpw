<?php

namespace App\Controllers;

class Pages extends BaseController
{
	public function index()
	{
		// $faker = \Faker\Factory::create();
		// dd($faker->address);
		$data = [
			'title' => "HOME | NUGRATAR"
		];
		return view('pages/home', $data);
	}
}
