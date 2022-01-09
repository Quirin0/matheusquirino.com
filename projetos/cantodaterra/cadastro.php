<!DOCTYPE html>
<html>
<head>
	<meta charset="iso-8859-1">
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v4.10.0, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="register/assets/images/logo2.png" type="image/x-icon">
  <meta name="description" content="">
  
  <title>Canto da Terra - Reservar</title>
  <link rel="stylesheet" href="register/assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="register/assets/tether/tether.min.css">
  <link rel="stylesheet" href="register/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="register/assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="register/assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="register/assets/dropdown/css/style.css">
  <link rel="stylesheet" href="register/assets/theme/css/style.css">
  <link rel="stylesheet" href="register/assets/mobirise/css/mbr-additional.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<link rel="icon" type="image/png" href="img/icone.png">
	<title>Canto da Terra</title>
</head>

<body>
  <?php
    include("barra.inc"); 
  ?>
	<?php
	  include("navbar.inc"); 
	?>

  <section class="engine"><a href="#">free web maker</a></section><section class="mbr-section form4 cid-rqovr5d62r" id="form4-4">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="google-map"><iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCy9r70T3NYf3PhvVflTo0_zdif2_IoIYs&amp;q=place_id:Ek5SLiBQYWRyZSBFc3RldsOjbyBNYXJpYSwgOTUgLSBTYW50YW5hLCBQaW5kYW1vbmhhbmdhYmEgLSBTUCwgMTI0MDMtMjgwLCBCcmF6aWwiGhIYChQKEgl5luZt4O_MlBHJkbWTqk95JhBf" allowfullscreen=""></iframe></div>
            </div>
            <div class="col-md-6">
                <h2 class="pb-3 align-left mbr-fonts-style display-2">Cadastre-se para reservar seu evento</h2>
                <div>
                    <div class="icon-block pb-3 align-left">
                        
                        
                    </div>
                    <div class="icon-contacts pb-3">
                        <h5 class="align-left mbr-fonts-style display-7">Ou nos contacte via:</h5>
                        <p class="mbr-text align-left mbr-fonts-style display-7">
                            Telefone: +55 (12) 99175-0444<br>
                            E-mail: anasilviachalita@hotmail.com
                        </p>
                    </div>
                </div>
                <div data-form-type="formoid">
                    
                    <form action="cadastro.php" enctype="multipart/form-data" method="POST" class="mbr-form form-with-styler">
                        <div class="row">
                            
                            <div hidden="hidden" data-form-alert-danger="" class="alert alert-danger col-12">
                            </div>
                        </div>
                        <div class="dragArea row">
                            <div class="col-md-6  form-group" data-for="name">
                                <input type="text" name="frm_nome" placeholder="Seu nome" data-form-field="Name" required="required" class="form-control input display-7" id="frm_nome" maxlength="100">
                            </div>
                            <div class="col-md-6  form-group" data-for="phone">
                                <input type="text" name="frm_tel" placeholder="Telefone" data-form-field="Phone" required="required" class="form-control input display-7" id="frm_tel">
                            </div>
                            <div data-for="email" class="col-md-12  form-group">
                                <input type="text" name="frm_email" placeholder="E-mail" data-form-field="Email" class="form-control input display-7" required="required" id="frm_email" maxlength="50">
                            </div>
                            <div data-for="email" class="col-md-12  form-group">
                                <input type="password" name="frm_senha" placeholder="Senha" data-form-field="Senha" class="form-control input display-7" required="required" id="frm_senha" maxlength="50">
                            </div>
                            <div class="col-md-12 input-group-btn  mt-2 align-center"><button type="submit" class="btn btn-form btn-primary display-4" href="register.php" name="submit" id="submit">Cadastrar</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
  if (isset($_POST["submit"]))
  {
  require("conexao.php");
  mysqli_select_db($conn,"terra");

  $nome=$_POST["frm_nome"];
  $email=$_POST["frm_email"];
  $senha=md5($_POST["frm_senha"]);
  $tel=$_POST["frm_tel"];
  $nivel=2;

  $query="INSERT INTO usuario(
  usu_email,
  usu_nome,
  usu_senha,
  usu_tel,
  usu_nivel
  )
  values
  (
  '$email',
  '$nome',  
  '$senha',
  '$tel',
  '$nivel'
   )";

   $result = mysqli_query($conn,$query);

  if($result == 1)
   {
    print("<script>alert(\"Usuario cadastro com sucesso.\")</script>");
    print("<meta http-equiv=\"refresh\" content=\"0\">");
   }
   else
   {
    print("<script>alert(\"Ocorreu um erro ao tentar cadastrar.\")</script>");
   } 

   }
?>