<?php
            
            include 'src/bootstrap.php';    
            include 'includes/database-connection.php'; 
            include 'includes/validate.php';
            
            
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
            if (!$id) {     
                header("Location: nieznaleziono.php");  
                exit();                                         // If no valid id
            }


is_member($session->role);  

$sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
    FROM car 
    where id=:id;";

$car = pdo($pdo, $sql, [$id])->fetch();    // Get article data
if (!$car) {   
    header("Location: nieznaleziono.php");  
    exit();                              // Page not found
}
$countid="SELECT id from car where id=:id;";

if($_SERVER['REQUEST_METHOD'] == 'POST') {


$rent['id_car']=$_POST['id_car'];
$rent['id_member']=$_POST['id_member'];
$rent['data_wypozyczenia']=$_POST['data_wypozyczenia'];
$rent['czas_wypozyczenia']=$_POST['czas_wypozyczenia'];

$sqlrent="INSERT INTO rent(id_car,id_member,data_wypozyczenia,czas_wypozyczenia)
values(:id_car,:id_member,:data_wypozyczenia,:czas_wypozyczenia);";

$arguments=$rent;

try{
    pdo($pdo,$sqlrent,$arguments)  ;  
    header("Location: index.php"); 
    exit();
  }catch(PDOException $e){
    throw $e;
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
    

    <div class="wypozycz">
        <div class="ramka">
            <div class="column">
                <img class="image-resize" src="uploads/<?= html_escape($car['image'] ?? 'blank.png') ?>">
            </div> 
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
                    <input type="text" name="id_car" value="<?= $car['id'] ?>" placeholder="<?= $car['id'] ?>"> 
                    <input type="text" name="id_member" value="<?= $_SESSION['id'] ?>" placeholder="<?= $_SESSION['id'] ?> "> 
                        
                            
                            
            </div>   
<form action="wypozycz.php" method="POST" enctype="multipart/form-data"> 
                <div class="forms">
                    <!-- <label for="start">  Od kiedy: </label> <br>
                    <input type="date" name="start" id="start" value="" class="form-control">
                    <label for="start">Start date:</label> -->
                    <label for="start">  Data wypożyczenia: </label>
                    <?php  $d=strtotime("+12 Months");?>
                    <input type="date" id="start" name="data_wypozyczenia"
                        value="<?php date("Y-m-d h:i:sa") ?>"
                        min="<?php date("Y-m-d h:i:sa") ?>" max="<?php date("Y-m-d h:i:sa", $d) ?>" > <br><br>

                        
                    <label for="dni">  Czas wypożyczenia: </label> 
                    <input type="text" name="czas_wypozyczenia" id="dni" placeholder="Podaj liczbe dni:"  class="form-con">
                    
                    

                </div>
                <input type="submit" name="update" class="btnpotw" value="POTWIERDZ WYPOŻYCZENIE"><br>  
        </div>   
</form>             
    </div>
   


   
    </body>
    </html>