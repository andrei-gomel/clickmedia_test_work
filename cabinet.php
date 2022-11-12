<?
session_start();

if(isset($_SESSION['name']))
{
	echo $_SESSION['name'];

	echo '<a href="index.php?action=logout">Выход</a>';
}
else
{
	echo 'Вам необходимо <a href="index.php">войти</a>';
}

