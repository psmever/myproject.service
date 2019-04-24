<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'][] = array(
    'filepath' => 'hooks',
    'filename' => 'Post_controller_hook.php',
    'class'    => 'Post_controller_hook',
    'function' => 'startHook',
    'params'   => ''
);

$hook['pre_controller'][] = array(
    'filepath' => 'hooks',
    'filename' => 'Pre_controller_hook.php',
    'class'    => 'Pre_controller_hook',
    'function' => 'startHook',
    'params'   => ''
);