<?php
require_once '../include/functions.php';

session_start();
session_unset();
session_destroy();

redirect('login.php');
?>