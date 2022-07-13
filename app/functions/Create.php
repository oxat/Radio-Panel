<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class Create {
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
			$owner				= (string)	\App::post('owner');
			$passadm			= (string) \App::post('adminpassword');
			$pass				= (string) \App::post('password');
			$djport				= (int) \App::post('djport_1');
			$port				= (int) \App::post('portbase');
			$w3clog				= (string) \App::post('w3clog');
			$logfile			= (string) \App::post('logfile');
			$maxuser			= (int) \App::post('maxuser');
			$bitrate			= (int) \App::post('bitrate');
			$sitepublic			= (int) \App::post('sitepublic');
			$autopid			= (string) \App::post('autopid');
			$webspace			= (int) \App::post('webspace');
			$realtime			= (int) \App::post('realtime');
			$screenlog			= (int) \App::post('screenlog');
			$lastsongs			= (int) \App::post('showlastsongs');
			$tchlog				= (string) \App::post('tchlog');
			$weblog				= (string) \App::post('weblog');
			$w3cenable			= (string) \App::post('w3cenable');
			$srcip				= (string) \App::post('srcip');
			$destip				= (string) \App::post('destip');
			$yport				= (int) \App::post('yport');
			$namelookups		= (int) \App::post('namelookups');
			$relayport			= (int) \App::post('relayport');
			$relayserver		= (string) \App::post('relayserver');
			$autodump			= (int) \App::post('autodumpusers');
			$autodumps			= (int) \App::post('autodumpsourcetime');
			$contentdir			= (string) \App::post('contentdir');
			$introfile			= (string) \App::post('introfile');
			$titleformat		= (string) \App::post('titleformat');
			$urlformat			= (string) \App::post('urlformat');
			$publicserver		= (string) \App::post('publicserver');
			$allowrelay			= (int) \App::post('allowrelay');
			$allowpublic		= (int) \App::post('allowpublicrelay');
			$metainterval		= (int) \App::post('metainterval');
			$create				= (string) \App::post('create');
			$message			= ['success' => null, 'text' => null, 'error' => null];
			$owns = $this->user->get()->user;
			$users   = $this->sql->fetch_array("select * from `admins`");
			$config = $this->sql->fetch_array("SELECT * FROM `config` WHERE `id`= 1");
			$portsv   = $this->sql->fetch_array("SELECT portbase FROM servers order by portbase DESC LIMIT 1"); // Port Server
			$djportsql   = $this->sql->fetch_array("SELECT djport_1 FROM servers order by djport_1 DESC LIMIT 1"); // Port DJ
			if($portsv){
				$newport = $portsv[0]['portbase'] + 2;
			}else{
				$newport = '8000';
			}
			if($djportsql){
				$newportdj = $djportsql[0]['djport_1'] + 2;
			}else{
				$newportdj = '21000';
			}

			if ($create) {
				$this->user->InsertData('servers', 
					[
						'owner'					=> $owner,
						'maxuser'				=> $maxuser,
						'portbase'				=> $port,
						'bitrate'				=> $bitrate,
						'password'				=> $pass,
						'adminpassword'			=> $passadm,
						'sitepublic'			=> $sitepublic,
						'djport_1'				=> $djport,
						'logfile'				=> getcwd() . '/temp/'.$port.'/logs/' . $logfile,
						'realtime'				=> $realtime,
						'screenlog'				=> $screenlog,
						'showlastsongs'			=> $lastsongs,
						'tchlog'				=> $tchlog,
						'weblog'				=> $weblog,
						'w3cenable'				=> $w3cenable,
						'w3clog'				=> getcwd() . '/temp/'.$port.'/logs/w3c/' . $w3clog,
						'banfile'				=> getcwd() . '/temp/'.$port.'/logs/banfile.ban',
						'ripfile'				=> getcwd() . '/temp/'.$port.'/logs/ripfile.rip',
						'srcip'					=> $srcip,
						'destip'				=> $destip,
						'yport'					=> $yport,
						'namelookups'			=> $namelookups,
						'relayport'				=> $relayport,
						'relayserver'			=> $relayserver,
						'autodumpusers'			=> $autodump,
						'autodumpsourcetime'	=> $autodumps,
						'contentdir'			=> $contentdir,
						'introfile'				=> $introfile,
						'titleformat'			=> $titleformat,
						'urlformat'				=> $urlformat,
						'publicserver'			=> $publicserver,
						'allowrelay'			=> $allowrelay,
						'allowpublicrelay'		=> $allowpublic,
						'metainterval'			=> $metainterval,
						'autopid'				=> $autopid,
						'webspace'				=> ($webspace * 1024),
						'serverip'				=> '127.0.0.1',
						'serverport'			=> $port,
						'streamtitle'			=> 'The Best Radio',
						'streamurl'				=> 'https://' . $config[0]['host_add'],
						'shuffle'				=> 1,
						'samplerate'			=> 44100,
						'channels'				=> 1,
						'genre'					=> 'PoP',
						'djbroadcasts'			=> getcwd() . '/temp/'.$port.'/recorded',
						'calendarfile'			=> getcwd() . '/temp/'.$port.'/calendar/calendar.xml'
					]);

				$old = umask(0);
				@mkdir("./uploads/" . $port . "", 0777);
				@mkdir("./temp/" . $port . "", 0777);
				@mkdir("./temp/" . $port . "/conf", 0777);
				@mkdir("./temp/" . $port . "/recorded", 0777);
				@mkdir("./temp/" . $port . "/logs", 0777);
				@mkdir("./temp/" . $port . "/logs/w3c", 0777);
				@mkdir("./temp/" . $port . "/calendar", 0777);

				sleep(1);
				@mkdir("./temp/" . $port . "/playlist", 0777);
				umask($old);

				if ($config[0]['os'] == 'linux') {
					$filexml = getcwd() . "/temp/" . $port . "/conf/sc_serv.conf";
					$playlist = getcwd() . "/temp/" . $port . "/playlist/demoplaylist.lst";
				}

				$xml .= "maxuser=".$maxuser."\r\n";
				$xml .= "portbase=" . $port . "\r\n";
				$xml .= "bitrate=".$bitrate."\r\n";
				$xml .= "password=".$pass."\r\n";
				$xml .= "adminpassword=".$passadm."\r\n";
				$xml .= "logfile=" . getcwd() . '/temp/'.$port.'/logs/' . $logfile . "\r\n";
				$xml .= "realtime=".$realtime."\r\n";
				$xml .= "screenlog=" . $screenlog . "\r\n";
				$xml .= "showlastsongs=".$lastsongs."\r\n";
				$xml .= "tchlog=".$tchlog."\r\n";
				$xml .= "weblog=".$weblog."\r\n";
				$xml .= "w3cenable=".$w3cenable."\r\n";
				$xml .= "w3clog=" . getcwd() . '/temp/'.$port.'/logs/w3c/' . $w3clog . "\r\n";
				$xml .= "banfile=" . getcwd() . '/temp/'.$port.'/logs/banfile.ban' . "\r\n";
				$xml .= "ripfile=" . getcwd() . '/temp/'.$port.'/logs/ripfile.rip' . "\r\n";
				$xml .= "yp2=1\r\n";
				$xml .= "uvox2sourcedebug=1\r\n";
				$xml .= "srcip=".$srcip."\r\n";
				$xml .= "destip=".$destip."\r\n";
				$xml .= "yport=".$yport."\r\n";
				$xml .= "namelookups=".$namelookups."\r\n";
				$xml .= "relayport=" . $relayport . "\r\n";
				$xml .= "autodumpusers=".$autodump."\r\n";
				$xml .= "autodumpsourcetime=".$autodumps."\r\n";
				$xml .= "titleformat=".$titleformat."\r\n";
				$xml .= "publicserver=".$publicserver."\r\n";
				$xml .= "allowrelay=".$allowrelay."\r\n";
				$xml .= "allowpublicrelay=".$allowpublic."\r\n";
				$xml .= "metainterval=".$metainterval."\r\n";
				$xml .= "displaymetadatapattern=%R [-] %N\r\n";
				$xml .= "uvoxradiometadata=0\r\n";
				$xml .= "uvoxnewmetadata=1\r\n";
				$xml .= "unlockkeyname=Ronny Shippo21\r\n";
				$xml .= "unlockkeycode=482QP-480TU-J4MFD-VF4YK\r\n";
				$xml;
				chmod($filexml, 777);
				if(is_dir("/temp/" . $port . "/conf/sc_serv.conf")){
					chmod("/temp/" . $port . "/conf/sc_serv.conf",0777); 
				} 
				$gz = fopen($filexml,"a");
				fwrite($gz, $xml);
				fclose($gz);
				
				$pls .= $config[0]['dir_to_cpanel']."demo/Kalimba.mp3\r\n";
				$pls .= $config[0]['dir_to_cpanel']."demo/Sleep_Away.mp3\r\n";
				$pls;

				chmod($playlist, 777);
				if(is_dir("/temp/" . $port . "/playlist/demoplaylist.lst")){
					chmod("/temp/" . $port . "/playlist/demoplaylist.lst",0777); 
				} 
				$gzx = fopen($playlist,"a");
				fwrite($gzx, $pls);
				fclose($gzx);
				
				$message['success'] = 'Server is created ..';
			}

			$getPage  = View::get('create', [
												'users'		=> $users,
												'nextport'	=> $newport,
												'newportdj'	=> $newportdj,
												'message'	=> $message
											]);
			return View::render('layout/main', [
				'title'			=> 'Create Server', 
				'page'			=> $this->page,
				'user'			=> $this->user,
				'html'			=> $getPage,
				'breadcrumb'	=> ['', ''],
			]);
		}
	}
}