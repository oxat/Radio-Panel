<?php
class App {
    /**
     * CSRF field name on HTML
     */
    const CSRF_FIELD = '_csrf';
    /**
     * All request methods allowed
     */
    const REQUEST_ALLOWED = [
        'POST', 
        'GET', 
        'HEAD', 
        'PUT', 
        'DELETE'
    ];
    /**
     * Common proxy ports
     */
    const PROXY_PORTS = [
        80, 
        8080, 
        3128, 
        443, 
        1080
    ];
    /**
     * Common proxy headers
     */
    const PROXY_HEADERS = [
        'HTTP_VIA',
        'VIA',
        'Proxy-Connection',
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'HTTP_FORWARDED_FOR_IP',
        'X-PROXY-ID',
        'MT-PROXY-ID',
        'X-TINYPROXY',
        'X_FORWARDED_FOR',
        'FORWARDED_FOR',
        'X_FORWARDED',
        'FORWARDED',
        'CLIENT-IP',
        'CLIENT_IP',
        'PROXY-AGENT',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION'
    ];
    /**
     * Some user-agents for mobile detection
     */
    const MOBILE_UA = [
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    ];

    /**
     * Removing slash from strings
     * 
     * @param  string $url [Your string]
     * @return string
     */
    public static function removeSlashes(string $url): string {
        return preg_replace('#/+#', '/', $url);
    }

    /**
     * Return current URL
     * 
     * @return string
     */
    public static function getUrl(): string {
        return self::removeSlashes(strtok($_SERVER['REQUEST_URI'], '?'));
    }

    /**
     * ################
     * ## DO NOT USE ##
     * ################
     * Load all classes
     * 
     * @return array
     */
    public static function loadClasses(): array {
        return self::rglob(DIRECTORY . SEPARATOR . 'app' . SEPARATOR . 'classes' . SEPARATOR . '*.php');
    }

    /**
     * ################
     * ## DO NOT USE ##
     * ################
     * Load all functions
     * 
     * @return array
     */
    public static function loadFunctions(): array {
        return self::rglob(DIRECTORY . SEPARATOR . 'app' . SEPARATOR . 'functions' . SEPARATOR . '*.php');
    }

    /**
     * ################
     * ## DO NOT USE ##
     * ################
     * Load all vendor files
     * 
     * @return array
     */
    public static function loadVendor(): array {
        return self::rglob(DIRECTORY . SEPARATOR . 'vendor' . SEPARATOR . '*.class.php');
    }
    
    /**
     * Detect and store the browser language
     */
    public static function setLanguage(): string {
        $lang = self::detectLanguage();
        require_once(DIRECTORY . SEPARATOR . 'app' . SEPARATOR . 'lang' . SEPARATOR . $lang . '.php');
        setCookie('lang', $lang, strtotime('+10 years'));
        return $lang;
    }
    
    /**
     * Disallow direct access to certain folders and files
     * 
     * @param  array [List of directories banned]
     * @return boolean
     */
    public static function isForbidden(array $values) {
        $directory = explode('/', $_SERVER['SCRIPT_NAME']);
        if (empty($directory[1])) {
            return false;
        }
        if (in_array($directory[1], $values)) {
            http_response_code(403);
            exit;
        }
        return true;
    }

    /**
     * Detect if the browser is mobile
     * 
     * @return boolean
     */
    public static function isMobile() {
        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return false;
        }
        foreach(self::MOBILE_UA as $regex => $os) {
            if(preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
                return $os;
            }
        }
        return false;
    }
    
    /**
     * Get the user IP
     * Compatible with CloudFlare
     * 
     * @return string
     */
    public static function getIp(): string {
        return array_key_exists("HTTP_CF_CONNECTING_IP", $_SERVER) 
            ? $_SERVER["HTTP_CF_CONNECTING_IP"] 
            : $_SERVER['REMOTE_ADDR'];
    }
    
    /**
     * Detect if the request is from a bot
     * 
     * @return boolean
     */
    public static function isBot(): bool {
        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return false;
        }
        return (preg_match('/bing|google|bot|spider/i', $_SERVER['HTTP_USER_AGENT']));
    }
    
    /**
     * Detect if the request is from a real user
     * 
     * @return boolean
     */
    public static function isRealUser(): bool {
        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return false;
        } else if (strlen($_SERVER['HTTP_USER_AGENT']) < 15) {
            return false;
        } else if (!self::isBot()) {
            $name  = md5(self::getIp());
            $token = sha1(self::getIp());
            $_SESSION[$name] = $token;
            if (!array_key_exists($name, $_SESSION)) {
                return false;
            } else if ($_SESSION[$name] != $token) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Generates a CSRF token
     * 
     * @param  integer [Default is 3]
     * @return string
     */
    public static function doCSRF($level = 3): string { // default is 3
        switch ($level) {
            case 2:
                $token = base64_encode(self::randomAlias(45));
                break;
            case 3:
                $token = self::randomAlias(45) . md5(time());
                break;
            default:
                $token = sha1(microtime(true));
                break;
        }
        self::newSession(md5(self::getIp()), $token);
        return $token;
    }
    
    /**
     * Get the CSRF token
     * 
     * @return string
     */
    public static function getCSRF() {
        return self::getSession(md5(self::getIp()));
    }
    
    /**
     * Verify if the CSRF sent by POST is correct
     * 
     * @return boolean
     */
    public static function validateCSRF(): bool {
        return self::post(self::CSRF_FIELD) === self::getCSRF();
    }

    /**
     * Create a new session on the server
     * 
     * @param  string $name [Session name]
     * @param  string $value [Session values]
     * @return string
     */
    public static function newSession(string $name, string $value): bool {
        $dir  = DIRECTORY . SEPARATOR . 'app' . SEPARATOR . 'sessions';
        $file = SEPARATOR . $name . '.txt';
        if (!is_writable($dir)) {
            chmod($dir, 0644);
        }
        return file_put_contents(
            $dir . $file, 
            strip_tags($value)
        );
    }
    
    /**
     * Get a session from the server
     * 
     * @param  string $name [Session name]
     * @return mixed
     */
    public static function getSession(string $name) {
        $dir  = DIRECTORY . SEPARATOR . 'app' . SEPARATOR . 'sessions';
        $file = SEPARATOR . $name . '.txt';
        if (!is_readable($dir)) {
            chmod($dir, 0644);
        } else if (!file_exists($dir . $file)) {
            return null;
        }
        return file_get_contents($dir . $file);
    }
    
    /**
     * Just display the CSRF on HTML
     */
    public static function inputCSRF() {
        print '<input type="hidden" name="' . self::CSRF_FIELD . '" value="' . self::doCSRF() . '" />';
    }
    
    /**
     * Verify if the request was using proxies
     * 
     * @return boolean
     */
    public static function hasProxy(): bool {
        foreach(self::PROXY_HEADERS as $header){
            if (array_key_exists($header, $_SERVER) && !empty($_SERVER[$header])) {
                return true;
            }
        }
        foreach(self::PROXY_PORTS as $port) {
            if(@fsockopen(self::getIp(), $port, $errno, $errstr, 1)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Generates random letters and numbers
     * 
     * @param  int [Amount of characters]
     * @return string
     */
    public static function randomAlias(int $size): string {
        $result = null;
        $random = array_merge(
            range(0, 9),
            range('a', 'z'),
            range('A', 'Z')
        );
        for ($i = 1; $i <= $size; $i++) {
            $result .= $random[array_rand($random)];
        }
        return $result;
    }
    
    /**
     * Detect the browser language
     * 
     * @return string
     */
    public static function detectLanguage(): string {
        $getFromBrowser = array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'en';
        $getLanguage = substr($getFromBrowser, 0, 2);
        $language = strtolower(strip_tags($getLanguage));
        if (file_exists(DIRECTORY . SEPARATOR . 'app' . SEPARATOR . 'lang' . SEPARATOR . $language . '.php')) {
            return $language;
        }
        return defined('DEFAULT_LANG') ? DEFAULT_LANG : 'en';
    }

    /**
     * Check the request method, like GET, POST etc
     * 
     * @return string
     */
    public static function method(): string {
        $getMethod = array_key_exists('REQUEST_METHOD', $_SERVER) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        if (in_array($getMethod, self::REQUEST_ALLOWED)) {
            return $getMethod;
        }
        return 'GET';
    }

    /**
     * $_REQUEST method
     * 
     * @param  string $name [Input name]
     * @param  boolean $sanatize [Sanatize data against injections]
     * @return mixed
     */
    public static function input($value, $sanatize = true) {
        if (array_key_exists($value, $_REQUEST)) {
            if ($sanatize) {
                return strip_tags($_REQUEST[$value]);
            }
            return $_REQUEST[$value];
        }
        return null;
    }
    
    /**
     * $_POST method
     * 
     * @param  string $name [Input name]
     * @param  boolean $sanatize [Sanatize data against injections]
     * @return mixed
     */
    public static function post($value, $sanatize = true) {
        if (array_key_exists($value, $_POST)) {
            if ($sanatize) {
                return strip_tags($_POST[$value]);
            }
            return $_POST[$value];
        }
        return null;
    }
    
    /**
     * $_GET method
     * 
     * @param  string $name [Input name]
     * @param  boolean $sanatize [Sanatize data against injections]
     * @return mixed
     */
    public static function get($value, $sanatize = true) {
        if (array_key_exists($value, $_GET)) {
            if ($sanatize) {
                return strip_tags($_GET[$value]);
            }
            return $_GET[$value];
        }
        return null;
    }

    /**
     * Get all files in the directory and sub-directories
     * 
     * @param  string $pattern [Pattern for the glob]
     * @param  integer $flags [Set glob flags]
     * @return array
     */
    public static function rglob($pattern, $flags = 0): array {
        $files = glob($pattern, $flags); 
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
            $files = array_merge($files, self::rglob($dir . '/' . basename($pattern), $flags));
        }
        return $files;
    }
}
