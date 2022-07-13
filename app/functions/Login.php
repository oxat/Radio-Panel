<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Validator;

class Login {
	protected $page;
	protected $user;

	public function __construct() {
		$this->page = new Page();    
		$this->user = new Admin();
	}

	public function index() {
		if ($this->user->isAuth()) {
			return Header::location('/');
		}
		$breadcrumb	= explode('/', \App::getUrl());
		$message	= ['success' => null, 'text' => null, 'error' => null];
		$user		= (string) \App::post('user');
		$pass		= (string) \App::post('pass');

		if (\App::method() === 'POST') {
			if (!Validator::isFilled([$user, $pass])) {
				$message['error'] = 'Missing fields';
			} else {
				$login = $this->user->doLogin($user, $pass);
				if ($login) {
					$userdetails  = $this->user->userdetails(ipAddr());
					$this->user->updateData('admins',
									[
										'contry'	=> $userdetails['country'],
										'city'		=> $userdetails['city'],
										'data'		=> time(),
										'ip'		=> $userdetails['ip']
									],
									[
										'user' => $user
									]
							);
					Header::refresh(3);
					$message['success'] = 'You have been logged in, refreshing the page in 3 seconds';
				} else {
					$message['error'] = 'Invalid username or password';
				}
			}
		}
		return View::render('layout/main2', [
			'page'		=> $this->page,
			'user'		=> $this->user,
			'html'		=> View::get('login', [
				'user'		=> $this->user,
				'message'	=> $message,
				'title'		=> 'Radio Panel v2',
			]),
			'nohero'		=> true,
			'breadcrumb'	=> $breadcrumb,
		]);
	}
}
function ipAddr(): string {
			return array_key_exists("HTTP_CF_CONNECTING_IP", $_SERVER) 
				? $_SERVER["HTTP_CF_CONNECTING_IP"] 
				: $_SERVER['REMOTE_ADDR'];
		}