<?php

class URIResolver
{
    private static $uriResolver;

    private function __construct()
    {
    }

    public static function getURIResolver()
    {
        if (self::$uriResolver === null) {
            self::$uriResolver = new self();
        }
        return self::$uriResolver;
    }

    public function getValue($name)
    {
        if ($this->hasGET($name)) {
            return $_GET[$name];
        }
        return false;
    }

    public function getPOSTValue($name)
    {
        if ($this->hasPOST($name)) {
            return $_POST[$name];
        }
        return false;
    }

    public function hasGET($name)
    {
        return isset($_GET[$name]);
    }

    public function hasPOST($name)
    {
        return isset($_POST[$name]);
    }

    public function setToURI($uri, $name, $value)
    {
        if (strripos($uri, '?') !== false)
        {
            $valuess = substr($uri, strripos($uri, '?') + 1);
            $values = explode('&', $valuess);
            foreach ($values as $val) {
                if (strripos($val, $name . '=') === 0) {
                    $replace = $name . '=' . $value;
                    return str_replace($val, $replace, $uri);
                }
            }
            return $uri . '&' . $name . '=' . $value;
        }
        else
        {
            return $uri . '?' . $name . '=' . $value;
        }
    }

    public function clearURI($uri)
    {
        if (strripos($uri, '?') !== false) {
            return substr($uri, 0, strripos($uri, '?'));
        }
        return $uri;
    }

    public function getOnlyValues($uri)
    {
        return substr($uri, strripos($uri, '?'));
    }

    public function unsetFromURI($uri, $name)
    {
        $valuess = substr($uri, strripos($uri, '?') + 1);
        $values = explode('&', $valuess);
        $valname = "";
        foreach ($values as $val) {
            if (strripos($val, $name . '=') === 0) {
                $valname = $val;
            }
        }
        if (strripos($valuess, $valname) === 0 && strripos($valuess, "&")) {
            return str_replace($valname . '&', '', $uri);
        } else if (strripos($valuess, $valname) === 0) {
            return str_replace('?' . $valname, '', $uri);
        } else {
            return str_replace('&' . $valname, '', $uri);
        }
    }
}
