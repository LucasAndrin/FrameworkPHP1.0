<?php

namespace App\Http;

require_once 'vendor/autoload.php';

class Request implements RequestInterface
{

    function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->snakeCaseToCamelCase($key)} = $value;
        }
    }

    private function snakeCaseToCamelCase($string): string
    {
        $string = strtolower($string);

        preg_match_all('/_[a-z]/', $string, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $string = str_replace($match, $c, $string);
        }

        return $string;
    }

    private function prepareRequestMethod($methodData, $methodInput)
    {
        $body = array();

        foreach ($methodData as $key => $value) {
            $body[$key] = filter_input($methodInput, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }

    public function getBody()
    {
        return match ($this->requestMethod) {
            "GET" => $this->prepareRequestMethod($_GET, INPUT_GET),
            "POST" => $this->prepareRequestMethod($_POST, INPUT_POST),
        };
    }
}
