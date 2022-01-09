<?php
  session_start();
?>

  <meta charset="iso-8859-1">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v4.10.0, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/favicon-1024x1024.png" type="image/x-icon">
  <meta name="description" content="">
  
  <title>Canto da Terra - P�gina inicial</title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="stylesheet" href="assets/gallery/style.css">
  <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  
 <section class="menu cid-rqcC5n9p0U" once="menu" id="menu1-4">
    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm bg-color transparent">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                
                <span class="navbar-caption-wrap"><a class="navbar-caption text-white display-5" href="index.php">CANTO DA TERRA</a></span>
            </div>
        </div>

				<?php
				if (!isset($_SESSION["login"])) 
				{
				print("<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\"><div class=\"navbar-buttons mbr-section-btn\"><a class=\"btn btn-sm btn-primary display-4\" href=\"cadastro.php\">Registrar-se</a>");		
				print("<a class=\"btn btn-sm btn-warning display-4\" href=\"login.php\">Login</a></div></div>");
				}
				else
				{
				
				print("<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\"><div class=\"navbar-buttons mbr-section-btn\"><a class=\"btn btn-sm btn-primary display-4\" href=\"consulta_reserva.php\">Consultar reservas</a>");
				print("<a class=\"btn btn-sm btn-primary display-4\" href=\"reserva.php\">Faca sua reserva</a></div>");
				
                if (isset($_SESSION["login"]) 
					AND 
					$_SESSION["nivel"]==1)
				{
				print("<a class=\"btn btn-sm btn-warning display-4\" href=\"consulta_reserva.php\">Consulta de Reserva</a>");
				}
				print("<a class=\"btn btn-sm btn-warning display-4\" href=\"logout.php\">Sair</a></div>");			
				}

			?>
    </nav>
</section>