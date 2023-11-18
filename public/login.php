<?php
require_once '../app.php';
include_once "$dir/partial/header.php";

$correct_user = 'admin';
$correct_pass_hash = '$2y$10$5Wk9V6yNaRybDpKOn9P6/.ZMEiF7yuUao/j0NYlVidMYEwZZYuy3K';

$login = $_POST['login']  ?? '';
$password = $_POST['password'] ?? '';

//echo password_hash($password, PASSWORD_DEFAULT);

if($login && $password) {
    if($login == $correct_user && password_verify($password, $correct_pass_hash) ) {
        echo 'correct';
        $_SESSION['person'] = $login;
    } else {
        $_SESSION['person'] = null;
        echo 'incorrect'; 
    }
}

$person = $_SESSION['person'] ?? '';

?>

<h1>Hi, <?= $person; ?> </h1>

<h1>Login</h1>

<form method="POST">
<div class="mb-3 row">
    <label for="login" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="login" name="login" value="">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" name="password">
    </div>
  </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <a href="logout.php">logout</a>
</form>



<?php


include_once "$dir/partial/footer.php";
