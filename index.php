<?php
declare(strict_types = 1);                               // Use strict types
use PhpBook\Validate\Validate;                           // Import Validate class
include 'src/bootstrap.php';    
include 'includes/database-connection.php'; 
include 'includes/validate.php';
// include 'includes/functions.php';
// $rolesession = $_SESSION['role'] == 'member' ?? '';


$sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
    FROM car
    where wypozyczony=0   
    order by id asc
    limit 5;";
$car = pdo($pdo,$sql)->fetchAll();




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
       
            <div class="banner-area">
                <div class="content-area">
                    <div class="content">
                        <a href="#index" class="btnzobacz" >ZOBACZ WIĘCEJ</a>
                    </div>
                </div>
            </div>


        <div class="index" id="index">
            <?php foreach($car as $pojedynczo) { ?> 
                <div class="ramka">
                    <a href="car.php?id=<?= $pojedynczo['id'] ?>">
                    <div class="imie">  </div>
                    <div class="column">
                            <img class="image-resize" src="uploads/<?= html_escape($pojedynczo['image'] ?? 'blank.png') ?>">
                        </div> 
                    <div class="tekst">
                    <div class="imie">  
                            <?= html_escape($pojedynczo['marka'])?>
                            <?= html_escape($pojedynczo['model'])?> 
                    </div> <br> 
                        <p>Rocznik: <?= html_escape($pojedynczo['rocznik'])?></p> <br><br>
                        <p>Silnik:    <?= html_escape($pojedynczo['silnik'])?>
                        <?= html_escape($pojedynczo['paliwo'])?>
                        <?= html_escape($pojedynczo['konie'])?> km</p> <br> <br>
                        <p>Skrzynia biegów: <?= html_escape($pojedynczo['skrzynia'])?></p> <br><br>
                        <p id="cena">Cena: <?= html_escape($pojedynczo['cena'])?>zł/24h</p> <br><br><br><br> <a href="car.php?id=<?= $pojedynczo['id'] ?>" class="btnwypo" >WYPOŻYCZ</a><br>
                        
                            
                            
                    </div>   
                        
                    
                    
                        <br>
                    </a>

                </div>
    <?php }?>
            
        </div>
   
</body>
</html>