<?php

class SiteController extends BaseController {
	protected $layout = 'layout';

	public function home()
	{
        Session::clear();
	}
}