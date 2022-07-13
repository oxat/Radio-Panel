<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class AllServers {
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
		if($this->user->get()->rank == 1){
			$owns		= $this->user->get()->user;
			$getPage	= (int) \App::get('p');
			$Getid		= (int) \App::get('id');
			$GetUpdate	= (string) 	 \App::post('update');
			$delete		= (string) \App::post('delete');
			$message	= ['success' => null, 'text' => null, 'error' => null, 'ref' => null];
			
			$password			= (string) 	 \App::post('password');
			$passadm			= (string) 	 \App::post('passadm');
			$showlastsongs		= (string)  \App::post('showlastsongs');
			$namelookups		= (string) 	 \App::post('namelookups');
			$relayport			= (string) 	 \App::post('relayport');
			$relayserver		= (string) 	 \App::post('relayserver');
			$introfile			= (string) 	 \App::post('introfile');
			$titleformat		= (string) 	 \App::post('titleformat');
			$urlformat			= (string) 	 \App::post('urlformat');
			$allowrelay			= (string) 	 \App::post('allowrelay');
			$allowpublicrelay	= (string) 	 \App::post('allowpublicrelay');
			
			$max   = $this->sql->fetch_array("select * from `servers`");
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
			$servers = $this->sql->fetch_array("SELECT * from `servers` ORDER BY `id` DESC LIMIT {$limite}, 27");
			$inicio = $fim - 9 < 1 ? 1 : $fim - 9;
			if($delete){
				$decode = base64_decode($delete);
				$svs = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `id`=" . intval($decode));
				if (file_exists("./uploads/".$svs[0]['portbase']."/")) {
					$dir = './uploads/'.$svs[0]['portbase']; // Delete Files Mp3 and directory uploads
					$this->user->deleteDir($dir);
					$temp = './temp/'.$svs[0]['portbase']; // Delete Files directory Temp
					$this->user->deleteDir($temp);
					$this->user->server('stop' , $svs[0]['portbase']); //Stop server to delete
					$this->user->autodj('stop' , $svs[0]['portbase']); //Stop autodj to delete
					$message['ref'] = 'File is delete!';
					$this->user->delserver($decode);
				}else {
					$message['error'] = 'File not fond!';
				}
			}
			if($Getid){
				$s = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `id`=" . intval($Getid));
				If(empty($s)){
					return Header::location('/404');
				}
				if ($GetUpdate) {	
					$this->user->updateData('servers',
									[
										'password'			=> $password,
										'adminpassword'		=> $passadm,
										'showlastsongs'		=> $showlastsongs,
										'namelookups'		=> $namelookups,
										'relayport'			=> $relayport,
										'relayserver'		=> $relayserver,
										'introfile'			=> $introfile,
										'titleformat'		=> $titleformat,
										'urlformat'			=> $urlformat,
										'allowrelay'		=> $allowrelay,
										'allowpublicrelay'	=> $allowpublicrelay
									],
									[
										'id' => $s[0]['id']
									]
							);
					$message['success'] = 'Your Server ['.$s[0]['id'].'] Update! Waiting for loading!';
				}
				$getPage  = View::get('serveredit', [
													'sv'		=> $s,
													'message'	=> $message
												]);
					return View::render('layout/main', [
						'title'      => 'Edit Server [' . $s[0]['id'] .']', 
						'page'       => $this->page,
						'user'       => $this->user,
						'html'       => $getPage,
						'breadcrumb' => ['', ''],
					]);
			}else{
				$start		= (string) 	 \App::post('start');
				$stop		= (string) 	 \App::post('stop');
				if($start){
				$sts = $this->user->server('start' , $start);
					if($sts){
						$message['success'] = 'Server ['.$start.']  Started!';
					}else{
						$message['error'] = 'Server ['.$start.'] is online!';
					}
				}
				if($stop){
					$sts = $this->user->server('stop' , $stop);
					if($sts){
						$message['error'] = 'Server ['.$stop.'] is offline!';
					}else{
						$message['success'] = 'Server ['.$stop.'] Stoped!';
					}
				}
				$list = [];
				foreach ($servers as $u) {
					$list[] = [
							'id'		=> $u['id'],
							'own'		=> $u['owner'],
							'port'		=> $u['portbase'],
							'status'	=> $this->user->server('status' , $u['portbase']),
							'space'		=> $this->user->get_dir_size('./uploads/'. $u['portbase'] .'/'),
							'streamurl'	=> $u['streamurl']
						];
				}
				
				$getPage  = View::get('allservers', [
													'servers'	=> $list,
													'pagina'	=> $pagina, //for pagination
													'inicio'	=> $inicio,
													'fim'		=> $fim,
													'message'	=> $message,
													'paginas'	=> $paginas
												]);
				
				return View::render('layout/main', [
					'title'			=> 'All Servers', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
			}
		}else{
			return Header::location('/');
		}
	}
}
