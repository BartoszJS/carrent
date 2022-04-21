<?php
declare(strict_types = 1);                               // Use strict types
use PhpBook\Validate\Validate;                           // Import Validate class
include 'src/bootstrap.php';    
include 'includes/database-connection.php'; 
include 'includes/validate.php';
// include 'includes/functions.php';
// $rolesession = $_SESSION['role'] == 'member' ?? '';

$term  = filter_input(INPUT_GET, 'term');                 // Get search term
$show  = filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ?? 3; // Limit
$from  = filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ?? 0; // Offset
$count = 0;
$car=[];

if(!$term){
    $count = 0;
    $sqlicz="SELECT COUNT(id) from car where wypozyczony=0;";
    $count = pdo($pdo, $sqlicz)->fetchColumn();
    if($count>0){
        $arguments['show'] = $show;                     
        $arguments['from'] = $from;

        $sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
        FROM car
        where wypozyczony=0   
        order by id asc
        limit :show
        OFFSET :from;";
        $car = pdo($pdo,$sql, $arguments)->fetchAll();
    }
}




if($term){
    
    $arguments['term1'] ='%'. $term .'%'; 
    // $arguments['term2'] ='%'.$term.'%';            // three times as placeholders
    // $arguments['term3'] ='%'.$term.'%';


    $sql="SELECT COUNT(id) from car
    where wypozyczony=0
    and marka     like :term1;";

    $count = 0;
    
    $count = pdo($pdo, $sql, $arguments)->fetchColumn();


    if ($count > 0) {                                     // If articles match term
        $arguments['show'] = $show;                       // Add to array for pagination
        $arguments['from'] = $from; 

        $sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
            FROM car
            where wypozyczony=0   
            and marka like :term1
            order by id asc
            limit :show
            OFFSET :from;";
        
        $car = pdo($pdo, $sql, $arguments)->fetchAll();

    }
}


if ($count > $show) {                                     // If matches is more than show
    $total_pages  = ceil($count / $show);                 // Calculate total pages
    $current_page = ceil($from / $show) + 1;              // Calculate current page
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

      <div class="place">
    
    <br>
        <form action="oferty.php" method="get" class="form-search">
                <label for="search"><span> </span></label>
                <input type="text" name="term" 
                    id="search" placeholder="Wpisz marke:"  
                /><input type="submit" value="Szukaj" class="btnpage" />
                
        </form>

        

            <?php if ($term) { ?><p><b>Znaleziono:</b> <?= $count ?></p><?php } ?>
           <br>
    </div>


        
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
                        <p id="cena">Cena: <?= html_escape($pojedynczo['cena'])?>zł/24h</p> <br><br><br><br> 
                        <a href="wypozycz.php?id=<?= $pojedynczo['id'] ?>" class="btnwypo" >WYPOŻYCZ</a><br>
                        
                            
                            
                    </div>   
                        
                    
                    
                        <br>
                    </a>

                </div>
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
   
</body>
</html>