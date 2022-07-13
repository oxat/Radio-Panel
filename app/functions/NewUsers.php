<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Validator;
use Vendor\Security;

class NewUsers {
	protected $page;
	protected $user;

	public function __construct() {
		$this->page = new Page();
		$this->user = new Admin();
	}

	public function index() {
		if (!$this->user->isAuth()) {
			return Header::location('/login');
		}elseif($this->user->get()->rank == 0){
			return Header::location('/');
		}
		$user	= (string) \App::post('user');
		$pass	= (string) \App::post('pass');
		$email	= (string) \App::post('email');
		$mobile	= (string) \App::post('mobile');
		$Name	= (string) \App::post('Name');

		$register	= (string) \App::post('register');
		$stop		= 0;
		$message	= ['success' => null, 'text' => null, 'error' => null];
		$parameters	= ['user' => $user, 'pass' => $pass];
		while(1) {
			if (!$register) { break; }
			if (strlen($user) < 5) {
				$message    = ['status' => 'red', 'text' => 'Username minim 5 caractere'];
				$stop = 1;
			}
			if(strlen($pass) < 6){
				$message    = ['status' => 'red', 'text' => 'Parola trebuie sa fie mai mare de 6 carctere!'];
				$stop = 1;
			}
			if ($this->user->Exist($user)) {
				$message    = ['status' => 'red', 'text' => 'Exista deja un cont cu acest nume de utilizator!'];
				$stop = 1;
			}
			$CheckMail = $this->user->CheckEmail($email);
			if ($CheckMail) {
				$message    = ['status' => 'red', 'text' => 'Acest email a fot utilizat!'];
				$stop = 1;
			}
			if ($stop == 1) { break; }
				$this->user->InsertData('admins', 
						[
							'id'		=> Null,
							'user'		=> $user,
							'pass'		=> Security::encrypt($pass),
							'usrtoken'	=> 0,
							'email'		=>  $email,
							'Name'		=>  $Name,
							'mobile'	=>  $mobile,
							'rank'		=> 0,
							'ip'		=> $this->user->ipAddr(),
							'data'		=>  time()
						]);
						$message    = ['status' => 'green', 'text' => 'Contul sa creeat cu succes!'];
			break;
		}
		return View::render('layout/main', [
					'title'		=> 'Register',
					'page'		=> $this->page,
					'user'		=> $this->user,
					'html'		=> View::get('newusers', [
						'user'		=> $this->user,
						'message'	=> $message,
					]),
					'nohero'	=> true,
					'post'		=> $parameters,
				]);
	}
}