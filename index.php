<?php          
include 'src/bootstrap.php';    



$car = $cms->getCar()->indexCar();


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
                        <p id="cena">Cena: <?= html_escape($pojedynczo['cena'])?>zł/24h</p> <br><br><br><br> <a href="wypozycz.php?id=<?= $pojedynczo['id'] ?>" class="btnwypo" >WYPOŻYCZ</a><br>
                        
                            
                            
                    </div> 
                   
                        
                    
                    
                        <br>
                    </a>

                </div>
    <?php }?>
    <div class="przerwaa"></div>
    <a href="oferty.php" class="btnwypo" >PEŁNA OFERTA</a><br>  
            
        </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>