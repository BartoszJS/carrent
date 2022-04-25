<?php
declare(strict_types = 1);                                         // Use strict types
include 'src/database-connection.php';                     // Database connection
include 'src/functions.php';                               // Functions
include 'src/validate.php';



$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: nieznaleziono.php");  
    exit();                                         // If no valid id
}

$errors['marka']='';
$errors['model']='';
$errors['rocznik']='';
$errors['silnik']='';
$errors['paliwo']='';
$errors['konie']='';
$errors['skrzynia']='';
$errors['cena']='';
$errors['liczba_miejsc']='';
$errors['image']='';


$car['id']=$id;
$car['marka']='';
$car['model']='';
$car['rocznik']='';
$car['silnik']='';
$car['paliwo']='';
$car['konie']='';
$car['skrzynia']='';
$car['cena']='';
$car['liczba_miejsc']='';
$car['wypozyczony']=0;
$car['image']='';
$car['kiedy_dodany']='';

// $car['image']='';

$sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
    FROM car 
    where id=:id;";

$car = pdo($pdo, $sql, [$id])->fetch();    // Get article data
if (!$car) {   
    header("Location: nieznaleziono.php");  
    exit();                              // Page not found
}


if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $car['id']=$_POST['id'];
    $car['marka']=$_POST['marka'];
    $car['model']=$_POST['model'];
    $car['rocznik']=$_POST['rocznik'];
    $car['silnik']=$_POST['silnik'];
    $car['paliwo']=$_POST['paliwo'];
    $car['konie']=$_POST['konie'];
    $car['skrzynia']=$_POST['skrzynia'];
    $car['cena']=$_POST['cena'];
    $car['liczba_miejsc']=$_POST['liczba_miejsc'];
    $car['wypozyczony']=$_POST['wypozyczony'];
    $car['image']=$_POST['image'];;
    $car['kiedy_dodany']=$_POST['kiedy_dodany'];;  

  
    $arguments=$car;    
  
  
    $sql="UPDATE car 
          set marka=:marka,model=:model,rocznik=:rocznik,silnik=:silnik,
          paliwo=:paliwo,konie=:konie,
          skrzynia=:skrzynia,cena=:cena,liczba_miejsc=:liczba_miejsc,
          wypozyczony=:wypozyczony,image=:image,kiedy_dodany=:kiedy_dodany
          where id=:id;";
   

    try{       
      pdo($pdo,$sql,$arguments);  
      header("Location: car.php?id=".$id); 
      exit();
    }catch(PDOException $e){
      $pdo->rollBack();   
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
    <title>Rejestracja</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
<div class="bodylogowanie">
  <br><br><br><br>
  <form action="edytujadmin.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data"> 
  <br><br>
      <section class="formularz">
      <div class="ramka">
        <br>
        <h1>Edycja samochodu:</h1> <br>

        <!-- <label for="image">Dodaj zdjęcie samochodu:</label>
            <div class="form-group image-placeholder">
              <input type="file" name="image" class="form-control-file" id="image"
              accept="image/jpeg,image/jpg,image/png"><br>
              <span class="errors"><?= $errors['image'] ?></span>
            </div><br> -->
            <input type="hidden" name="id" id="id" value="<?= html_escape($car['id']) ?>"
                  class="form-control">
            <input type="hidden" name="wypozyczony" id="wypozyczony" value="<?= html_escape($car['wypozyczony']) ?>"
                  class="form-control">
            <input type="hidden" name="image" id="image" value="<?= html_escape($car['image']) ?>"
                  class="form-control">
            <input type="hidden" name="kiedy_dodany" id="kiedy_dodany" value="<?= html_escape($car['kiedy_dodany']) ?>"
                  class="form-control">

          <div class="form-group">
            <label for="title">  Marka: </label> <br>
            <input type="text" name="marka" id="marka" value="<?= html_escape($car['marka']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['marka'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Model: </label> <br>
            <input type="text" name="model" id="model" value="<?= html_escape($car['model']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['model'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Rocznik: </label> <br>
            <input type="text" name="rocznik" id="rocznik" value="<?= html_escape($car['rocznik']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['rocznik'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Silnik: </label> <br>
            <input type="text" name="silnik" id="silnik" value="<?= html_escape($car['silnik']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['silnik'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Paliwo: </label> <br>
            <input type="text" name="paliwo" id="paliwo" value="<?= html_escape($car['paliwo']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['paliwo'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Liczba koni mechanicznych:: </label> <br>
            <input type="text" name="konie" id="konie" value="<?= html_escape($car['konie']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['konie'] ?></span>
          </div><br>

          <div class="form-group">
            <label for="title">  Rodzaj skrzyni biegów: </label> <br>
            <input type="text" name="skrzynia" id="skrzynia" value="<?= html_escape($car['skrzynia']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['skrzynia'] ?></span>
          </div><br>
          <div class="form-group">
            <label for="title">  Cena za 24h użytkowania: </label> <br>
            <input type="text" name="cena" id="cena" value="<?= html_escape($car['cena']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['cena'] ?></span>
          </div><br>
          <div class="form-group">
            <label for="title">  Liczba miejsc: </label> <br>
            <input type="text" name="liczba_miejsc" id="liczba_miejsc" value="<?= html_escape($car['liczba_miejsc']) ?>"
                  class="form-control">
                  <span class="errors"><?= $errors['liczba_miejsc'] ?></span>
          </div><br>

          
          <div class="loginbutton">
          <input type="submit" name="update" class="btndodaj" value="EDYTUJ SAMOCHÓD" class="btn btn-primary">
          <br><br>
          </div>
      
        </div>
      </section>
      <br>
  </form>
</div>  
<?php include 'includes/footer.php'; ?>    
</body>
</html>