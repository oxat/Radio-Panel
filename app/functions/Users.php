<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class Users {
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
		}elseif($this->user->get()->rank == 0){
			return Header::location('/');
		}
		$getPage	= (int) \App::get('p');
		$Getid		= (int) \App::get('id');
		$GetUpdate	= (string) 	 \App::post('update');
		$user		= (string) 	 \App::post('user');
		$email		= (string) 	 \App::post('email');
		$mobile		= (string)  \App::post('mobile');
		$name		= (string) 	 \App::post('name');
		$rank		= (int) 	 \App::post('rank');
		$delete		= (string) \App::post('delete');
		$message	= ['success' => null, 'text' => null, 'error' => null];

		$max   = $this->sql->fetch_array("select * from `admins`");
		$paginas = ceil((int) count($max) / 25);
		$pagina  = (intval(Isset($getPage) && is_numeric($getPage) && $getPage >= 1 && $getPage <= $paginas) ? $getPage : 1);
		$limite = ($pagina - 1) * 25 - 1;
		If($limite > count($max) || $limite < 0)
		$limite = 0;
			Else
		$limite--;
		$paginas = ceil((int) count($max) / 25);
		$fim   = $pagina > 5 ? ($pagina + 5 > $paginas ? $paginas : $pagina + 5) : 10;
		If($paginas < $fim)
			$fim = $paginas;
		$users = $this->sql->fetch_array("SELECT * from `admins` ORDER BY `id` DESC LIMIT {$limite}, 27");
		$inicio = $fim - 9 < 1 ? 1 : $fim - 9;
		if($delete){
			$decode = base64_decode($delete);
			$this->user->deluser($decode);
			$message['success'] = 'User is Delete!';
		}
		if($Getid){
			$u = $this->sql->fetch_array("SELECT * FROM `admins` WHERE `id`=" . intval($Getid));
			If(empty($u)){
				die('Error Not Fond');
			}
			if ($GetUpdate) {
			$this->user->updateData('admins',
								[
									'user'   	    => $user,
									'email'   	    => $email,
									'mobile' 			=> $mobile,
									'Name' 	=> $name,
									'rank' 			=> $rank
								],
								[
									'id' => $u[0]['id']
								]
						);
				$message['success'] = 'User '.$u[0]['user'].' Update! Waiting for loading!';
			}
			$getPage  = View::get('edituser', [
													'user' => $u,
													'message' => $message
												]);
			return View::render('layout/main', [
				'title'      => 'Edit User - ' . $u[0]['user'], 
				'page'       => $this->page,
				'user'       => $this->user,
				'html'       => $getPage,
				'breadcrumb' => ['', ''],
			]);
		}else{
			$list = [];
			foreach ($users as $u) {
				$list[] = [
						'id' => $u['id'],
						'user' => $u['user'],
						'Name' => $u['Name'],
						'email' => $u['email'],
						'mobile' => $u['mobile'],
						'rank' => $u['rank']
					];
			}
			$getPage  = View::get('users', [
												'users'		=> $list,
												'pagina'	=> $pagina, //for pagination
												'inicio'	=> $inicio,
												'fim'		=> $fim,
												'message'	=> $message,
												'paginas'	=> $paginas
											]);
			
			return View::render('layout/main', [
				'title'			=> 'Users', 
				'page'			=> $this->page,
				'user'			=> $this->user,
				'html'			=> $getPage,
				'breadcrumb'	=> ['', ''],
			]);
		}
	}
}