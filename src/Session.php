<?php

namespace Jiny\Session;

class Session
{
    public function __construct()
    {

    }

    public function is($key)
    {
        if (isset($key)) {
            return $_SESSION[$key];
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
        return $this;
    }

}