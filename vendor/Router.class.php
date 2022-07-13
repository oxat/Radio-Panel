<?php
namespace Vendor;

use Functions;
use Vendor\Header;
use Vendor\Mimetype;

class Router {
    /**
     * Routes will make it enabled/disabled
     * @var boolean
     */
    private $error404 = true;

    /**
     * Initialize the routes system
     */
    public function initialize() {
        $file = DIRECTORY . SEPARATOR . substr(\App::getUrl(), 1);
        $ext  = pathinfo($file, PATHINFO_EXTENSION);
        $mime = Mimetype::getByExtension($ext);
        if ($mime) {
            ob_start();
            Header::set($mime);
            Header::cache($file);
            print file_get_contents($file);
            ob_flush();
        } else if ($this->error404) {
            $page = substr(\App::getUrl(), 1);
            new Functions\Error404($page);
        }
    }

    /**
     * Add a new route
     * 
     * @param  string $page [Page URI]
     * @param  array $args [Function aka Controller]
     * @return mixed
     */
    public function new(string $page, array $args) {
        if (count($args) < 2) {
            return false;
        } elseif ($page == strtolower(\App::getUrl())) {
            $object = new $args[0]();
            $this->error404 = false;
            return $object->{$args[1]}();
        }
    }
}
