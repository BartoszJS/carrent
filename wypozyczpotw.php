<?php
            
include 'src/bootstrap.php';    

if($_SERVER['REQUEST_METHOD'] == 'POST') {


    $rent['id_car']=$_POST['id_car'];
    $rent['id_member']=$_POST['id_member'];
    $rent['data_wypozyczenia']=$_POST['data_wypozyczenia'];
    $rent['czas_wypozyczenia']=$_POST['czas_wypozyczenia']; 
    

    
}            
            



is_member($session->role);  


$id=$rent['id_car'];
$car = $cms->getCar()->getCar($id);    // Get article data
if (!$car) {   
    header("Location: nieznaleziono.php");  
    exit();                              // Page not found
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
    

    <div class="wypozycz">
       
        <div class="ramka">
            <div class="column">
                <img class="image-resize" src="uploads/<?= html_escape($car['image'] ?? 'blank.png') ?>">
            </div> 
            <h2>Potwierdzenie wypożyczenia</h2>
            <div class="imie">  
                <?= "Dane klienta" ?>
            </div> 
            <div class="tekst1">   
                <p>Imie:   <?= $_SESSION['imie'] ?></p> 
                <p>Nazwisko:    <?= $_SESSION['nazwisko'] ?> 
            </div>
            <div class="tekst2">
                <p>E-mail:    <?= $_SESSION['email'] ?> 
                <p>Telefon:    <?= $_SESSION['telefon'] ?> 
            </div> <br>
            <div class="imie">  
                    <?= html_escape($car['marka'])?>
                    <?= html_escape($car['model'])?> 
            </div> 
            
            <div class="tekst">
                 
                    <p>Rocznik: <?= html_escape($car['rocznik'])?></p> 
                    <p>Silnik:    <?= html_escape($car['silnik'])?>
                    <?= html_escape($car['paliwo'])?>
                    <p>Liczba koni mechanicznych: <?= html_escape($car['konie'])?> km</p> 
                    <p>Skrzynia biegów: <?= html_escape($car['skrzynia'])?></p> 
                    <p>Liczba miejsc: <?= html_escape($car['liczba_miejsc'])?></p> 
                    <p id="cena">Cena: <?= html_escape($car['cena'])?>zł/24h</p> 
                    
                        
                            
                            
            </div>   
<form action="wypozyczconfirm.php" method="POST" enctype="multipart/form-data"> 
                    <input type="hidden" name="id_car" value="<?= $car['id'] ?>" > 
                    <input type="hidden" name="id_member" value="<?= $_SESSION['id'] ?>" > 
                    <input type="hidden" name="data_wypozyczenia" value="<?= $rent['data_wypozyczenia'] ?>" > 
                    <input type="hidden" name="czas_wypozyczenia" value="<?= $rent['czas_wypozyczenia'] ?>" > 
                <div class="forms">
                    <!-- <label for="start">  Od kiedy: </label> <br>
                    <input type="date" name="start" id="start" value="" class="form-control">
                    <label for="start">Start date:</label> -->
                    <label for="start">  Data wypożyczenia: <?= $rent['data_wypozyczenia'] ?></label><br><br>
                    
                        
                    <label for="dni">  Czas wypożyczenia: <?=  $rent['czas_wypozyczenia']?></label> 
                    
                    
                    

                </div>
                <input type="submit" name="update" class="btnpotw" value="POTWIERDZ WYPOŻYCZENIE"><br>  
        </div>   
</form>             
    </div>
   


    <?php include 'includes/footer.php'; ?>  
    </body>
    </html>