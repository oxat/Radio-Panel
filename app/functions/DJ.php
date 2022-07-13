<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class DJ {
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
		$Getport	= (int) \App::get('port');
		$Create		= (int) \App::get('create');
		$owns		= $this->user->get()->user;
		$delete		= (string) \App::post('delete');
		$user		= (string) 	 \App::post('user');
		$pass		= (string) 	 \App::post('pass');
		$priority	= (int) 	 \App::post('priority');
		$news		= (string) 	 \App::post('news');
		$message	= ['success' => null, 'text' => null, 'error' => null];
		$config		= $this->sql->fetch_array("SELECT * FROM `config` WHERE `id`= 1");

		if($Getport){
			$s = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($Getport));
			If(empty($s)){
				return Header::location('/404');
			}
			if($owns == $s[0]['owner']){
				if($delete){
					$decode = base64_decode($delete);
					$this->user->deldj($decode);
					$djs = $this->sql->fetch_array("SELECT * FROM `dj` WHERE `server`=" . intval($s[0]['portbase']));
					if ($config[0]['os'] == 'linux') {
						$filex = getcwd() . "/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml";
						$fileconf = getcwd() . "/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf";
					}
					unlink($filex);
					$sml .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";
					$sml .= "<eventlist>\r\n";
					foreach($djs as $key => $d){
						if($key == 0){
							$ids = '0';
						}else{
							$ids = '1';
						}
						$sml .= "<event type=\"dj\">\r\n";
						$sml .= "<dj archive=\"".$ids."\">".$d['login']."</dj>\r\n";
						$sml .= "<calendar />\r\n";
						$sml .= "</event>\r\n";
					}
					$sml .= "</eventlist>";
					$sml;
					chmod($filex, 777);
					if(is_dir("/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml")){
						chmod("/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml",0777); 
					} 
					$gz = fopen($filex,"a");
					fwrite($gz, $sml);
					fclose($gz);
					
					$filename = "./temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf";
					$handle = fopen($filename, "r");
					$contents = fread($handle, filesize($filename));
					fclose($handle);
					$parsed = $this->user->get_string_between($contents, 'playlistfile=', '.lst');
					unlink($fileconf);
					if($parsed){
						$csf .= "playlistfile=". $parsed .".lst\r\n";
					}
					$csf .= "bitrate=" . $s[0]['bitrate'] . "\r\n";
					$csf .= "password=" . $s[0]['password'] . "\r\n";
					$csf .= "serverip=" . $s[0]['serverip'] . "\r\n";
					$csf .= "serverport=" . $s[0]['serverport'] . "\r\n";
					$csf .= "streamtitle=" . $s[0]['streamtitle'] . "\r\n";
					$csf .= "streamurl=" . $s[0]['streamurl'] . "\r\n";
					$csf .= "shuffle=" . $s[0]['shuffle'] . "\r\n";
					$csf .= "samplerate=" . $s[0]['samplerate'] . "\r\n";
					$csf .= "channels=" . $s[0]['channels'] . "\r\n";
					$csf .= "genre=" . $s[0]['genre'] . "\r\n";
					$csf .= "public=" . $s[0]['public'] . "\r\n";
					$csf .= "aim=" . $s[0]['aim'] . "\r\n";
					$csf .= "icq=" . $s[0]['icq'] . "\r\n";
					$csf .= "irc=" . $s[0]['irc'] . "\r\n";
					$csf .= "encoder=" . $s[0]['encoder'] . "\r\n";
					$csf .= "mp3quality=" . $s[0]['mp3quality'] . "\r\n";
					$csf .= "mp3mode=" . $s[0]['mp3mode'] . "\r\n";
					$csf .= "calendarrewrite=" . $s[0]['calendarrewrite'] . "\r\n";
					$csf .= "calendarfile=" . getcwd() . "/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml\r\n";
					$csf .= "outprotocol=" . $s[0]['outprotocol'] . "\r\n";
					$csf .= "log=" . $s[0]['log'] . "\r\n";
					$csf .= "displaymetadatapattern=" . $s[0]['displaymetadatapattern'] . "\r\n";
					$csf .= "useMetadata=" . $s[0]['useMetadata'] . "\r\n";
					$csf .= "xfade=" . $s[0]['xfade'] . "\r\n";
					$csf .= "xfadethreshol=" . $s[0]['xfadethreshol'] . "\r\n";
					$csf .= "uvoxradiometadata=" . $s[0]['uvoxradiometadata'] . "\r\n";
					$csf .= "uvoxnewmetadata=" . $s[0]['uvoxnewmetadata'] . "\r\n";
					$csf .= "djcapture=" . $s[0]['djcapture'] . "\r\n";
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
					$csf;
					chmod($fileconf, 777);
					if(is_dir("/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf")){
						chmod("/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf",0777); 
					} 
					$gs = fopen($fileconf,"a");
					fwrite($gs, $csf);
					fclose($gs);
					$message['success'] = 'Dj is Delete!';
				}
				$dj = $this->sql->fetch_array("SELECT * FROM `dj` WHERE `server`=" . intval($s[0]['portbase']));
				$getPage  = View::get('dj', [
												'dj'		=> $dj,
												'info'		=> $s,
												'config'	=> $config,
												'port'		=> $s[0]['portbase'],
												'message'	=> $message
											]);
				return View::render('layout/main', [
					'title'			=> 'DJ to ['.$s[0]['portbase'].']', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
			}
		}elseif($Create){
			$s = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($Create));
			If(empty($s)){
				return Header::location('/404');
			}
			if($news){
				$this->user->InsertData('dj', 
					[
						'login'			=> $user,
						'password'		=> $pass,
						'djpriority'	=> $priority,
						'server'		=> $s[0]['portbase']
					]);
					$dj = $this->sql->fetch_array("SELECT * FROM `dj` WHERE `server`=" . intval($s[0]['portbase']));
					if ($config[0]['os'] == 'linux') {
						$filexml = getcwd() . "/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml";
						$fileconf = getcwd() . "/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf";
					}
					$xml = '';
					unlink($filexml);
					$xml .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";
					$xml .= "<eventlist>\r\n";
					foreach($dj as $key => $d){
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
					$xml;
					chmod($filexml, 777);
					if(is_dir("/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml")){
						chmod("/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml",0777); 
					} 
					$gz = fopen($filexml,"a");
					fwrite($gz, $xml);
					fclose($gz);
					
					$filename = "./temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf";
					$handle = fopen($filename, "r");
					$contents = fread($handle, filesize($filename));
					fclose($handle);
					$parsed = $this->user->get_string_between($contents, 'playlistfile=', '.lst');
					unlink($fileconf);
					if($parsed){
						$csf .= "playlistfile=". $parsed .".lst\r\n";
					}
					$csf .= "bitrate=" . $s[0]['bitrate'] . "\r\n";
					$csf .= "password=" . $s[0]['password'] . "\r\n";
					$csf .= "serverip=" . $s[0]['serverip'] . "\r\n";
					$csf .= "serverport=" . $s[0]['serverport'] . "\r\n";
					$csf .= "streamtitle=" . $s[0]['streamtitle'] . "\r\n";
					$csf .= "streamurl=" . $s[0]['streamurl'] . "\r\n";
					$csf .= "shuffle=" . $s[0]['shuffle'] . "\r\n";
					$csf .= "samplerate=" . $s[0]['samplerate'] . "\r\n";
					$csf .= "channels=" . $s[0]['channels'] . "\r\n";
					$csf .= "genre=" . $s[0]['genre'] . "\r\n";
					$csf .= "public=" . $s[0]['public'] . "\r\n";
					$csf .= "aim=" . $s[0]['aim'] . "\r\n";
					$csf .= "icq=" . $s[0]['icq'] . "\r\n";
					$csf .= "irc=" . $s[0]['irc'] . "\r\n";
					$csf .= "encoder=" . $s[0]['encoder'] . "\r\n";
					$csf .= "mp3quality=" . $s[0]['mp3quality'] . "\r\n";
					$csf .= "mp3mode=" . $s[0]['mp3mode'] . "\r\n";
					$csf .= "calendarrewrite=" . $s[0]['calendarrewrite'] . "\r\n";
					$csf .= "calendarfile=" . getcwd() . "/temp/" . $s[0]['portbase'] . "/calendar/calendar.xml\r\n";
					$csf .= "outprotocol=" . $s[0]['outprotocol'] . "\r\n";
					$csf .= "log=" . $s[0]['log'] . "\r\n";
					$csf .= "displaymetadatapattern=" . $s[0]['displaymetadatapattern'] . "\r\n";
					$csf .= "useMetadata=" . $s[0]['useMetadata'] . "\r\n";
					$csf .= "xfade=" . $s[0]['xfade'] . "\r\n";
					$csf .= "xfadethreshol=" . $s[0]['xfadethreshol'] . "\r\n";
					$csf .= "uvoxradiometadata=" . $s[0]['uvoxradiometadata'] . "\r\n";
					$csf .= "uvoxnewmetadata=" . $s[0]['uvoxnewmetadata'] . "\r\n";
					$csf .= "djcapture=" . $s[0]['djcapture'] . "\r\n";
					$csf .= "djport_1=" . $s[0]['djport_1'] . "\r\n";
					$csf .= "djbroadcasts=" . $s[0]['djbroadcasts'] . "\r\n";
					foreach($dj as $key => $d){
						$ids = $key + 1;
						$csf .= "djlogin_".$ids."=".$d['login']."\r\n";
						$csf .= "djpassword_".$ids."=".$d['password']."\r\n";
						$csf .= "djpriority_".$ids."=".$d['djpriority']."\r\n";
					}
					$csf .= "unlockkeyname=" . $s[0]['unlockkeyname'] . "\r\n";
					$csf .= "unlockkeycode=" . $s[0]['unlockkeycode'] . "\r\n";
					$csf;
					chmod($fileconf, 777);
					if(is_dir("/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf")){
						chmod("/temp/" . $s[0]['portbase'] . "/conf/sc_trans.conf",0777); 
					} 
					$gs = fopen($fileconf,"a");
					fwrite($gs, $csf);
					fclose($gs);
					$this->user->autodj('restart' , $s[0]['portbase']);
					$message['success'] = 'New DJ create to server ['.$s[0]['portbase'].']!';
			}
			$getPage  = View::get('djc', [
												'message'	=> $message,
												'port'	=> $s[0]['portbase']
											]);
				return View::render('layout/main', [
					'title'			=> 'Create DJ to ['.$s[0]['portbase'].']', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
		}else{
			return Header::location('/home');
		}
	}
}