<?php
            
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php';


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: nieznaleziono.php");  
    exit();                                         // If no valid id
}

$sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
    FROM car 
    where id=:id;";

$car = pdo($pdo, $sql, [$id])->fetch();    // Get article data
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

<div class="oferta">
    <div class="ramka">
                    
                    <div class="imie">  </div>
                    <div class="column">
                            <img class="image-resize" src="uploads/<?= html_escape($car['image'] ?? 'blank.png') ?>">
                        </div> 
                    <div class="tekst">
                    <div class="imie">  
                            <?= html_escape($car['marka'])?>
                            <?= html_escape($car['model'])?> 
                    </div> <br> 
                        <p>Rocznik: <?= html_escape($car['rocznik'])?></p> <br><br>
                        <p>Silnik:    <?= html_escape($car['silnik'])?>
                        <?= html_escape($car['paliwo'])?>
                        <?= html_escape($car['konie'])?> km</p> <br> <br>
                        <p>Skrzynia biegów: <?= html_escape($car['skrzynia'])?></p> <br><br>
                        <p id="cena">Cena: <?= html_escape($car['cena'])?>zł/24h</p> <br><br><br><br> <a href="wypozycz.php?id=<?= $car['id'] ?>" class="btnwypo" >WYPOŻYCZ</a><br>
                        
                            
                            
                    </div>   
    
    </div>

    <?php include 'includes/footer.php'; ?>  
</body>
</html>