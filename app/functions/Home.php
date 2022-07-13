<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class Home {
	protected $page;
	protected $user;
	protected $sql;

	public function __construct() {
		$this->page = new Page();
		$this->user = new Admin();
		$this->sql = new Database;
	}

	public function index() {
		if (!$this->user->isAuth()) {
			return Header::location('/login');
		}
		$owns		= $this->user->get()->user;
		$message	= ['success' => null, 'text' => null, 'error' => null];

		$server = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `owner`= '{$owns}'");
		$ticket = $this->sql->fetch_array("SELECT * FROM `ticket` WHERE `user`='{$owns}'");
			$list = [];
			foreach ($server as $u) {
				$list[] = [
						'id'		=> $u['id'],
						'own'		=> $u['owner'],
						'port'		=> $u['portbase'],
						'status'	=> $this->user->server('status' , $u['portbase']),
						'statusdj'	=> $this->user->autodj('status' , $u['portbase']),
						'space'		=> $this->user->get_dir_size('./uploads/'. $u['portbase'] .'/'),
						'streamurl'	=> $u['streamurl']
					];
			}
		$getPage  = View::get('home', [
										'tserver'		=> count($server),
										'server'		=>$list,
										'ticket'		=> count($ticket),
										'rank'			=> $this->user->get()->rank,
										'message'		=> $message
									]);
		return View::render('layout/main', [
			'title'			=> 'Home', 
			'page'			=> $this->page,
			'user'			=> $this->user,
			'html'			=> $getPage,
			'breadcrumb'	=> ['', ''],
		]);
	}
}