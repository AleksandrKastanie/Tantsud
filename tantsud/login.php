<?php
require_once ('connect.php');
 session_start();
 if (isset($_SESSION['tuvastamine'])) {
   header('Location: admin.php');
   exit();
   }
/*if (isset($_POST['login']) && isset($_POST['pass'])) {
    global $yhendus;
    $kask=$yhendus->prepare("SELECT kasutaja FROM kasutajad WHERE kasutaja=? AND parool=?");
    $kask  ->bind_param("ss", $login, $kryp);
    $kask->bind_result($nimi);
    $kask->execute();
}*/
 if (!empty($_POST['login']) && !empty($_POST['pass'])) {
     global $yhendus;
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));
    $sool = 'taiestisuvalinetekst';
    $kryp = crypt($pass, $sool);
    $kask=$yhendus->prepare("SELECT kasutaja FROM kasutajad WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $kryp);
    $kask->bind_result($nimi);
    $kask->execute();
    if ($kask->fetch()){
     $_SESSION['tuvastamine']='misiganes';
     $_SESSION['kasutaja']=$nimi;
     header('Location: admin.php');
     }
 else
 {
 echo "kasutaja $login või parool $kryp on vale";
    }
 }
?>
<h1>Login</h1>
<form action="" method="post">
 Login: <input type="text" name="login"><br>
 Password: <input type="password" name="pass"><br>
 <input type="submit" value="Logi sisse">
 <a href="register.php" type="button">Register</a>
</form>