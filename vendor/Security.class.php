<?php
namespace Vendor;

class Security {
    /**
     * Default value for the encrypt sum
     * @var integer
     */
    const DEFAULT_SUM = 0.9;

    /**
     * Encrypt a string or password with a such hash
     * 
     * @param  string $pass [String or password]
     * @return string
     */
    public static function encrypt(string $pass): string {
        $result = null;
        foreach (str_split($pass) as $v) {
            $dec = ord($v);
            if ($dec & 0x00000001) {
                $result .= substr(hash('md4', $result), -4);
            }
            if ($dec & 0x00000008) {
                $result .= '/';
            }
            $result .= dechex($dec * self::DEFAULT_SUM);
        }
        if ($dec & 0x00000004) {
            $result .= '/$' . strlen($pass);
        }
        return $result;
    }
    
    /**
     * Generates random letters and numbers
     * 
     * @param  int [Amount of characters]
     * @return string
     */
    public static function random(int $size): string {
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
     * Generates a random session
     * 
     * @return string
     */
    public static function siteKey(): string {
        $key = self::random(36);
        setcookie('sess_id', $key, strtotime('+48 hours'), '/');
        return $key;
    }
}
