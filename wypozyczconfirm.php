<?php
            
            include 'src/bootstrap.php';    
            include 'src/database-connection.php'; 
            include 'src/validate.php';
            

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

                    <?php include 'includes/footer.php'; ?>                       
    </body>
    </html>