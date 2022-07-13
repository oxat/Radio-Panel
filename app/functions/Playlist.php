<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class playlist {
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
		$Getport	= (int) \App::get('port');
		$Port		= (int) \App::get('p');
		$Create		= (int) \App::get('create');
		$play		= (string) \App::get('list');
		$delete		= (string) \App::post('delete');
		$message	= ['success' => null, 'error' => null, 'text' => null];
		$config		= $this->sql->fetch_array("SELECT * FROM `config` WHERE `id`= 1");
		if($Getport){
			$s = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($Getport));
			If(empty($s)){
				return Header::location('/404');
			}
			if($owns == $s[0]['owner']){
				if($delete){
					$decode = base64_decode($delete);
					if (file_exists("./temp/".$s[0]['portbase']."/playlist/".$decode."")) {
						unlink("./temp/".$s[0]['portbase']."/playlist/".$decode."");
						$message['success'] = 'File is delete!';
					}else {
						$message['success'] = 'File not fond!';
					}
				}
				$getPage  = View::get('playlist', [
													'sv'		=> $s,
													'config'	=> $config,
													'message'	=> $message
												]);
				return View::render('layout/main', [
					'title'			=> 'Playlist [' . $s[0]['portbase'] .']', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
			}else{
				return Header::location('/404');
			}
		}elseif($Create){
			$p = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($Create));
			If(empty($p)){
				return Header::location('/404');
			}
			$playlist	= (string) \App::post('playlist');
			$song		= (array) $_POST['check'];
			$new		= (string) \App::post('update');
			
			if ($new) {
				if (!file_exists("./temp/".$p[0]['portbase']."/playlist/".$playlist.".lst")) {
					$filecreate = fopen("./temp/".$p[0]['portbase']."/playlist/".$playlist.".lst", 'w') or $message['success'] = 'Error!';
					fclose($filecreate);
					if (file_exists("./temp/".$p[0]['portbase']."/playlist/")) {
						$name = "./temp/".$p[0]['portbase']."/playlist/".$playlist.".lst";
						$filehandle = fopen($name, "w+");
						foreach ($song as $item) {
							fwrite($filehandle, $config[0]['dir_to_cpanel']."uploads/".$p[0]['portbase']."/".$item."\n");
						}
						fclose($filehandle);
						chmod($name,0777);
						$message['success'] = 'New playlist ['.$playlist.'] is created!';
					}
				}else{
					$message['error'] = 'Playlist ['.$playlist.'] exist!';
				}
			}
			$getPage  = View::get('newplaylist', [
													'sv'		=> $p,
													'config'	=> $config,
													'message'	=> $message
												]);
				return View::render('layout/main', [
					'title'			=> 'Create New Playlist', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
		}elseif($Port && $play){
			$pr = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($Port));
			If(empty($pr)){
				return Header::location('/404');
			}
			$song		= (array) $_POST['up'];
			$edit		= (string) \App::post('edit');
			$element	= (array) $_POST['st'];
			$del		= (string) \App::post('delete');
			$playlist	= base64_decode($play);
			
			$contents = file("./temp/".$pr[0]['portbase']."/playlist/" . $playlist, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$mp3 = str_replace(
										array($config[0]['dir_to_cpanel'] . 'uploads/' . $pr[0]['portbase'] . '/', $config[0]['dir_to_cpanel'] . 'demo/'),
										array('',''),
										$contents
									);
			if ($edit) {
					$filecreate = fopen("./temp/".$pr[0]['portbase']."/playlist/".$playlist, 'w') or $message['success'] = 'Error!';
					fclose($filecreate);
					if (file_exists("./temp/".$pr[0]['portbase']."/playlist/")) {
						$name = "./temp/".$pr[0]['portbase']."/playlist/".$playlist;
						$filehandle = fopen($name, "w+");
						foreach ($mp3 as $it) {
							fwrite($filehandle, $config[0]['dir_to_cpanel']."uploads/".$pr[0]['portbase']."/".$it."\n");
						}
						foreach ($song as $item) {
							fwrite($filehandle, $config[0]['dir_to_cpanel']."uploads/".$pr[0]['portbase']."/".$item."\n");
						}
						fclose($filehandle);
						chmod($name,0777);
						$message['success'] = 'New playlist ['.$playlist.'] is created!';
					}
			}
			
			if ($del) {
				$decode =  base64_decode($del);
				if($decode == 'Kalimba.mp3'){
					$key = $config[0]['dir_to_cpanel']."demo/" . $decode;
				}elseif($decode == 'Sleep_Away.mp3'){
					$key = $config[0]['dir_to_cpanel']."demo/" . $decode;
				}else{
					$key = $config[0]['dir_to_cpanel']."uploads/".$pr[0]['portbase']."/" . $decode;
				}
				$filename = "./temp/".$pr[0]['portbase']."/playlist/".$playlist;
				$lines = file($filename); // reads a file into a array with the lines
				$output = '';
				foreach ($lines as $line) {
					if (!strstr($line, $key)) {
						$output .= $line;
					} 
				}
				file_put_contents($filename, $output);
				$message['success'] = 'Song '.$decode.' is delete!';
			}
			
			$getPage  = View::get('editplaylist', [
													'sv'		=> $pr,
													'config'	=> $config,
													'contents'	=> $mp3,
													'playlist'	=> $play,
													'message'	=> $message
												]);
				return View::render('layout/main', [
					'title'			=> 'Edit playlist [ '.$playlist.' ]', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
		}else{
			return Header::location('/404');
		}
	}
}