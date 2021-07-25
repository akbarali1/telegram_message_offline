<?php
$loginpage = 'loginpage';
require 'core.php';
//Agarda birorkim buzmoqcchi bo`lsa sesia orqali aniqlab uni bloklaymiz
if (isset($_SESSION['passwor_error']) && count($_SESSION['passwor_error']) >= '3') {
  die("The system was blocked because the password was typed too many errors");
}
//Parol to`g`ri bo`lsa tizimga kirgazamiz bo`lmasa o`lim
if (isset($_POST['password'])) {
  if (md5(md5($_POST['password'])) != PASSWORD) {
    $_SESSION['passwor_error'][] = '1';
    die("Parol xato");
  } else {
    if (md5(md5($_POST['password'])) === PASSWORD) {
      $_SESSION['login'] = md5(md5($_POST['password']));
      header('Location: ./index.php');
      die;
    } else {
      $_SESSION['manager_passwor_derror'][] = '1';
      die("Password Error");
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maxfiy joyga kirish</title>
</head>

<body>
  <form method="POST">
    <div class="form-group mb-3">
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required autocomplete="on" autofocus>
    </div>
    <input type="submit" value="Login" class="btn btn-dark btn-block">
  </form>
</body>

</html>