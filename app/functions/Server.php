<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class Server {
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
		$owns			= $this->user->get()->user;
		$getPage		= (int) \App::get('p');
		$Getid			= (int) \App::get('id');
		$GetUpdate		= (string) 	 \App::post('update');
		$message		= ['success' => null, 'text' => null, 'error' => null];
		$password		= (string) 	 \App::post('password');
		$passadm		= (string) 	 \App::post('passadm');
		$showlastsongs	= (string)  \App::post('showlastsongs');
		$namelookups	= (string) 	 \App::post('namelookups');
		$relayport		= (string) 	 \App::post('relayport');
		$relayserver	= (string) 	 \App::post('relayserver');
		$introfile		= (string) 	 \App::post('introfile');
		$titleformat	= (string) 	 \App::post('titleformat');
		$urlformat		= (string) 	 \App::post('urlformat');
		$allowrelay		= (string) 	 \App::post('allowrelay');
		$allowpub		= (string) 	 \App::post('allowpublicrelay');
		
		$config = $this->sql->fetch_array("SELECT * FROM `config` WHERE `id`= 1");
		$max	= $this->sql->fetch_array("select * from `servers` where owner = '{$owns}'");
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
		$servers = $this->sql->fetch_array("SELECT * from `servers` where owner = '{$owns}' ORDER BY `id` DESC LIMIT {$limite}, 27");
		$inicio = $fim - 9 < 1 ? 1 : $fim - 9;
		if($Getid){
			$s = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `id`=" . intval($Getid));
			If(empty($s)){
				return Header::location('/404');
			}
			if($owns == $s[0]['owner']){
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
										'allowpublicrelay'	=> $allowpub
									],
									[
										'id' => $s[0]['id']
									]
							);
					if ($config[0]['os'] == 'linux') {
						$filexml = getcwd() . "/temp/" . $s[0]['portbase'] . "/conf/sc_serv.conf";
					}
					
					unlink($filexml);
					$xml .= "maxuser=".$s[0]['maxuser']."\r\n";
					$xml .= "portbase=" . $s[0]['portbase'] . "\r\n";
					$xml .= "bitrate=".$s[0]['bitrate']."\r\n";
					$xml .= "password=".$password."\r\n";
					$xml .= "adminpassword=".$passadm."\r\n";
					$xml .= "logfile=" . getcwd() . '/temp/'.$s[0]['portbase'].'/logs/sc_' . $s[0]['portbase'] . ".log\r\n";
					$xml .= "realtime=".$s[0]['realtime']."\r\n";
					$xml .= "screenlog=" . $s[0]['screenlog'] . "\r\n";
					$xml .= "showlastsongs=".$showlastsongs."\r\n";
					$xml .= "tchlog=".$s[0]['tchlog']."\r\n";
					$xml .= "weblog=".$s[0]['weblog']."\r\n";
					$xml .= "w3cenable=".$s[0]['w3cenable']."\r\n";
					$xml .= "w3clog=" . getcwd() . '/temp/'.$s[0]['portbase'].'/logs/w3c/sc_' . $s[0]['portbase'] . ".log\r\n";
					$xml .= "banfile=" . getcwd() . '/temp/'.$s[0]['portbase'].'/logs/banfile.ban' . "\r\n";
					$xml .= "ripfile=" . getcwd() . '/temp/'.$s[0]['portbase'].'/logs/ripfile.rip' . "\r\n";
					$xml .= "yp2=".$s[0]['yp2']."\r\n";
					$xml .= "uvox2sourcedebug=".$s[0]['uvox2sourcedebug']."\r\n";
					$xml .= "srcip=".$s[0]['srcip']."\r\n";
					$xml .= "destip=".$s[0]['destip']."\r\n";
					$xml .= "yport=".$s[0]['yport']."\r\n";
					$xml .= "namelookups=".$namelookups."\r\n";
					$xml .= "relayport=" . $relayport . "\r\n";
					$xml .= "autodumpusers=".$s[0]['autodumpusers']."\r\n";
					$xml .= "autodumpsourcetime=".$s[0]['autodumpsourcetime']."\r\n";
					$xml .= "titleformat=".$titleformat."\r\n";
					$xml .= "publicserver=".$s[0]['publicserver']."\r\n";
					$xml .= "allowrelay=".$allowrelay."\r\n";
					$xml .= "allowpublicrelay=".$allowpub."\r\n";
					$xml .= "metainterval=".$s[0]['metainterval']."\r\n";
					$xml .= "displaymetadatapattern=".$s[0]['displaymetadatapattern']."\r\n";
					$xml .= "uvoxradiometadata=".$s[0]['uvoxradiometadata']."\r\n";
					$xml .= "uvoxnewmetadata=".$s[0]['uvoxnewmetadata']."\r\n";
					$xml .= "unlockkeyname=".$s[0]['unlockkeyname']."\r\n";
					$xml .= "unlockkeycode=".$s[0]['unlockkeycode']."\r\n";
					$xml;
					chmod($filexml, 777);
					if(is_dir("/temp/" . $s[0]['portbase'] . "/conf/sc_serv.conf")){
						chmod("/temp/" . $s[0]['portbase'] . "/conf/sc_serv.conf",0777); 
					} 
					$gz = fopen($filexml,"a");
					fwrite($gz, $xml);
					fclose($gz);
					
					$message['success'] = 'Your Server ['.$s[0]['id'].'] Update! Waiting for loading!';
				}
				$getPage  = View::get('serveredit', [
													'sv' => $s,
													'message' => $message
												]);
				return View::render('layout/main', [
					'title'			=> 'Edit Server [' . $s[0]['id'] .']', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
			}else{
				return Header::location('/404');
			}
		}else{
			$start	= (string) 	 \App::post('start');
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
			
			$getPage  = View::get('server', [
												'servers'	=> $list,
												'pagina'	=> $pagina, //for pagination
												'inicio'	=> $inicio,
												'fim'		=> $fim,
												'message'	=> $message,
												'paginas'	=> $paginas
											]);
			
			return View::render('layout/main', [
				'title'			=> 'Server', 
				'page'			=> $this->page,
				'user'			=> $this->user,
				'html'			=> $getPage,
				'breadcrumb'	=> ['', ''],
			]);
		}
	}
}