<?php
namespace Vendor;

use Vendor\Curl;

class Validator {
    /**
     * Check if the given string is numeric
     * 
     * @param  string $value [String value]
     * @return boolean
     */
    public static function isNumeric(string $value): bool {
        return preg_match('/^[1-9][0-9]*$/', $value);
    }
    
    /**
     * Check if the given string is alpha-numeric
     * 
     * @param  string $value [String value]
     * @return boolean
     */
    public static function isAlphanumeric(string $value): bool {
        return preg_match('/^[a-zA-Z0-9]+$/', $value);
    }

    /**
     * Check if the given string is a correct email
     * 
     * @param  string $value [String value]
     * @return boolean
     */
    public static function isValidEmail(string $value): bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL); // not regex for now
    }
    
    /**
     * Check if the given string is a valid URL
     * 
     * @param  string $value [String value]
     * @return boolean
     */
    public static function isValidURL(string $value): bool {
        return filter_var($value, FILTER_VALIDATE_URL); // not regex for now
    }

    /**
     * Check if the value lenght is between the allowed
     * 
     * @param  string $value [String value]
     * @param  int $min [Minimum allowed]
     * @param  int $max [Maximum allowed]
     * @return boolean
     */
    public static function isBetween(string $value, int $min, int $max): bool {
        return strlen($value) >= $min && strlen($value) <= $max;
    }

    /**
     * Check if all none is empty
     * 
     * @param  array $values [Fields]
     * @return boolean
     */
    public static function isFilled(array $values): bool {
        foreach ($values as $k) {
            if (empty($k)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Check if field exists in an array
     * 
     * @param  string $field [Field]
     * @param  array $values [List of fields]
     * @return boolean
     */
    public static function isRequested(string $field, array $values): bool {
        foreach ($values as $k) {
            if (!array_key_exists($k, $field)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if the Google REcaptcha is correct
     * 
     * @param  string [g-recaptcha-response]
     * @return boolean
     */
    public static function recaptcha(string $value): bool {
        $response = Curl::postHttps('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => RECAPTCHA_PRIVATE,
            'response' => $value
        ]);
        $json = json_decode($response, false);
        return (bool) $json->success;
    }
}
