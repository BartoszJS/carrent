<?php
declare(strict_types = 1);                               // Use strict types
use PhpBook\Validate\Validate;                           // Import Validate class
include 'src/bootstrap.php';    
include 'includes/database-connection.php'; 
include 'includes/validate.php';
// include 'includes/functions.php';
// $rolesession = $_SESSION['role'] == 'member' ?? '';




$sql="SELECT id,imie,nazwisko,email,telefon,data_dolaczenia,role
    FROM member ;";

$member = pdo($pdo, $sql)->fetchAll();    // Get article data






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Strona główna</title>
    <?php if (isset($_SESSION['id'])){ ?> 
    <?php if($_SESSION['role'] == 'member'){ ?>
    <?php include 'includes/headermember.php'; ?>
    <?php }elseif($_SESSION['role'] == 'admin'){ ?>
    <?php include 'includes/headeradmin.php'; ?>
    <?php }}else{ ?> 
    <?php include 'includes/header.php'; ?>    
    <?php }?>
    

</head>
<body>
      <!-- <div class="indexborder">
  
        <img src="img/car1.jpg" class="indeximage" alt="">
        <br><br><br><br><br>
      -->
       
         


        <div class="klienci">
            <div class="ramka">
                <div class="imie">  
                    <?= "Zajerestrowane konta:" ?>
                </div>         <br>
                    <?php foreach($member as $czlonek) { ?> 
                        <a href="klient.php?id=<?= $czlonek['id'] ?>">
                        <div class="rama">
                            <div class="calytekst">
                                <div class="tekst1">  
                                    <p>  Id: <?= $czlonek['id'] ?>    </p>       
                                    <p>  <?= $czlonek['imie'] ?>   <?= $czlonek['nazwisko'] ?> </p> 
                                      <?php if($czlonek['role']=='member'){?> 
                                        <p>Klient</p> 
                                        <?php }elseif($czlonek['role']=='admin'){?>
                                        <p>Admin</p> 
                                        <?php }else{?>
                                            <p>Nieznany</p> 
                                        <?php } ?>
                                    
                                </div>    
                                <div class="tekst2">
                                    <p>E-mail:    <?= $czlonek['email'] ?> 
                                    <p>Telefon:    <?= $czlonek['telefon'] ?> 
                                    <p>Data dołączenia:    <?= $czlonek['data_dolaczenia'] ?> 
                                </div>    
                            </div>     
                        </div>  
                        </a>  
                        <br><br><br>
                    <?php } ?>
                
            </div>
        </div>
    
        <?php include 'includes/footer.php'; ?>  
</body>
</html>