<?php
session_start();
include_once '../lib/helpers.php';

if(isset($_GET['modulo'])){
    resolve();
}

?>