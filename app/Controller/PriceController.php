<?php
namespace OurApplication\Controller;
class PriceController {
    private static $instance;
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function showPrice() {
        echo "Price is 10tk";
    }
}