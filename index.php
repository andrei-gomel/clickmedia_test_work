<?php

session_start();

include_once('functions.php');

if(isset($_SESSION['name']))
{
	echo '<h3>Привет, ' . $_SESSION['name'] . '</h3>';
	echo ' <a href="index.php?action=logout">Выход</a>';
}

if (isset($_GET['action']) AND $_GET['action'] == 'login')
	login();

if (isset($_GET['action']) AND $_GET['action'] == 'registration')
	registration();

if (!isset($_POST['submit']) AND !isset($_SESSION['name']))
	include_once('forms.php');

if(isset($_GET['action']) AND $_GET['action'] == 'logout')
	logout();