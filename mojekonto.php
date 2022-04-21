<?php
declare(strict_types = 1);                               // Use strict types
use PhpBook\Validate\Validate;                           // Import Validate class
include 'src/bootstrap.php';    
include 'includes/database-connection.php'; 
include 'includes/validate.php';
// include 'includes/functions.php';
// $rolesession = $_SESSION['role'] == 'member' ?? '';


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: nieznaleziono.php");  
    exit();                                         // If no valid id
}

$sql="SELECT id,imie,nazwisko,email,telefon,data_dolaczenia,role
    FROM member 
    where id=:id;";

$member = pdo($pdo, $sql, [$id])->fetch();    // Get article data
if (!$member) {   
    header("Location: nieznaleziono.php");  
    exit();                              // Page not found
}

$sqlre="SELECT rent.id_car,rent.id_member,rent.data_wypozyczenia,rent.czas_wypozyczenia,
    member.id, car.marka, car.model, car.image,car.wypozyczony,car.cena
    FROM rent
    join member on rent.id_member = member.id
    left join car on rent.id_car = car.id
    where member.id = :id;";
    

$rent = pdo($pdo, $sqlre,[$id])->fetchAll();



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
       
         


        <div class="mojekonto">
            <div class="ramka">
                    <div class="imie">  
                    <?= "Dane klienta:" ?>
                     </div> 
                <div class="tekst1">   
                    <p>Imie:   <?= $member['imie'] ?></p> 
                    <p>Nazwisko:    <?= $member['nazwisko'] ?> 
                    <p>E-mail:    <?= $member['email'] ?> 
                    <p>Telefon:    <?= $member['telefon'] ?> 
                    <p>Data dołączenia:    <?= $member['data_dolaczenia'] ?> 
                </div> <br>
            </div>
            
        </div>
        <div class="mojekonto2">
            <div class="ramka">
                    <div class="imie">  
                        <?= "Wypożyczone samochody:" ?>
                     </div> 
                <div class="tekst1">
                   <?php if(!$rent) { ?> <p>Nie wypożyczono samochodu</p> <?php } ?>
                        <?php foreach($rent as $pojedynczo) { ?> 
                            <div class="onerent">
                                <p> <?= $pojedynczo['marka'] ?> <?= $pojedynczo['model'] ?><span class="price">
                                    Cena: <?= $pojedynczo['cena']*$pojedynczo['czas_wypozyczenia']?>zł</span></p> 
                                <p>Od:    <?= $pojedynczo['data_wypozyczenia'] ?> 
                                <?php $czas= $pojedynczo['czas_wypozyczenia']?>
                                <?php $data= $pojedynczo['data_wypozyczenia']?>
                                <?php $d=strtotime("+".$czas." days") ?>
                                <p>Do:    <?= date("Y-m-d h:i:s",strtotime($data.' +'.$czas.' days'))?> 
                            </div>
                            <?php } ?>
                </div> <br>
            </div>
            
        </div>
        <?php include 'includes/footer.php'; ?>   
</body>
</html>