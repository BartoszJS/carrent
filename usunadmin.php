<?php
            
include 'src/bootstrap.php';    
include 'includes/database-connection.php'; 
include 'includes/validate.php';
            
            
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: nieznaleziono.php");  
    exit();                                         // If no valid id
}


is_admin($session->role);  


if($_SERVER['REQUEST_METHOD'] == 'POST') {

$sqlre="DELETE FROM rent where id_car=:id;";
$car = pdo($pdo, $sqlre, [$id])->fetch(); 

$sql="DELETE FROM car where id=:id;";

$car = pdo($pdo, $sql, [$id])->fetch();    // Get article data
if (!$car) {   
    header("Location: index.php");  
    exit();                              // Page not found
}



}


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



    <form action="usunadmin.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data"> 
    <br><br>
      <section class="formularz">
      <div class="ramka">
        <br><br><br><br>
        <h1>Usunąć samochód?:</h1> <br>
          <div class="loginbutton">
          <input type="submit" name="update" class="btndodaj" value="USUŃ" class="btn btn-primary">
          <a href="ofertyadmin.php" class="btndodaj">ANULUJ</a>
          <br><br>
          </div>
      
        </div>
      </section>
      <br>
  </form>
    
    </head>
    <body>
    
