<?php

use core\Router;

function url($url)
{
    return Router::getWebroot() . $url;
}
