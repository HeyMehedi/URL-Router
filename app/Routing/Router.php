<?php
namespace OurApplication\Routing;

class Router {
    private static $nomatch = true;

    // Requested URL
    private static function getUrl() {
        return $_SERVER['REQUEST_URI'];
    }

    // Full URL to Matches Array
    private static function getMatches($pattern) {
        $url = self::getUrl();
        if (preg_match($pattern, $url, $matches)) {
            return $matches;
        }
        return false;
    }

    // Processing
    private static function process($pattern, $callback) {
        $pattern = "~^{$pattern}/?$~";
        $params  = self::getMatches($pattern);
        if ($params) {
            $functionArguments = array_slice($params, 1);
            self::$nomatch     = false;
            if (is_array($callback)) {
                $className  = $callback[0];
                $methodName = $callback[1];
                $instance   = $className::getInstance();
                $instance->$methodName(...$functionArguments);
            } elseif (is_string($callback)) {
                $parts      = explode("@", $callback);
                $className  = $parts[0];
                $methodName = $parts[1];
                $instance   = $className::getInstance();
                $instance->$methodName(...$functionArguments);
            } else {
                $callback(...$functionArguments);
            }
        }
    }

    // GET Verb
    static function get($pattern, $callback) {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return;
        }
        self::process($pattern, $callback);
    }

    // POST Verb
    static function post($pattern, $callback) {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }
        self::process($pattern, $callback);
    }

    // DELETE Verb
    static function delete($pattern, $callback) {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            return;
        }
        self::process($pattern, $callback);
    }

    // Error
    static function cleanup() {
        if (self::$nomatch) {
            echo "No Routes Matched </br><strong>" . self::getUrl() . "</strong>";
        }
    }
}