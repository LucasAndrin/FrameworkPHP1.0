<?php

namespace App\Http;

require_once 'vendor/autoload.php';

interface RequestInterface {

    public function getBody();
    
}