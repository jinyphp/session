<?php

namespace jiny;

function session_start($db=null)
{
    if (\is_object($db)) {
        // 데이터 베이스 기반의 세션
        new \Jiny\Session\Database($db);
    } else if (\is_string($db)) {
        // 파일 기반의 세션
        new \Jiny\Session\File($db);
    }
    // else PHP 기본 세션
    
    
    // 세션 스타트
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

function cookie($key, $value=null, $time=3600)
{
    if ( $value !== null ) {
        // 쿠키설정
        setcookie($key, $value, time()+$time, "/");
    } else {
        // 쿠키읽기
        if(isset($_COOKIE[$key])) return $_COOKIE[$key];
    }
}

function cookieClears(...$args)
{
    foreach ($args as $name) {
        \jiny\cookie($name, "", -3600);
    }
}