<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class Account {
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
		$GetUpdate			= (string) 	 \App::post('update');
		$title				= (string) 	 \App::post('title');
		$host_add			= (string) 	 \App::post('host_add');
		$os					= (string) 	 \App::post('os');
		$dir				= (string) 	 \App::post('dir');
		$ssh_user			= (string) 	 \App::post('ssh_user');
		$ssh_pass			= (string) 	 \App::post('ssh_pass');
		$ssh_port			= (string) 	 \App::post('ssh_port');
		$shellset			= (string) 	 \App::post('shellset');
		$php_exe			= (string) 	 \App::post('php_exe');
		$display_limit		= (string) 	 \App::post('display_limit');
		$message		= ['status' => null, 'text' => null];
		$config			= $this->sql->fetch_array("SELECT * FROM `config` WHERE `id`= 1");

		if ($GetUpdate) {
			$this->user->updateData('config',
									[
										'title'			=> $title,
										'host_add'		=> $host_add,
										'dir_to_cpanel'	=> $dir,
										'ssh_user'		=> $ssh_user,
										'ssh_pass'		=> $ssh_pass,
										'ssh_port'		=> $ssh_port,
										'shellset'		=> $shellset,
										'php_exe'		=> $php_exe,
										'display_limit'	=> $display_limit
									],
									[
										'id' => 1
									]
							);
			$message['success'] = 'New settings is update!';
			
		}

		return View::render('layout/main', [
					'title'		=> 'Settings Account',
					'page'		=> $this->page,
					'user'		=> $this->user,
					'html'		=> View::get('account', [
						'user'		=> $this->user,
						'conf'		=> $config,
						'message'	=> $message,
					]),
					'nohero'		=> true,
				]);
	}
}
