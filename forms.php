</!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<title>Testing job</title>
</head>
<body>

<div style="width: 1200px; height: 1000px;">

<? 
if(isset($loginError)): ?>

<div class="alert alert-danger" role="alert">

<?=$loginError?>

</div>
<? endif; ?>

<? if(isset($regErrors)): ?>
  <? foreach ($regErrors as $key => $value): ?>

    <div class="alert alert-danger" role="alert">

    <?=$value ?>

    </div>

  <? endforeach; ?>
<? endif; ?>

<div style="float: left; margin: 15px 0px 0px 55px;">

  <h3>Авторизация</h3><br>

<form action="index.php?action=login" method="post" name="form_login">
  <div class="mb-3">
    <label for="InputLogin" class="form-label">Логин</label>
    <input type="text" name="login" class="form-control" id="InputLogin" placeholder="Логин" 
    <? if (isset($_POST['login']))

    echo 'value=' . $_POST['login'] 

  ?>
  >
  </div>

  <div class="mb-3">
    <label for="InputPassword" class="form-label">Пароль</label>
    <input type="password" name="password" class="form-control" id="InputPassword" placeholder="Ваш пароль" 

  <? if (isset($_POST['password']))

    echo 'value=' . $_POST['password'] 

  ?>
>
  </div>
  
  <button type="submit" class="btn btn-primary">Войти</button>
</form>

</div>

<div style="float: left; margin: 15px 0px 0px 75px;">

  <h3>Регистрация</h3><br>

<form action="?action=registration" method="post" name="form_registr" id="form_registr">

  <div class="mb-3">
    <label for="InputLogin" class="form-label">Логин</label>
    <input type="text" name="login" class="form-control" id="InputLogin" placeholder="Логин"

    <? if (isset($_POST['login']))

    echo 'value=' . $_POST['login'] 

  ?>

    >
  </div>

  <div class="mb-3">
    <label for="InputPassword" class="form-label">Пароль</label>
    <input type="password" name="pass1" class="form-control" id="InputPassword" placeholder="Ваш пароль"

    <? if (isset($_POST['pass1']))

    echo 'value=' . $_POST['pass1'] 

  ?>

    >
  </div>

  <div class="mb-3">
    <label for="InputPassword" class="form-label">Повтор пароля</label>
    <input type="password" name="pass2" class="form-control" id="InputPassword" placeholder="Повтор пароля"

    <? if (isset($_POST['pass2']))

    echo 'value=' . $_POST['pass2'] 

  ?>

    >
  </div>

  <div class="mb-3">
    <label for="InputEmail1" class="form-label">Ваш email</label>
    <input type="email" name="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp"  placeholder="Ваш email"

    <? if (isset($_POST['email']))

    echo 'value=' . $_POST['email'] 

  ?>

    >
  </div>

<div class="mb-3">
    <label for="InputName" class="form-label">Имя</label>
    <input type="text" name="name" class="form-control" id="InputName" placeholder="Ваше имя"

    <? if (isset($_POST['name']))

    echo 'value=' . $_POST['name'] 

  ?>

    >
  </div><br>

  <button type="submit" class="btn btn-primary">Регистрация</button>

 </form>

</div>
</div>

</body>
</html>