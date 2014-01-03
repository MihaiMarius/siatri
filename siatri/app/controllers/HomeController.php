<?php

class HomeController extends BaseController {
	public $layout = 'layouts/master';

	public function index()
	{
		$this->layout->content = View::make('login.index');
	}
}