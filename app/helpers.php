<?php

use Core\Request as Request;

function set_active($path, $active = 'active', $inactive = 'inactive')
{
    return Request::is($path) ? $active  : $inactive;
}

function out($param, $default = ''){
    return isset($param) ? htmlspecialchars($param) : $default;
}

function url($uri = "/") {
    return BASE_URL.$uri;
}

function has($param){
    return !empty($param);
}

function backUrl() {
    $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL;
    return $url;
}