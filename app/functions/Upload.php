<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class upload {
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
		$GetUpdate	= (string) \App::post('mp3');
		$doc		= (string) \App::post('doc');
		$delete		= (string) \App::post('delete');
		$message	= ['success' => null, 'text' => null];

		if($Getport){
			$s = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($Getport));
			If(empty($s)){
				return Header::location('/404');
			}
			if($owns == $s[0]['owner']){
				if($delete){
					$decode = base64_decode($delete);
					if (file_exists("./uploads/".$s[0]['portbase']."/".$decode."")) {
						unlink("./uploads/".$s[0]['portbase']."/".$decode."");
						$message['success'] = 'File is delete!';
					}else {
						$message['success'] = 'File not fond!';
					}
				}
				if ($GetUpdate) {	// php settings post_max_size 1000M and upload_max_filesize 1000M
					if (isset($_FILES['doc'])){
						$i = 0;
						$out = '';
						foreach ($_FILES['doc']['tmp_name'] as $key => $tmp_name){
							$fileType = $_FILES['doc']['type'][$key];
							if ($fileType != "audio/mpeg" && $fileType != "audio/mpeg3" && $fileType != "audio/mp3"
								&& $fileType != "audio/x-mpeg" && $fileType != "audio/x-mp3" && $fileType != 'audio/x-mpeg3' 
								&& $fileType != 'audio/x-mpg' && $fileType != "audio/x-mpegaudio" && $fileType != "audio/mpg" 
								&& $fileType != "audio/x-mpg"){
									$name = substr($_FILES['doc']['name'][$key], 0, 30);
									if(strlen($_FILES['doc']['name'][$key]) > 30 ) $name = $name."...";
									$asd .=  'Error: ' .$name. '\n';
								}else{
									$name = substr($_FILES['doc']['name'][$key], 0, 50);
									if(strlen($_FILES['doc']['name'][$key]) > 50 ) $name = $name."...";
									if(file_exists('./uploads/'.$s[0]['portbase'].'/'.$_FILES['doc']['name'][$key])){
										$asd .=  'Exist: ' .$name. '\n';
									}else{
										$asd .= 'Uploaded: '. $name. '\n';
										move_uploaded_file($tmp_name, './uploads/'.$s[0]['portbase'].'/'.$_FILES['doc']['name'][$key]);
									}
								}
							$i++;
						}
						$message['success'] = $asd;
						
					}
				}
				$getPage  = View::get('upload', [
													'sv'		=> $s,
													'space'		=> $this->user->get_dir_size('./uploads/'. $s[0]['portbase'] .'/'),
													'message'	=> $message
												]);
				return View::render('layout/main', [
					'title'			=> 'Upload File MP3', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
			}else{
				return Header::location('/404');
			}
		}else{
			return Header::location('/404');
		}
	}
}