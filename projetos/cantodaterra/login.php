<!DOCTYPE html>
<html  >
<head>
  <!-- Site made with Mobirise Website Builder v4.10.0, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v4.10.0, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="login/assets/images/logo2.png" type="image/x-icon">
  <meta name="description" content="">
  
  <title>Canto da Terra - Login</title>
  <link rel="stylesheet" href="login/assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="login/assets/tether/tether.min.css">
  <link rel="stylesheet" href="login/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="login/assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="login/assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="login/assets/dropdown/css/style.css">
  <link rel="stylesheet" href="login/assets/theme/css/style.css">
  <link rel="stylesheet" href="login/assets/mobirise/css/mbr-additional.css" type="text/css">
  
  
  </style>
</head>
<body>
  <?php
      include("barra.inc"); 
    ?>
  <?php
    include("navbar.inc"); 
  ?>



<section class="mbr-section form1 cid-rqAdw0Cl05" id="form1-7">

    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">
                    Faça Login</h2>
                
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column col-lg-8" data-form-type="formoid">
                <!---Formbuilder Form--->
                <form action="login.php" method="POST" class="mbr-form form-with-styler">
                    <div class="row row-sm-offset">
                        
                        <div hidden="hidden" data-form-alert-danger="" class="alert alert-danger col-12">
                        </div>
                    </div>
                    <div class="dragArea row row-sm-offset">
                     
                        <div class="col-md-4  form-group" data-for="email">
                            
                            <input type="email" name="frm_login" data-form-field="Email" required="required" class="form-control display-7" placeholder="Insira seu email" id="frm_login" maxlength="50">
                        </div>
                        <div data-for="senha" class="col-md-4  form-group">
                            
                            <input type="password" name="frm_senha" data-form-field="senha" class="form-control display-7" placeholder="Insira sua senha" id="frm_senha">
                        </div>
                       
                        <div class="col-md-12 input-group-btn align-center"><button name="submit" value="Entrar" type="submit" class="btn btn-primary btn-form display-4">Entrar</button></div>
                        <?php
      if (isset($_POST["submit"]))
      {      
      require("conexao.php");
          mysqli_select_db($conn,"terra");

          $login=$_POST["frm_login"];
          $senha=md5($_POST["frm_senha"]);

          $query="SELECT * FROM usuario WHERE usu_email='$login' AND usu_senha='$senha'";
          $result=mysqli_query($conn,$query);
          if(($result))
          {
            $dados=mysqli_fetch_array($result);
            $nivel=$dados["usu_nivel"];
            $_SESSION["login"]=$login;
            $_SESSION["nivel"]=$nivel;
            print("<script>alert(\"Login realizado com sucesso. Bem vindo $login\")</script>");
            print("<meta http-equiv=\"refresh\" content=\"0;index.php\">");
          }
          else
          {
            print("<script>alert(\"Falha no login. Usuário ou senha inválidos.\")</script>");
            print("<meta http-equiv=\"refresh\" content=\"0\">");
          }
          }
        ?>
                    </div>
                </form><!---Formbuilder Form--->
            </div>
        </div>
    </div>
</section>


  <script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/popper/popper.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smoothscroll/smooth-scroll.js"></script>
  <script src="assets/dropdown/js/script.min.js"></script>
  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
  <script src="assets/theme/js/script.js"></script>
  
  
</body>
</html>