<?php
include 'src/bootstrap.php';    
include 'includes/database-connection.php'; 
include 'includes/validate.php';

$upload_path = dirname(__FILE__).DIRECTORY_SEPARATOR. 'uploads'.DIRECTORY_SEPARATOR;

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


$car['marka']='';
$car['model']='';
$car['rocznik']='';
$car['silnik']='';
$car['paliwo']='';
$car['konie']='';
$car['skrzynia']='';
$car['cena']='';
$car['liczba_miejsc']='';
$car['image']='';


if($_SERVER['REQUEST_METHOD'] == 'POST') {


    $car['marka']=$_POST['marka'];
    $car['model']=$_POST['model'];
    $car['rocznik']=$_POST['rocznik'];
    $car['silnik']=$_POST['silnik'];
    $car['paliwo']=$_POST['paliwo'];
    $car['konie']=$_POST['konie'];
    $car['skrzynia']=$_POST['skrzynia'];
    $car['cena']=$_POST['cena'];
    $car['liczba_miejsc']=$_POST['liczba_miejsc'];

  
    $temp = $_FILES['image']['tmp_name'];
    $path = 'uploads/' . $_FILES['image']['name'];
    $moved = move_uploaded_file($temp, $path);
    $car['image']    =$_FILES['image']['name'];
  
          
  
  
    $sql="INSERT INTO car(marka,model,rocznik,silnik,paliwo,konie,skrzynia,cena,liczba_miejsc,wypozyczony,image)
    values            (:marka,:model,:rocznik,:silnik,:paliwo,:konie,:skrzynia,:cena,:liczba_miejsc,0,:image);";
  
    $arguments=$car;

    try{
      pdo($pdo,$sql,$arguments)  ;  
      $lastcar=$pdo->lastInsertId();
      header("Location: car.php?id=".$lastcar); 
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
    <title>Rejestracja</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
<div class="bodylogowanie">
  <br><br><br><br>
  <form action="dodaj.php" method="POST" enctype="multipart/form-data"> 
  <br><br>
      <section class="formularz">
      <div class="ramka">
        <br>
        <h1>Dodawanie samochodu</h1> <br>

        <label for="image">Dodaj zdjęcie samochodu:</label>
            <div class="form-group image-placeholder">
              <input type="file" name="image" class="form-control-file" id="image"
              accept="image/jpeg,image/jpg,image/png"><br>
              <span class="errors"><?= $errors['image'] ?></span>
            </div><br>


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
          <input type="submit" name="update" class="btndodaj" value="DODAJ SAMOCHÓD" class="btn btn-primary">
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