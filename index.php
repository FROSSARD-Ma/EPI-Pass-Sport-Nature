<?php
session_start(); 

// ====== upload AUTOMATIQUE CLASS ============
require_once 'vendor/autoload.php';


//== CONFIG chemin relatif / absolute =========
$root = $_SERVER['DOCUMENT_ROOT'];
$host = $_SERVER['HTTP_HOST'];


define('HOST', 'https://'.$host.'/'); // model/View.php
define('ROOT', $root . '/');
define('VIEW', ROOT.'views/'); // model/View.php

//== ROOTER =========================
$url = $_GET['url'];

$router = new Epi_Model\Router($url);
$router->run();

//== GESTION SESSION =================
unset($_SESSION['message']);
unset($_SESSION['erreur']);

?>