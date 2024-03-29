<?php                      
include 'src/bootstrap.php';    

$errors =[];



// $errors['email']    ='';
// $errors['haslo']    ='';
$email='';


$member['email']    ='';
$member['haslo']    ='';
$errors['email']    ='';
$errors['imie']     ='';
$errors['nazwisko'] ='';
$errors['haslo']    ='';
$errors['potwierdz']    ='';
$errors['telefon']  ='';
$errors['message']  ='';

$success = $_GET['success'] ?? null;

if($_SERVER['REQUEST_METHOD']=='POST'){
  
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];


          $invalid = implode($errors);
          

    if($invalid){
      $_SESSION['id'] = 0;
      $errors['message']='Sprobuj ponownie';
    }else{
      $member = $cms->getMember()->login($email, $haslo); // Get member details
      if ($member) {                                   // Otherwise for members
          $cms->getSession()->create($member);               // Create session
          //redirect('member.php', ['id' => $member['id'],]);
          redirect('../logowanie.php');  // Redirect to their page
      } else {                                               // Otherwise
          $errors['message'] = 'Please try again.';   
          $_SESSION['id'] = 0   ;   // Store error message
      }
    }
}

$data['success']    = $success;                              // Success message
$data['email']      = $email;                                // Email address if login failed
$data['errors']     = $errors;  

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Logowanie</title>
    <?php if (isset($_SESSION['id'])){ ?> 
    <?php if($_SESSION['role'] == 'member'){ ?>
    <?php include 'includes/headermember.php'; ?>
    <?php }elseif($_SESSION['role'] == 'admin'){ ?>
    <?php include 'includes/headeradmin.php'; ?>
    <?php }}else{ ?> 
    <?php include 'includes/header.php'; ?>    
    <?php }?>
</head>
<body >
<div class="bodylogowanie">

<?php /* 
<a class="skip-link" href="#content">Skip to content</a>
      <nav class="member-menu">
        <div class="container">
        <?php if ($_SESSION['id'] == 0) { ?>
            <a href="login.php" class="nav-item nav-link">Log in</a> /
            <a href="register.php" class="nav-item nav-link">Register</a>
            <?php } else {  ?>
            <a href="member.php?id=<?php $_SESSION['id'] ?>"><?php $_SESSION['imie'] ?></a> /
            <?php if ($_SESSION['role'] == 'admin') { ?>
              <a href="admin/index.php">Admin</a> /
              <?php }?>
            <a href="logout.php">Logout</a>
            <?php }?>
        </div>
      </nav>

*/?>

<br><br><br><br> <br>
<br><br>
<?php /* 
              <h1><?= $_SESSION['id'] ?></h1>
              <h1><?= $errors['message'] ?></h1>
              <a href="logout.php">Logout</a>
*/?>
            <div class="nieznaleziono">
              <?php if (isset($_SESSION['id'])){ ?> 
                <h1>Zalogowano</h1>
              <?= $_SESSION['id'] ?>
              <?= $_SESSION['role'] ?>
              <h3><a href="logout.php">Logout</a></h3>
              <?php } else {  ?>
              <br><h1>Proszę się zalogować</h1>
              <?php }?>
            </div>

<form action="logowanie.php" method="POST" enctype="multipart/form-data"> 
<br><br>
    <section class="formularz">
    <div class="ramka">
      <br>
      <h1>Logowanie</h1> <br>
<br>

        <div class="form-group">
          <label for="title">  E-mail: </label> <br>
          <input type="text" name="email" id="email" value=""
                 class="form-control">
                 <span class="errors"><?= $errors['email'] ?></span>
        </div><br>

        <div class="form-group">
          <label for="title">  Haslo: </label> <br>
          <input type="password" name="haslo" id="haslo" value=""
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
      
     
      </div>
    </section>
    <br>
</form>
<br>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>