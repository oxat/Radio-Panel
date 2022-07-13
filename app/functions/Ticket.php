<?php
namespace Functions;

use Vendor\View;
use Classes\Page;
use Classes\Admin;
use Vendor\Header;
use Vendor\Database;
use Vendor\Validator;

class ticket {
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
		$id			= (int) \App::get('id');
		$Create		= (string) \App::get('create');
		$owns		= $this->user->get()->user;
		$sub		= (string) 	 \App::post('sub');
		$topic		= (string) 	 \App::post('topic');
		$msg		= (string) 	 \App::post('msg');
		$send		= (string) 	 \App::post('send');
		$close		= (string) 	 \App::post('close');
		$message	= ['success' => null, 'text' => null, 'error' => null];
		
		if($Create){
			$asd = [
				'user' => $owns,
				'msg' => $msg,
				'data' => time()
			];
			if($send){
				$json_array = array ($asd);
				$this->user->InsertData('ticket', 
					[
						'user'			=> $owns,
						'subiect'		=> $sub,
						'departament'	=> $topic,
						'mesaje'		=> json_encode($json_array),
						'data'			=> time(),
						'status'		=> 1
					]);
					$message['success'] = 'Ticket Send!';
			}
			$getPage  = View::get('createticket', [
												'message'	=> $message,
												'own'		=> $owns
											]);
				return View::render('layout/main', [
					'title'			=> 'Create Ticket', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
		}elseif($id){
			$id = $this->sql->fetch_array("SELECT * FROM `ticket` WHERE `id`='{$id}'");
			If(empty($id)){
				return Header::location('/404');
			}
			if($owns == $id[0]['user']){
				if($send){
					$json_arr = json_decode($id[0]['mesaje'], true);
					$asd = [
						'user' => $owns,
						'msg' => $msg,
						'data' => time()
					];
					$json_arr[] = $asd;
					
					$this->user->updateData('ticket',
									[
										'status'	=> 1,
										'mesaje'	=> json_encode($json_arr)
									],
									[
										'id' => $id[0]['id']
									]
							);
					$message['success'] = 'Send!';
				}
				$getPage  = View::get('ticketed', [
												'message'	=> $message,
												'own'		=> $owns,
												't'			=> $id,
												'msg'		=> json_decode($id[0]['mesaje'], true)
											]);
				return View::render('layout/main', [
					'title'			=> 'Ticket [' . $id[0]['id'] . ']', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
			}elseif($this->user->get()->rank == 1){
				if($send){
					$json_arr = json_decode($id[0]['mesaje'], true);
					$asd = [
						'user' => $owns,
						'msg' => $msg,
						'data' => time()
					];
					$json_arr[] = $asd;
					
					$this->user->updateData('ticket',
									[
										'status'	=> 1,
										'mesaje'	=> json_encode($json_arr)
									],
									[
										'id' => $id[0]['id']
									]
							);
					$message['success'] = 'Send!';
				}
				if($close){
					$this->user->updateData('ticket',
									[
										'status'	=> 0
									],
									[
										'id' => $id[0]['id']
									]
							);
					$message['success'] = 'Ticket is close!';
				}
				$getPage  = View::get('ticketed', [
												'message'	=> $message,
												'own'		=> $owns,
												't'			=> $id,
												'rank'		=> $this->user->get()->rank,
												'msg'		=> json_decode($id[0]['mesaje'], true)
											]);
				return View::render('layout/main', [
					'title'			=> 'Ticket [' . $id[0]['id'] . ']', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
			}else{
				return Header::location('/404');
			}
		}else{
			if($this->user->get()->rank == 1){
				$t = $this->sql->fetch_array("SELECT * FROM `ticket`");
				$getPage  = View::get('ticket', [
													'message'	=> $message,
													'own'	=> $owns,
													'ticket'	=> $t
												]);
			}else{
				$t = $this->sql->fetch_array("SELECT * FROM `ticket` WHERE `user`='{$owns}'");
				$getPage  = View::get('ticket', [
													'message'	=> $message,
													'own'	=> $owns,
													'ticket'	=> $t
												]);
			}
				return View::render('layout/main', [
					'title'			=> 'Ticket', 
					'page'			=> $this->page,
					'user'			=> $this->user,
					'html'			=> $getPage,
					'breadcrumb'	=> ['', ''],
				]);
		}
	}
}