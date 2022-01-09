<?PHP
ob_start();
require_once "includes/config.php";
?>
<?PHP 
	$jsonFile = file_get_contents('./user/user.json');
	$dados = json_decode($jsonFile);

	$user = $dados->user;
	$pass = $dados->user;
	
	if(isset($_POST['fname']) && $_POST['fname']==$dados->user && isset($_POST['fpass']) && $_POST['fpass']==$dados->pass) {
		$_SESSION['login']='true';
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?include 'includes/head.php';?>
	<style>

.enviar{
border-radius:4px !important;
padding:6px 15px !important;
}


.input-contain{
    position: relative;
}
input{
    height: 3rem;
    width: 15rem;
    border: 1px solid black;
    border-radius: 4px;
}
.placeholder-text{
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    border: 3px solid transparent;
    background-color: transparent;
    display: flex;
    align-items: center;
}
.placeholder-text{
    pointer-events: none;
}
.text{
    font-size: 1rem;
    padding: 0 0.5rem;
    background-color: transparent;
    color: black;
}

input, .placeholder-text{
    font-size: 1rem;
    padding: 20px 1.2rem;
}
input:focus{
    outline: none;
    border-color: blueviolet;
}
input:focus + .placeholder-text .text{
    background-color: white;
    font-size: 0.8rem;
    color: black;
    transform: translate(0, -100%);
    border-color: blueviolet;
    color: blueviolet;
}
.text{
    transform: translate(0);
    transition: transform 0.15s ease-out, font-size 0.15s ease-out, background-color 0.2s ease-out, color 0.15s ease-out;
}
input:focus + .placeholder-text .text, :not(input[value=""]) + .placeholder-text .text{
    background-color: white;
    font-size: 0.8rem;
    color: black;
    transform: translate(0, -100%);
}

input:focus + .placeholder-text .text{
    border-color: blueviolet;
    color: blueviolet;
}
.col-6{
	max-width: 0px !important;
}

								</style>
</head>
<body class="bg-triangles">
    <!-- Preloader -->
    <div class="preloader">
	    <div class="preloader__wrap">
		    <div class="circle-pulse">
                <div class="circle-pulse__1"></div>
                <div class="circle-pulse__2"></div>
            </div>
		    <div class="preloader__progress"><span></span></div>
		</div>
	</div>

    <main class="main">
	    <div class="container gutter-top">
		    <div class="row sticky-parent">

			   <?include 'components/sidebar.php';?>
		        
				<!-- Content -->
		        <div class="col-12 col-md-12 col-xl-9">
				    <div class="box shadow pb-0">
					    <!-- Menu -->
					    <?include 'components/menu.php';?>

					    <!-- About -->
						<div class="pb-2">
		                    <h1 class="title title--h1 first-title title__separate">Fazer login</h1>
							<?PHP
							if(isset($_POST['fname']) && $_POST['fname']==$dados->user && isset($_POST['fpass']) && $_POST['fpass']==$dados->pass) {
								echo("<div class='alert alert-success'> <strong>Login realizado com sucesso!</strong> </div>");
							}?>
						</div>
						<!-- Gallery -->
						<div class="pb-0 row d-flex" style="justify-content:center;">
							
							<form action="login" method="POST" >
							<div class="row" style="justify-content:center;">
							<div class="col-6 input-contain" style="display:table; margin:10px 0px;">
								<input type="text" id="fname" name="fname" autocomplete="off" value="" aria-labelledby="placeholder-fname">
								<label class="placeholder-text" for="fname" id="placeholder-fname">
									<div class="text">Usuário</div>
								</label>
							</div>
							<div class="col-6 input-contain" style="display:table; margin:10px 0px;">
								<input type="password" id="fpass" name="fpass" autocomplete="off" value="" aria-labelledby="placeholder-fname">
								<label class="placeholder-text" for="fpass" id="placeholder-fpass">
									<div class="text">Senha</div>
								</label>
							</div>
							<div class="col-12" style="height: 70px;display: flex;align-items: center;justify-content:center;">
								<button class="btn enviar" type="submit">Enviar</button>
							</div>
						</form>
							<script>
								let input_element = document.querySelector("input");

								input_element.addEventListener("keyup", () => {
									input_element.setAttribute("value", input_element.value);
								})
							</script>
						</div>
					</div>
					
					<?include 'includes/footer.php';?>
		        </div>
			</div>
		</div>	
    </main>

    <div class="back-to-top"></div>
	
    <!-- SVG masks -->
    <svg class="svg-defs">
        <clipPath id="avatar-box">
            <path d="M1.85379 38.4859C2.9221 18.6653 18.6653 2.92275 38.4858 1.85453 56.0986.905299 77.2792 0 94 0c16.721 0 37.901.905299 55.514 1.85453 19.821 1.06822 35.564 16.81077 36.632 36.63137C187.095 56.0922 188 77.267 188 94c0 16.733-.905 37.908-1.854 55.514-1.068 19.821-16.811 35.563-36.632 36.631C131.901 187.095 110.721 188 94 188c-16.7208 0-37.9014-.905-55.5142-1.855-19.8205-1.068-35.5637-16.81-36.63201-36.631C.904831 131.908 0 110.733 0 94c0-16.733.904831-37.9078 1.85379-55.5141z"/>
        </clipPath>
        <clipPath id="avatar-hexagon">
             <path d="M0 27.2891c0-4.6662 2.4889-8.976 6.52491-11.2986L31.308 1.72845c3.98-2.290382 8.8697-2.305446 12.8637-.03963l25.234 14.31558C73.4807 18.3162 76 22.6478 76 27.3426V56.684c0 4.6805-2.5041 9.0013-6.5597 11.3186L44.4317 82.2915c-3.9869 2.278-8.8765 2.278-12.8634 0L6.55974 68.0026C2.50414 65.6853 0 61.3645 0 56.684V27.2891z"/>
        </clipPath>		
    </svg>


	<!-- JavaScripts -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/common.js"></script>

</body>
</html>
<? 
$cntACmp =ob_get_contents(); 
ob_end_clean(); 
$cntACmp=str_replace("\n",' ',$cntACmp); 
$cntACmp=preg_replace('/[[:space:]]+/',' ',$cntACmp);
echo $cntACmp; 
ob_end_flush(); 
?>