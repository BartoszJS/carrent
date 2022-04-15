<?php
include 'includes/database-connection.php'; 
include 'includes/functions.php'; 
include 'includes/validate.php';

$errors['email']    ='';
$errors['haslo']    ='';


$member['email']    ='';
$member['haslo']    ='';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Logowanie</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
<br><br><br><br> 
<form action="zglos.php" method="POST" enctype="multipart/form-data"> 
<br><br>
    <section class="formularz">
    <div class="ramka">
      <br>
      <h1>Logowanie</h1> <br>


        <div class="form-group">
          <label for="title">  E-mail: </label> <br>
          <input type="text" name="email" id="email" value="<?= html_escape($member['email']) ?>"
                 class="form-control">
                 <span class="errors"><?= $errors['email'] ?></span>
        </div><br>

        <div class="form-group">
          <label for="title">  Haslo: </label> <br>
          <input type="password" name="haslo" id="haslo" value="<?= html_escape($member['haslo']) ?>"
                 class="form-control">
                 <span class="errors"><?= $errors['haslo'] ?></span>
        </div><br><br>

        <div class="loginbutton">
        <input type="submit" name="update" class="btn" value="ZALOGUJ SIĘ" class="btn btn-primary">
        <br><br>
        </div>
        <div class="utworz">
            <span >Nie masz konta?</span>
            <a href="rejestracja.php">Utwórz konto</a>
        </div>
        <br>

        

        <br>
     
      </div>
    </section>
    <br>
</form>
    
</body>
</html>