<?php
$path = $_SERVER['DOCUMENT_ROOT'];
session_start();
session_destroy();
// Redirect to the login page:
header('Location: index.html');
?>