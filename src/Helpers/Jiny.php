<?php

namespace jiny;

function session_start($db=null)
{
    if ($db) {
        new \Jiny\Session\Database($db);
    } else {
        new \Jiny\Session\File();
    }
    
    \session_start();
}

function session($key, $value=null)
{
    // 배열일 경우 세션을 설정합니다.
    if (\is_array($key)) {
        foreach( $key as $k => $v) {
            $_SESSION[$k] = $v;
        }
        return true;
    }

    if ($value) {
        // 값을 설정합니다.
        return $_SESSION[$key];
    } else {
        // 값을 읽어 옵니다.
        $_SESSION[$key] = $value;
        return true;
    }
}