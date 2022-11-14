<?php

include_once('Db.php');

function registration()
{
   $login = isset($_POST['login']) ? $_POST['login'] : null;

   $login = strip_tags(trim($login));

   $pwd1 = isset($_POST['pass1']) ? $_POST['pass1'] : null;

   $pwd1 = strip_tags(trim($pwd1));

   $pwd2 = isset($_POST['pass2']) ? $_POST['pass2'] : null;

   $pwd2 = strip_tags(trim($pwd2));

   $email = isset($_POST['email']) ? $_POST['email'] : null;

   $email = strip_tags(trim($email));  

   $name = isset($_POST['name']) ? $_POST['name'] : null;

   $name = strip_tags(trim($name));

   $result = null;

   checkRegisterParams($login, $pwd1, $pwd2, $email, $name);

   $result = checkUserLogin($login);

   if($result)
   {      
      $regErrors['message'] = "Пользователь с таким логином ({$login}) уже зарегистрирован";

      include_once 'forms.php';
   }

   $result = checkUserEmail($email);

   if($result)
   {
      $regErrors['message'] = "Пользователь с таким email ({$email}) уже зарегистрирован";
      include_once 'forms.php';
   }

   if($result == false)
   {
      $pwdMD5 = md5($pwd1);
    
      $res = registerNewUser($login, $pwdMD5, $email, $name);

      if($res)
      {
         $_SESSION['name'] = '<h3>Поздравляем с регистрацией, ' . $name. '</h3>';
         header("Location: cabinet.php");      
      }
      else 
      {
         $regErrors['message'] = 'Ошибка регистрации';
         include_once 'forms.php';
      }
   }

  return true;
}

function login()
{  

  $login = isset($_POST['login']) ? ($_POST['login']) : null;
  $login = strip_tags(trim($login));

  $pass = isset($_POST['password']) ? ($_POST['password']) : null;
  $pass = strip_tags(trim($pass));
  
  checkLoginParams($login, $pass);

  $result = loginUser($login, $pass);

  if($result)
  {
    $_SESSION['name'] = $result['name'];
     
    setcookie("name", $result['name'], time() + 3600);

    header("Location: index.php");
  }
  else
      {
         $loginError = 'Не верный логин или пароль';
         include_once 'forms.php';
      }
}

/**
* Разлогирование пользователя
*
*/

function logout()
{
  if(isset($_SESSION['name']))
  {
     session_destroy();
  }

   setcookie ("name", "", time() - 3600);
   
   header("Location: index.php");
}

function checkRegisterParams($login, $pwd1, $pwd2, $email, $name)
{
   $regErrors = [];

   if(isset($login) AND $login == '')
   {
      $regErrors['login'] = 'Введите логин';
   }

   if(isset($pwd1) AND $pwd1 == '')
   {
      $regErrors['pwd1'] = 'Введите пароль';
   }

   if(isset($pwd2) AND $pwd2 == '')
   {
      $regErrors['pwd2'] = 'Введите повтор пароля';
   }

   if($pwd1 != $pwd2)
   {
      $regErrors['pwd12'] = 'Пароли не совпадают';
   }

   if(isset($email) AND $email == '')
   {
      $regErrors['email'] = 'Введите email';
   }
   else
      {
         $result = checkEmail($email);

         if(!$result)
            $regErrors['email'] = 'Е-майл не корректен';
      }

   if(isset($name) AND $name == '')
   {
      $regErrors['name'] = 'Введите имя';
   }

   if(count($regErrors) > 0)
   {
      include_once 'forms.php'; 
      exit;     
   }

   return true;
}

function checkUserLogin($login)
{
   $db = Db::getConnection();

   $sql = "SELECT id FROM users WHERE login = :login";

   $result = $db->prepare($sql);

   $result->bindParam(':login', $login, PDO::PARAM_STR);

   $result->execute();

   if($result->fetchColumn())
   {
      return true;
   }

   return false;
}

function checkUserEmail($email)
{
   $db = Db::getConnection();

   $sql = "SELECT id FROM users WHERE email = :email";

   $result = $db->prepare($sql);

   $result->bindParam(':email', $email, PDO::PARAM_STR);

   $result->execute();

   if($result->fetchColumn())
   {
      return true;
   }

   return false;
}

function loginUser($login, $pwd)
{
   $db = Db::getConnection();

   $pwd = md5($pwd);
   $sql = "SELECT * FROM `users` WHERE `login` = :login and `password` = :pwd";

   $result = $db->prepare($sql);

   $result->bindParam(':login', $login, PDO::PARAM_STR);
   $result->bindParam(':pwd', $pwd, PDO::PARAM_STR);

   $result->execute();

   $array = $result->fetch(PDO::FETCH_ASSOC);

   if(isset($array))
   {
      return $array;
   }

   return false;
}

function checkEmail($email)
{
   
   $domain = substr(strrchr($email, "@"), 1);

   $exp = "/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i";

   if(!preg_match($exp,$email) AND !checkdnsrr($domain,"MX"))
   {
      return false;
   }

   return true;
}

function checkLoginParams($login, $pass)
{
   $loginError = null;

   if ($login == null AND $pass == null)
   {
      $loginError = 'Необходимо ввести логин и пароль';
   }

   elseif ($login == null)
   {
      $loginError = 'Необходимо ввести логин';
   }

   elseif($pass == null)
   {
      $loginError = 'Необходимо ввести пароль';
   }

   if ($loginError != '')
   {
      include_once 'forms.php';
      exit;
   }

  return true;
}

function registerNewUser($login, $pwdMD5, $email, $name)
{
   $db = Db::getConnection();

   $sql = "INSERT INTO users (`login`, `password`, `email`, `name`)"
     . " VALUES (:login, :password, :email, :name)";

   $result = $db->prepare($sql);

   $result->bindParam(':login', $login, PDO::PARAM_STR);
   $result->bindParam(':password', $pwdMD5, PDO::PARAM_STR);
   $result->bindParam(':email', $email, PDO::PARAM_STR);   
   $result->bindParam(':name', $name, PDO::PARAM_STR);

   return $result->execute();
}
