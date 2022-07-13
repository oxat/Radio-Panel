<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class Autodj {
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
		$owns = $this->user->get()->user;
		$message			= ['success' => null, 'text' => null, 'error' => null];
		$getPage			= (int) \App::get('p');
		$Getid				= (int) \App::get('id');
		$GetUpdate			= (string) 	 \App::post('update');
		$public				= (string) 	 \App::post('public');
		$streamtitle		= (string) 	 \App::post('streamtitle');
		$streamurl			= (string)  \App::post('streamurl');
		$genre				= (string) 	 \App::post('genre');
		$shuffle			= (string) 	 \App::post('shuffle');
		$display			= (string) 	 \App::post('displaymetadatapattern');
		$samplerate			= (string) 	 \App::post('samplerate');
		$channels			= (string) 	 \App::post('channels');
		$encoder			= (string) 	 \App::post('encoder');
		$mp3quality			= (string) 	 \App::post('mp3quality');
		$mp3mode			= (string) 	 \App::post('mp3mode');
		$xfade				= (string) 	 \App::post('xfade');
		$xfadethreshol		= (string) 	 \App::post('xfadethreshol');
		$aim				= (string) 	 \App::post('aim');
		$icq				= (string) 	 \App::post('icq');
		$irc				= (string) 	 \App::post('irc');
		$calendarrewrite	= (string) 	 \App::post('calendarrewrite');
		$djcapture			= (string) 	 \App::post('djcapture');
		$playlists			= (string) 	 \App::post('playlists');
		
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
		if($Getid){
			$s = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `id`=" . intval($Getid));
			If(empty($s)){
				return Header::location('/404');
			}
			if($owns == $s[0]['owner']){
				if ($GetUpdate) {	
					$this->user->updateData('servers',
									[
										'public'					=> $public,
										'streamtitle'				=> $streamtitle,
										'streamurl'					=> $streamurl,
										'genre'						=> $genre,
										'shuffle'					=> $shuffle,
										'displaymetadatapattern'	=> $display,
										'samplerate'				=> $samplerate,
										'channels'					=> $channels,
										'encoder'					=> $encoder,
										'mp3quality'				=> $mp3quality,
										'mp3mode'					=> $mp3mode,
										'xfade'						=> $xfade,
										'xfadethreshol'				=> $xfadethreshol,
										'aim'						=> $aim,
										'icq'						=> $icq,
										'irc'						=> $irc,
										'calendarrewrite'			=> $calendarrewrite,
										'djcapture'					=> $djcapture
									],
									[
										'id' => $s[0]['id']
									]
							);
					if ($config[0]['os'] == 'linux') {
						$fileban = getcwd() . "/temp/" . $s[0]['portbase'] ."/logs/banfile.ban";
						$filerip = getcwd() . "/temp/" . $s[0]['portbase'] ."/logs/ripfile.rip";
						$filexml = getcwd() . "/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml";
						$fileconf = getcwd() . "/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf";
					}
					$djs = $this->sql->fetch_array("SELECT * FROM `dj` WHERE `server`=" . intval($s[0]['portbase']));
					$ban = '';
					chmod($fileban, 0777);
					if(is_dir( "/temp/" . $s[0]['portbase'] ."/logs/banfile.ban")){
						chmod( "/temp/" . $s[0]['portbase'] ."/logs/banfile.ban",0777); 
					}
					$gzp = fopen($fileban,"a");
					fwrite($gzp, $ban);
					fclose($gzp);
					
					$rip = '';
					chmod($filerip, 0777);
					if(is_dir( "/temp/" . $s[0]['portbase'] ."/logs/ripfile.rip")){
						chmod( "/temp/" . $s[0]['portbase'] ."/logs/ripfile.rip",0777);
					}
					$gzp = fopen($filerip,"a");
					fwrite($gzp, $rip);
					fclose($gzp);
					
					unlink($filexml);
					$xml = '';
					$xml .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";
					$xml .= "<eventlist>\r\n";
					foreach($djs as $key => $d){
						if($key == 0){
							$ids = '0';
						}else{
							$ids = '1';
						}
						$xml .= "<event type=\"dj\">\r\n";
						$xml .= "<dj archive=\"".$ids."\">".$d['login']."</dj>\r\n";
						$xml .= "<calendar />\r\n";
						$xml .= "</event>\r\n";
					}
					$xml .= "</eventlist>";
					
					chmod($filexml, 777);
					if(is_dir("/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml")){
						chmod("/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml",0777); 
					} 
					$gz = fopen($filexml,"a");
					fwrite($gz, $xml);
					fclose($gz);
					
					unlink($fileconf);
					$csf = '';
					if($playlists){
						$csf .= "playlistfile=". getcwd() ."/temp/". $s[0]['portbase'] ."/playlist/".$playlists."\r\n";
					}
					$csf .= "bitrate=" . $s[0]['bitrate'] . "\r\n";
					$csf .= "password=" . $s[0]['password'] . "\r\n";
					$csf .= "serverip=" . $s[0]['serverip'] . "\r\n";
					$csf .= "serverport=" . $s[0]['portbase'] . "\r\n";
					$csf .= "streamtitle=" . $streamtitle . "\r\n";
					$csf .= "streamurl=" . $streamurl . "\r\n";
					$csf .= "shuffle=" . $shuffle . "\r\n";
					$csf .= "samplerate=" . $samplerate . "\r\n";
					$csf .= "channels=" . $channels . "\r\n";
					$csf .= "genre=" . $genre . "\r\n";
					$csf .= "public=" . $public . "\r\n";
					$csf .= "aim=" . $aim . "\r\n";
					$csf .= "icq=" . $icq . "\r\n";
					$csf .= "irc=" . $irc . "\r\n";
					$csf .= "encoder=" . $encoder . "\r\n";
					$csf .= "mp3quality=" . $mp3quality . "\r\n";
					$csf .= "mp3mode=" . $mp3mode . "\r\n";
					$csf .= "calendarrewrite=" . $calendarrewrite . "\r\n";
					$csf .= "calendarfile=" . getcwd() . "/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml\r\n";
					$csf .= "outprotocol=" . $s[0]['outprotocol'] . "\r\n";
					$csf .= "log=" . $s[0]['log'] . "\r\n";
					$csf .= "displaymetadatapattern=" . $display . "\r\n";
					$csf .= "useMetadata=" . $s[0]['useMetadata'] . "\r\n";
					$csf .= "xfade=" . $xfade . "\r\n";
					$csf .= "xfadethreshol=" . $xfadethreshol . "\r\n";
					$csf .= "uvoxradiometadata=" . $s[0]['uvoxradiometadata'] . "\r\n";
					$csf .= "uvoxnewmetadata=" . $s[0]['uvoxnewmetadata'] . "\r\n";
					$csf .= "djcapture=" . $djcapture . "\r\n";
					$csf .= "djport_1=" . $s[0]['djport_1'] . "\r\n";
					$csf .= "djbroadcasts=" . $s[0]['djbroadcasts'] . "\r\n";
					foreach($djs as $key => $d){
						$ids = $key + 1;
						$csf .= "djlogin_".$ids."=".$d['login']."\r\n";
						$csf .= "djpassword_".$ids."=".$d['password']."\r\n";
						$csf .= "djpriority_".$ids."=".$d['djpriority']."\r\n";
					}
					$csf .= "unlockkeyname=" . $s[0]['unlockkeyname'] . "\r\n";
					$csf .= "unlockkeycode=" . $s[0]['unlockkeycode'] . "\r\n";
					
					chmod($fileconf, 777);
					if(is_dir("/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf")){
						chmod("/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf",0777); 
					} 
					$gs = fopen($fileconf,"a");
					fwrite($gs, $csf);
					fclose($gs);
					
					$message['success'] = 'Your Server ['.$s[0]['id'].'] Update! Waiting for loading!';
				}
				$gen		= ['Alternative', 'Fox', 'Schlager', 'Jazz', 'Dance', 'Disco', 'House', 'RnB', 'Rab', 'PoP', 'Dance PoP', 'World PoP', 'Rock', 'Techno', 'Querbeet', 'World', 'The 70s', 'The 80s', 'The 90s', 'Mixed', 'Mixe', 'Funradio-AutoDJ'];
				$bitrate	= [8000, 11025, 12000, 16000, 22025, 24000, 32000, 44100, 48000];
				$fade		= [2, 4, 6, 8];
				$xfadet		= [20, 40, 60];
				$getPage  = View::get('editautodj', [
													'sv'		=> $s,
													'config'	=> $config,
													'gen'		=> $gen,
													'bitrate'	=> $bitrate,
													'fade'		=> $fade,
													'xfadet'	=> $xfadet,
													'message'	=> $message
												]);
				return View::render('layout/main', [
					'title'			=> 'Edit Autodj [' . $s[0]['portbase'] .']', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
			}else{
				return Header::location('/404');
			}
		}else{
			$start		= (string) 	 \App::post('start');
			$stop		= (string) 	 \App::post('stop');
			$restart	= (string) 	 \App::post('restart');
			if($restart){
				$this->user->autodj('restart' , $restart);
				$message['success'] = 'AutoDJ for ['.$restart.'] Restarted!';
			}
			if($start){
				$sts = $this->user->autodj('start' , $start);
				if($sts){
					$message['success'] = 'AutoDJ for ['.$start.'] Started!';
				}else{
					$message['error'] = 'AutoDJ for ['.$start.'] is online!';
				}
			}
			if($stop){
				$sts = $this->user->autodj('stop' , $stop);
				if($sts){
					$message['error'] = 'AutoDJ for ['.$stop.'] is offline!';
				}else{
					$message['success'] = 'AutoDJ for ['.$stop.'] Stoped!';
				}
			}
			$list = [];
			foreach ($servers as $u) {
				$list[] = [
						'id'		=> $u['id'],
						'own'		=> $u['owner'],
						'port'		=> $u['portbase'],
						'status'	=> $this->user->autodj('status' , $u['portbase']),
						'streamurl'	=> $u['streamurl']
					];
			}
			
			$getPage  = View::get('autodj', [
												'servers'	=> $list,
												'pagina'	=> $pagina, //for pagination
												'inicio'	=> $inicio,
												'fim'		=> $fim,
												'message'	=> $message,
												'paginas'	=> $paginas
											]);
			
			return View::render('layout/main', [
				'title'			=> 'Auto DJ', 
				'page'			=> $this->page,
				'user'			=> $this->user,
				'html'			=> $getPage,
				'breadcrumb'	=> ['', ''],
			]);
		}
	}
}
