<?php
            
include 'src/bootstrap.php';    

            

if($_SERVER['REQUEST_METHOD'] == 'POST') {


                $rent['id_car']=$_POST['id_car'];
                $rent['id_member']=$_POST['id_member'];
                $rent['data_wypozyczenia']=$_POST['data_wypozyczenia'];
                $rent['czas_wypozyczenia']=$_POST['czas_wypozyczenia']; 
                $arguments=$rent;
                $cms->getRent()->insertRent($arguments);

                
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
                    <div class="wypozyczono">
                        <h2>Pomyślnie wypożyczono</h2> <br>
                        <h3>Powrót do <a href="mojekonto.php?id=<?=$_SESSION['id']?>">Moje konto</a>, aby zobaczyc wypożyczenie</h3>
                    </div>
                    <?php include 'includes/footer.php'; ?>                       
    </body>
    </html>