<?php
declare(strict_types = 1);                               // Use strict types
use PhpBook\Validate\Validate;                           // Import Validate class
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php';


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
    <div class="box">
        <div class="ramka">
            <h1>Kontakt</h1>
            <p>Dane firmy: </p>
            <p>CarRent</p>
            <p>99-999 Warszawa</p>
            <p>ul. Porcelanowa 39a</p>
            <br>
            <h1>Dział obsługi klienta:</h1>
            <p>e-mail: carrent@car.pl</p>
            <p>telefon: 677-777-777</p>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>   
</body>
</html>