<?php
namespace Classes;

use Vendor\Security;
use Vendor\Database;

class Admin {

	protected $sql;
	protected $site = 1;

	public function __construct() {
		$this->sql = new Database;
	}

	public function isAuth(): bool {
		if (!array_key_exists('user', $_COOKIE) || !array_key_exists('pass', $_COOKIE)) {
			return false;
		}
		$user = strip_tags($_COOKIE['user']);
		$pass = strip_tags($_COOKIE['pass']);
		$getUser = $this->sql->fetch_array('SELECT * FROM admins WHERE user = \'' . $user . '\' AND usrtoken = \'' . $pass . '\' LIMIT 1;');
		return !empty($getUser[0]);
	}

	public function get() {
		if (!array_key_exists('user', $_COOKIE) || !array_key_exists('pass', $_COOKIE)) {
			return false;
		}
		$user = strip_tags($_COOKIE['user']);
		$pass = strip_tags($_COOKIE['pass']);
		$getUser = $this->sql->fetch_array('SELECT * FROM admins WHERE user = \'' . $user . '\' AND usrtoken = \'' . $pass . '\' LIMIT 1;');
		return (object) $getUser[0];
	}

	public function doLogout(): bool {
		foreach ($_COOKIE as $k => $v) {
			setcookie($k, null, -1, "/");
		}
		return true;
	}

	public function autodj($acao, $port)
	{
		switch($acao)
		{
			case "status":
				$apid = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($port));
				exec("ps -p {$apid[0]['autopid']}",$output);
				$sts = isset($output[1]) ? TRUE : FALSE;
				return $sts;
				
			case "start":
				If($this->autodj("status" , $port) == True) return False;
				$command = "nohup " .getcwd() . "/files/linux/sc_trans.bin " . getcwd() . "/temp/".$port."/conf/sc_trans.conf";
				exec( $command." >/dev/null 2>&1 & echo $!", $output) ;
				$this->updateData('servers',['autopid'	=> (int)$output[0]],['portbase'	=> $port]);
				sleep(2);
				return $this->autodj("status" , $port);
				
			case "stop":
				If(!$this->autodj("status", $port)) return True;
				$pid = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($port));
				exec("kill -9 {$pid[0]['autopid']}");
				$this->updateData('servers',['autopid'	=> ''],['portbase'	=> $port]);
				return $this->autodj("status", $port);
				
			case "restart":
				$this->autodj("stop", $port);
				sleep(1);
				return $this->autodj("start" , $port);
				
			default: 
				return False;
		}
	}

	public function server($acao, $port)
	{
		switch($acao)
		{
			case "status":
				$apid = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($port));
				exec("ps -p {$apid[0]['pid']}",$output);
				$sts = isset($output[1]) ? TRUE : FALSE;
				return $sts;
				
			case "start":
				If($this->server("status" , $port) == True) return False;
				$command = "nohup " .getcwd() . "/files/linux/sc_serv.bin " . getcwd() . "/temp/".$port."/conf/sc_serv.conf";
				exec( $command." >/dev/null 2>&1 & echo $!", $output) ;
				$this->updateData('servers',['pid'	=> (int)$output[0]],['portbase'	=> $port]);
				sleep(2);
				return $this->server("status" , $port);
				
			case "stop":
				If(!$this->server("status", $port)) return True;
				$pid = $this->sql->fetch_array("SELECT * FROM `servers` WHERE `portbase`=" . intval($port));
				exec("kill -9 {$pid[0]['pid']}");
				$this->updateData('servers',['pid'	=> ''],['portbase'	=> $port]);
				return $this->server("status", $port);
				
			default: 
				return False;
		}
	}

	public function delserver(string $server) {
		if (!$server) {
			return false;
		}
		$server = $this->sql->query('delete from servers where id = \'' . $server . '\';');
		return (object) $server;
	}

	public function deluser(string $user) {
		if (!$user) {
			return false;
		}
		$user = $this->sql->query('delete from admins where id = \'' . $user . '\';');
		return (object) $user;
	}

	public static function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}

	public function deldj(string $dj) {
		if (!$dj) {
			return false;
		}
		$dj = $this->sql->query('delete from dj where id = \'' . $dj . '\';');
		return (object) $dj;
	}

	public function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	public function delTree($dir) {
		$files = glob( $dir . '*', GLOB_MARK );
		foreach( $files as $file ){
			if( substr( $file, -1 ) == '/' )
				delTree( $file );
			else
				unlink( $file );
		}
		rmdir( $dir );
	}

	public function Exist(string $name): bool {
		$getUser = $this->sql->fetch_array('select id from admins where user = \'' . $name . '\' limit 1;');
		return !empty($getUser[0]);
	}

	public function CheckEmail(string $email) {
		$getEmail = $this->sql->fetch_array('select * from admins where email =\'' . $email . '\' order by id desc limit 1;');
		if (empty($getEmail[0])) {
			return false;
		}
		return (object) $getEmail[0];
	}

	public function InsertData(string $table, array $parameters) {
		$this->sql->insert($table,$parameters);
	}

	public function ipAddr(): string {
		return array_key_exists("HTTP_CF_CONNECTING_IP", $_SERVER) 
			? $_SERVER["HTTP_CF_CONNECTING_IP"] 
			: $_SERVER['REMOTE_ADDR'];
	}

	public function get_gravatar_url( $email ) {
		$address = strtolower( trim( $email ) );
		$hash = md5( $address );
		return 'https://www.gravatar.com/avatar/' . $hash;
	}

	public function doLogin(string $user, string $pass) {
		$getUser = $this->sql->fetch_array('SELECT pass FROM admins WHERE user = \'' . $user . '\' LIMIT 1;');
		if (empty($getUser[0])) {
			return false;
		} else if (Security::encrypt($pass) === $getUser[0]['pass']) {
			$token = Security::random(85);
			$time  = strtotime('+3 months');
			setcookie("user", $user, $time, "/");
			setcookie("pass", $token, $time, "/");
			$this->sql->update('admins', ['usrtoken' => $token], ['user' => $user]);
			
			return (object) $getUser[0];
		}
		return false;
	}

	public function get_dir_size($directory){
		$size = 0;
		$files = glob($directory.'/*');
		foreach($files as $path){
			is_file($path) && $size += filesize($path);
			is_dir($path)  && $size += get_dir_size($path);
		}
		return $size;
	} 

	public function getTotal(string $field): int {
		$total = $this->sql->fetch_array('SELECT id FROM ' . $field . ';');
		return count($total);
	}

	public function updateData(string $table, array $values, array $where): bool {
		$this->sql->update($table, $values, $where);
		return true;
	}

	public function getConfig(string $field): string {
		return $this->sql->fetch_array('SELECT ' . $field . ' FROM config WHERE id = \'' . $this->site . '\';')[0][$field];
	}

	public function setConfig(array $toUpdate) {
		return $this->sql->update('config', $toUpdate, ['id' => $this->site]);
	}

	public function userdetails($ip) {
		/* Free api - only 1000 request per day */
		$url    = "https://api.ipgeolocation.io/ipgeo?apiKey=".USER_DETAIL_KEY."&ip={$ip}&lang=en";
		$cURL   = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $url);
		curl_setopt($cURL, CURLOPT_HTTPGET, true);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json'
		));
		$op =  curl_exec($cURL);
		$op =  json_decode($op);
		$options = [
			'ip'      => $op->ip,
			'isp'     => $op->isp,
			'city'     => $op->city,
			'country' => $op->country_name
		];
		return $options;
	}
}