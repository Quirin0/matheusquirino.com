<!DOCTYPE html>
<html>
<head>
  <!--<meta charset="utf-8">-->
	<meta charset="iso-8859-1">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<link rel="icon" type="image/png" href="img/icone.png">

  <title>Canto da Terra - Reserva</title>
  <link rel="stylesheet" href="reserva/assets/tether/tether.min.css">
  <link rel="stylesheet" href="reserva/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="reserva/assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="reserva/assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="reserva/assets/theme/css/style.css">
  <link rel="stylesheet" href="reserva/assets/mobirise/css/mbr-additional.css" type="text/css">
  <meta charset="iso-8859-1">
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v4.10.0, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="register/assets/images/logo2.png" type="image/x-icon">
  <meta name="description" content="">
  <style>
   .body{
      background:white;
    }
    .arial {
      font-family:arial;
    }
    .topo {
      padding-top:80px;
    }
  </style>
</head>

<body class="body">
        <?php
          include("barra.inc"); 
        ?>
        <?php
          include("navbar.inc"); 
        ?>

<div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2 topo">Consulte as reservas ja feitas!</h2>
                
            </div>
        </div>
	
	<?php
       require("conexao.php");
       mysqli_select_db($conn,"terra");

       $query="SELECT reserva.*,usuario.usu_nome,usu_tel FROM reserva INNER JOIN usuario ON reserva.usu_email=usuario.usu_email";
       $result=mysqli_query($conn,$query);
       while ($dados=mysqli_fetch_array($result))
       {
       $id=$dados["res_id"];
       $local=$dados["res_local"];
       $email=$dados["usu_email"];
       $data=$dados["res_data"];
       $msg=$dados["res_msg"];
       $nome=$dados["usu_nome"];
       $tel=$dados["usu_tel"];       

       print("<p class=\"arial\"><b>Identificacao: $id</b></br> <b>Nome da pessoa:</b> $nome</br><b>Telefone:</b> $tel<br><b>Local reservado:</b> $local</br><b>Email do Usuario:</b> $email</br><b>Data reservada:</b> $data</br><b>Mensagem do Usuario:</b></br> $msg</br></br></p><hr>");	
       }
	?>		
	</div>
</body>
</html>