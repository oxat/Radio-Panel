<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Security;

class Error404 {
	protected $page;
	protected $user;
	protected $params = ['crypt'];
	
	public function __construct(string $value) {
		$this->page = new Page();
		$this->user = new Admin();
		$path = pathinfo($value);
		$name = strtolower($path['dirname']);

		if (in_array($name, $this->params)) {
			$getParam = strip_tags($path['filename']);
			if ('crypt' === $name) {
				return View::plain(Security::encrypt($getParam));
			}
		}

		return View::render('layout/main', [
			'title'			=> 'Not Found', 
			'page'			=> $this->page,
			'user'			=> $this->user,
			'html'			=> View::get('error'),
			'nohero'		=> true,
			'breadcrumb'	=> ['', '404'],
		]);
	}
}
