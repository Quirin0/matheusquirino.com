<!DOCTYPE html>
<html  >
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="reserva/assets/images/logo4.png" type="image/x-icon">
  <meta name="description" content="">
  
  <title>Canto da Terra - Reserva</title>
  <link rel="stylesheet" href="reserva/assets/tether/tether.min.css">
  <link rel="stylesheet" href="reserva/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="reserva/assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="reserva/assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="reserva/assets/theme/css/style.css">
  <link rel="stylesheet" href="reserva/assets/mobirise/css/mbr-additional.css" type="text/css">
  
  <style>
      .select{
          border-radius:3px;
          border:1px solid black;
          padding: 2.5px;
          outline: 0;
          background-color: #dddcdc;
      }
      textarea{
        border: 1px solid black;
      }
  </style>
  
</head>
<body>
        <?php 
          include("barra.inc");
          include("navbar.inc");
        ?>
    
  <section class="mbr-section form1 cid-rqX5MSzb2N" id="form1-3">

    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">Faça sua reserva</h2>
                
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column col-lg-8" data-form-type="formoid">
                <!---Formbuilder Form--->
                <form action="reserva.php" method="POST" class="mbr-form form-with-styler">
                    <div class="row row-sm-offset">
                        
                        <div hidden="hidden" data-form-alert-danger="" class="alert alert-danger col-12">
                        </div>
                    </div>
                    <div class="dragArea row row-sm-offset justify-content-center">
                        <div class="col-md-4  form-group" data-for="name">
                        <label for="frm_local"  class="form-control-label mbr-fonts-style display-7">Local:</label><br>
                             <select name="frm_local" id="frm_local" class="select" required>
                                <option>Cachoeira Paulista</option>
                                <option>Pindamonhangaba</option>
                            </select>
                        </div>
                        <div class="col-md-4  form-group" data-for="name">
                        <label for="frm_data"  class="form-control-label mbr-fonts-style display-7">Data:</label><br>
			                <input type="date" name="frm_data" id="frm_data" class="select" maxlength="50" required>
                        </div>

                        <div data-for="message" class="col-md-12 form-group">
                        <label for="frm_msg" class="form-control-label mbr-fonts-style display-7">Mensagem:</label>
                        <textarea name="frm_msg" data-form-field="Message" id="frm_msg" placeholder="(Diga como será sua festa ou deixe observações importantes...)" class="form-control display-7" maxlength="400" style="border:  1px solid black;"></textarea>
                    </div>
                            
                        <div class="col-md-12 input-group-btn align-center"><button type="submit" id="submit" name="submit" class="btn btn-form btn-primary display-4">Enviar</button></div>
                    </div>
                </form><!---Formbuilder Form--->
            </div>
        </div>
    </div>
</section>


  <section class="engine"><a href="https://mobirise.info/v">free html templates</a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/popper/popper.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smoothscroll/smooth-scroll.js"></script>
  <script src="assets/theme/js/script.js"></script>
  
  <?php
		  if (isset($_POST["submit"]) AND isset($_SESSION["login"]))
		  {
		  require("conexao.php");
          mysqli_select_db($conn,"terra");	  	

          $query="SELECT usu_email FROM usuario WHERE usu_email ='". $_SESSION['login']."'";
          $result=mysqli_query($conn,$query);
          $dados=mysqli_fetch_array($result);
          $login=$dados["usu_email"];
          mysqli_query($conn,$query);         

          $local=$_POST["frm_local"];
          $msg=$_POST["frm_msg"];
          $data=$_POST["frm_data"];

          $query="INSERT INTO reserva(
          res_local,
          res_data,
          res_msg,
          usu_email
          )
          values
          (
          '$local',
          '$data',
          '$msg',
          '$login'
           )";
          
          
           $x=mysqli_query($conn,$query);

           if($x)
          {
           print("<script>alert(\"Reserva feita com sucesso.\")</script>");
           print("<meta http-equiv=\"refresh\" content=\"0;index.php\">");
           }
           else
           {
             print("<script>alert(\"Olá $login, desculpe mas essa data já foi reservada\")</script>");
           }
           }
        ?>
</body>
</html>