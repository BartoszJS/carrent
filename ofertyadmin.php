<?php
                         
include 'src/bootstrap.php';    


is_admin($session->role);  

$term  = filter_input(INPUT_GET, 'term');                 // Get search term
$show  = filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ?? 3; // Limit
$from  = filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ?? 0; // Offset
$count = 0;
$car=[];

if(!$term){
    $count = 0;
    $count = $cms->getCar()->countCars();
    if($count>0){
        $car = $cms->getCar()->getCars($show,$from);
    }
}



$rent = $cms->getRent()->getRentMember();



if($term){
    
    $arguments['term1'] ='%'. $term .'%'; 
    // $arguments['term2'] ='%'.$term.'%';            // three times as placeholders
    // $arguments['term3'] ='%'.$term.'%';


    $count = $cms->getCar()->countCarsTerm($term);
    if($count>0){
        $car = $cms->getCar()->getCarsTerm($show,$from,$term);

    }
}


if ($count > $show) {                                     // If matches is more than show
    $total_pages  = ceil($count / $show);                 // Calculate total pages
    $current_page = ceil($from / $show) + 1;              // Calculate current page
}


$cars=$car;
$cars['rented']='';



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Strona główna</title>
    <?php if (isset($_SESSION['role'])){ ?> 
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
      <div class="oferty" id="oferty">

      <div class="adminplace">
     
    <br>
        <form action="oferty.php" method="get" class="form-search">
                <label for="search"><span> </span></label>
                <input type="text" name="term" 
                    id="search" placeholder="Wpisz marke:"  
                /><input type="submit" value="Szukaj" class="btnpage" />
                <a href="dodaj.php" class="btndodaj" >DODAJ SAMOCHÓD</a><br>  
        </form>
       
        

            <?php if ($term) { ?><p><b>Znaleziono:</b> <?= $count ?></p><?php } ?>
           <br>
    </div>


        
        
    <?php foreach($car as $pojedynczo) { ?>  
                <?php $flaga=true; ?>
                <?php foreach($rent as $renty) { ?> 
                    

                    <?php $czas_wypozyczenia= $renty['czas_wypozyczenia'];?>
                    <?php $data_wypozyczenia= $renty['data_wypozyczenia'];?>
                    <?php $data= strtotime($renty['data_wypozyczenia']);?>

                    <?php $do=date("Y-m-d h:i:s",strtotime($data_wypozyczenia.' + '.$czas_wypozyczenia.' days'));?>

                    <?php $teraz= date("Y-m-d h:i:s");?>

                    <?php if((($renty['id_car']==$pojedynczo['id']))&&(($data_wypozyczenia<$teraz)&&($do>$teraz))){?>
                        <?php $flaga=false; ?>
                        <?php }?>
                        

                <?php }?>
                <?php if($flaga==true) {?>
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
                        <?= html_escape($pojedynczo['konie'])?> km</p> <br> 
                        <p>Skrzynia biegów: <?= html_escape($pojedynczo['skrzynia'])?></p> <br>
                        <p id="cena">Cena: <?= html_escape($pojedynczo['cena'])?>zł/24h</p> 
                            <a href="edytujadmin.php?id=<?= $pojedynczo['id'] ?>" class="btnedytuj" >EDYTUJ</a><br> <br>
                            <a href="usunadmin.php?id=<?= $pojedynczo['id'] ?>" class="btnusun" >USUŃ</a><br> <br>
                            <a href="wypozycz.php?id=<?= $pojedynczo['id'] ?>" class="btnwypo" >WYPOŻYCZ</a><br>
                            
                        </div>   
                            <br>
                        </a>
                        </div>
           
            <?php } else { ?>
                <div class="ramka">
                    <a href="car.php?id=<?= $pojedynczo['id'] ?>">
                    <div class="imie">  </div>
                    <div class="column">
                            <img class="image-resize" src="uploads/<?= html_escape($pojedynczo['image'] ?? 'blank.png') ?>">
                        </div> 
                    <div class="tekst">
                    <div class="imie">  
                    <p id="dostepnosc">Aktualnie niedostępny</p> <br><br><br>
                            <?= html_escape($pojedynczo['marka'])?>
                            <?= html_escape($pojedynczo['model'])?> 
                    </div> <br> 
                        <p>Rocznik: <?= html_escape($pojedynczo['rocznik'])?></p> <br><br>
                        <p>Silnik:    <?= html_escape($pojedynczo['silnik'])?>
                        <?= html_escape($pojedynczo['paliwo'])?>
                        <?= html_escape($pojedynczo['konie'])?> km</p> <br> 
                        <p>Skrzynia biegów: <?= html_escape($pojedynczo['skrzynia'])?></p> <br>
                        <p id="cena">Cena: <?= html_escape($pojedynczo['cena'])?>zł/24h</p> 
                            <a href="edytujadmin.php?id=<?= $pojedynczo['id'] ?>" class="btnedytuj" >EDYTUJ</a><br> <br>
                            <a href="usunadmin.php?id=<?= $pojedynczo['id'] ?>" class="btnusun" >USUŃ</a><br> <br>
                            <a href="wypozycz.php?id=<?= $pojedynczo['id'] ?>" class="btnwypo" >WYPOŻYCZ</a><br>
                            <a href="wypozycz.php?id=<?= $pojedynczo['id'] ?>" class="btnwypo" >SPRAWDZ TERMINY</a><br>
                            </a>
                        </div>   
                            
                      
                        </div>
                        
                    <?php } ?>
    <?php }?>


    <?php  if ($count > $show) { ?>
    <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
      <ul>
      <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <li>
          <a href="?term=<?= $term ?>&show=<?= $show ?>&from=<?= (($i - 1) * $show) ?>"
            class="btnpage <?= ($i == $current_page) ? 'active" aria-current="true' : '' ?>">
            <?= $i ?>
          </a>
        </li>
      <?php } ?>
      </ul>
    </nav>
    <?php } ?>
            
        </div>
<?php include 'includes/footer.php'; ?>   
</body>
</html>