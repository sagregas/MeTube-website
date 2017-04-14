<?php

session_start();
include 'config.php';

if(isset($_POST['Remove']))
{
print_r($_POST);
foreach ($_POST as $key => $value) {
        $key=preg_replace( '/_[^_]*$/', '', $key );
echo $key;
}}?>

