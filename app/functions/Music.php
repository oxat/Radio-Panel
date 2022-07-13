<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class Music {
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
		$message	= ['success' => null, 'text' => null];
		$getPage	= (int) \App::get('p');
		$Getid		= (int) \App::get('id');
		
		$config		= $this->sql->fetch_array("SELECT * FROM `config` WHERE `id`= 1");
		$max		= $this->sql->fetch_array("select * from `servers` where owner = '{$owns}'");
		$paginas	= ceil((int) count($max) / 25);
		$pagina		= (intval(Isset($getPage) && is_numeric($getPage) && $getPage >= 1 && $getPage <= $paginas) ? $getPage : 1);
		$limite		= ($pagina - 1) * 25 - 1;
		If($limite > count($max) || $limite < 0)
		$limite = 0;
			Else
		$limite--;
		$paginas	= ceil((int) count($max) / 25);
		$fim		= $pagina > 5 ? ($pagina + 5 > $paginas ? $paginas : $pagina + 5) : 10;
		If($paginas < $fim)
			$fim = $paginas;
		$servers	= $this->sql->fetch_array("SELECT * from `servers` where owner = '{$owns}' ORDER BY `id` DESC LIMIT {$limite}, 27");
		$inicio		= $fim - 9 < 1 ? 1 : $fim - 9;

			$list = [];
			foreach ($servers as $u) {
				$list[] = [
						'id'		=> $u['id'],
						'own'		=> $u['owner'],
						'port'		=> $u['portbase'],
						'space'		=> $this->user->get_dir_size('./uploads/'. $u['portbase'] .'/'),
						'streamurl'	=> $u['streamurl']
					];
			}
			$getPage  = View::get('music', [
												'list'		=> $list,
												'pagina'	=> $pagina, //for pagination
												'inicio'	=> $inicio,
												'fim'		=> $fim,
												'ss'		=> 'ss2',
												'paginas'	=> $paginas
											]);
			return View::render('layout/main', [
				'title'			=> 'Music', 
				'page'			=> $this->page,
				'user'			=> $this->user,
				'html'			=> $getPage,
				'breadcrumb'	=> ['', ''],
			]);
	}
}