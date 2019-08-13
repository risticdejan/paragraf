<?php

use Core\Request as Request;

function set_active($path, $active = 'active', $inactive = 'inactive')
{
    return Request::is($path) ? $active  : $inactive;
}