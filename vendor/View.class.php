<?php
namespace Vendor;

class View {
    /**
     * Old HTML characters
     */
    const MINIFY_HTML = [
        '/	/',
        '/    /',
        '/\n/',
        '/\>[^\S ]+/s',
        '/[^\S ]+\</s',
        '/<!--(.|\s)*?-->/',
        
    ];
    /**
     * New HTML characters
     */
    const MINIFY_NEW = [
        '',
        '',
        '',
        '>',
        '<',
        '',
    ];
    /**
     * Old textarea characters
     */
    const FIX_TEXTAREA = [
        "\n", 
        "\r", 
        " ",
    ];
    /**
     * New textarea characters
     */
    const FIX_TEXTNEW = [
        "&#10;",
        "&#13;",
        "&#160;",
    ];

    /**
     * Get contents to be rendered
     * Template directory should be separated by . (dot) not / (slash)
     * 
     * @param  string $page [Template dir]
     * @param  array $args [Arguments]
     * @return mixed
     */
    public static function get(string $page, $args = array()) {
        $sanatized = str_replace('/', SEPARATOR, $page);
        $directory = DIRECTORY . SEPARATOR . 'app' . SEPARATOR . 'views' . SEPARATOR . $sanatized . '.php';
        if (!file_exists($directory)) {
            return false;
        }
        ob_start();
        foreach($args as $key => $value) { 
            $$key = $value; 
        }
        include $directory;
        return ob_get_clean();
    }

    /**
     * Render template
     * Template directory should be separated by . (dot) not / (slash)
     * 
     * @param  string $page [Template dir]
     * @param  array $args [Arguments]
     * @return mixed
     */
    public static function render(string $page, $args = array()) {
        $sanatized = str_replace('/', SEPARATOR, $page);
        $directory = DIRECTORY . SEPARATOR . 'app' . SEPARATOR . 'views' . SEPARATOR . $sanatized . '.php';
        if (!file_exists($directory)) {
            return false;
        }
        ob_start(array(__CLASS__, 'minify'));
        foreach($args as $key => $value) { 
            $$key = $value; 
        }
        include $directory;
        return ob_get_flush();
    }

    /**
     * Prints JSON response
     * 
     * @param  array $values [List of values]
     */
    public static function json(array $values) {
        Header::set('application/json');
        print json_encode($values);
    }
    
    /**
     * Prints XML response
     * 
     * @param  string $values [XML already parsed]
     */
    public static function xml(string $values) {
        Header::set('text/xml');
        print $values;
    }
    
    /**
     * Prints plain text response
     * 
     * @param  string $page [Plain text]
     */
    public static function plain(string $page) {
        print $page;
    }
    
    /**
     * Prints textarea with minify enabled
     * 
     * @param  string $page [Plain text]
     * @return string
     */
    public static function TextArea(string $page): string {
        if (MINIFY_DATA) {
            return str_replace(self::FIX_TEXTAREA, self::FIX_TEXTNEW, $page);
        }
        
        return $page;
    }

    /**
     * Minify HTML output
     * 
     * @param  string $content [HTML output]
     * @return string
     */
    public static function minify(string $content): string {
        if (MINIFY_DATA) {
            $content = preg_replace(self::MINIFY_HTML, self::MINIFY_NEW, $content);
        }
        return $content;
    }
}
