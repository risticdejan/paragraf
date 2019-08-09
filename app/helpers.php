<?php

use Core\Request as Request;
/**
 * Get the class depending on the path.
 *
 * @param string $path
 * @param string $active
 * @param string $inactive
 * @return string
 */
function set_active($path, $active = 'active', $inactive = 'inactive')
{
    return Request::is($path) ? $active  : $inactive;
}