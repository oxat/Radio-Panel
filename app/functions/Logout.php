<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;

class Logout {
	protected $page;
	protected $user;

	public function __construct() {
		$this->page = new Page();    
		$this->user = new Admin();
	}

	public function index() {
		if (!$this->user->isAuth()) {
			return Header::location('/');
		}
		$this->user->doLogout();
		$breadcrumb = explode('/', \App::getUrl());
		$message['success'] = 'You have been logged out, redirecting in 3 seconds';
		Header::refresh(2);

		return View::render('layout/main', [
			'title'		=> 'Logout',
			'page'		=> $this->page,
			'user'		=> $this->user,
			'html'		=> View::get('home', [
				'user'		=> $this->user,
				'message'	=> $message,
			]),
			'nohero'		=> true,
			'breadcrumb'	=> $breadcrumb,
		]);
	}
}