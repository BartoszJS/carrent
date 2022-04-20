<?php
include 'src/bootstrap.php';    
include 'includes/database-connection.php'; 
include 'includes/validate.php';

$errors['email']    ='';
$errors['imie']     ='';
$errors['nazwisko'] ='';
$errors['haslo']    ='';
$errors['potwierdz']    ='';
$errors['telefon']  ='';


$member['email']   ='';
$member['imie']    ='';
$member['nazwisko']='';
$member['haslo']   ='';
$member['telefon']      ='';
$confirm='';


if($_SERVER['REQUEST_METHOD'] == 'POST') {

  
    $member['imie']       =$_POST['imie'];
    $member['nazwisko']       =$_POST['nazwisko'];
    $member['email']   =$_POST['email'];
    $member['telefon']      =$_POST['telefon'];
    $member['haslo']=   $_POST['haslo'];
    $confirm =   $_POST['potwierdz'];
  
      $errors['imie']  = is_text($member['imie'], 1, 40)
          ? '' : 'Imie musi miec od 1-40 znaków';
      $errors['nazwisko']  = is_text($member['nazwisko'], 1, 40)
          ? '' : 'Nazwisko musi miec od 1-40 znaków';
      $errors['telefon']  = is_text($member['telefon'], 6, 15)
          ? '' : 'Telefon musi miec od 6-15 znaków';
      $errors['haslo']  = is_text($member['haslo'], 1, 20)
          ? '' : 'Hasło musi miec od 1-20 znaków';
        $errors['potwierdz']    =($member['haslo']==$confirm) 
         ? '' : 'Hasła nie są identyczne';
        // $errors['potwierdz']  = is_text($confirm, 1, 20)
        //   ? '' : 'Hasło musi miec od 1-20 znaków';
      $errors['email']  = is_text($member['email'], 1, 40)
          ? '' : 'Email musi miec od 1-40 znaków';

          
  
      $invalid = implode($errors);
  
      if ($invalid) {                                              // If invalid
        $errors['warning'] = 'Popraw poniższe błędy';  // Store message
    } else {
  
      $sql="INSERT INTO member(imie,nazwisko,email,haslo,telefon,role)
      values (:imie,:nazwisko,:email,:haslo,:telefon,'member');";
    
      $arguments=$member;
  
      try{
        pdo($pdo,$sql,$arguments)  ;  
        header("Location: logowanie.php"); 
        exit();
      }catch(PDOException $e){
        throw $e;
      }
    }

  //   if (!$invalid) {                                         // If no errors
  //     $result = $cms->getMember()->create($member);        // Create member
  //     if ($result === false) {                             // If result is false
  //         $errors['email'] = 'Email address already used'; // Store a warning
  //     } else {                                             // Otherwise send to login
  //         redirect('logowanie.php', ['success' => 'Thanks for joining! Please log in.']); 
  //     }
  // }

  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Rejestracja</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
<div class="bodylogowanie">
  <br><br><br><br>
  <form action="rejestracja.php" method="POST" enctype="multipart/form-data"> 
  <br><br>
      <section class="formularz">
      <div class="ramka">
        <br>
        <h1>Rejestracja</h1> <br>


          <div class="form-group">
            <label for="title">  Imie: </label> <br>
            <input type="text" name="imie" id="imie" value="<?= html_escape($member['imie']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['imie'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Nazwisko: </label> <br>
            <input type="text" name="nazwisko" id="nazwisko" value="<?= html_escape($member['nazwisko']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['nazwisko'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  E-mail: </label> <br>
            <input type="text" name="email" id="email" value="<?= html_escape($member['email']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['email'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Nr telefonu: </label> <br>
            <input type="text" name="telefon" id="telefon" value="<?= html_escape($member['telefon']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['telefon'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Haslo: </label> <br>
            <input type="password" name="haslo" id="haslo" value="<?= html_escape($member['haslo']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['haslo'] ?></span>
          </div><br>

      

          <div class="form-group">
            <label for="title">  Powtorz haslo: </label> <br>
            <input type="password" name="potwierdz" id="potwierdz" value="<?= html_escape($confirm) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['potwierdz'] ?></span>
                
          </div><br><br>

        

          

          <div class="loginbutton">
          <input type="submit" name="update" class="btn" value="ZAREJESTRUJ SIĘ" class="btn btn-primary">
          <br><br>
          </div>
          <div class="utworz">
              <span >Masz juz konto?</span>
              <a href="logowanie.php">Zaloguj się</a>
          </div>
          <br>

          

          <br>
      
        </div>
      </section>
      <br>
  </form>
</div>      
</body>
</html>