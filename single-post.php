<?php
ob_start();
require_once "includes/config.php";

?>

<?php 

	if($_GET['id']==''){
		header("Location: home");
	}else{
		$id = $_GET['id'];
	}
	$file = file_get_contents("./json/projetos.json");
	$projetos = json_decode($file, true);
	$dados = $projetos['projetos'][$id];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?include 'includes/head.php';?>	
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

	<!-- Scroll Indicator -->
    <div class="scroll-line"></div>

    <main class="main">
	    <div class="container gutter-top">
		    <div class="row sticky-parent">
			    <!-- Sidebar -->
				<?include 'components/sidebar.php';?>
		        
				<!-- Content -->
		        <div class="col-12 col-md-12 col-xl-9">
				    <div class="box shadow pb-0">
					    <!-- Menu -->
					    <?include 'components/menu.php';?>
						
						<!-- Post -->
						<div class="pb-3">
						    <header class="header-post">
						        <!-- <div class="header-post__date">Sep 15, 2019</div> -->
                                <h1 class="title title--h1"><?=$dados['nome']?></h1>
								<div class="container">
									<div class="header-post__image-wrap">
										<img class="cover lazyload" src="<?=$dados['imagem']?>" alt="" />
									</div>
								</div>
							</header>
							<div class="gallery-post">
								<img class="gallery-post__item cover lazyload" src="<?=$dados['imagem1']?>" data-zoom alt="" />
								<img class="gallery-post__item cover lazyload" src="<?=$dados['imagem2']?>" data-zoom alt="" />
								
							</div>
							<div class="container d-flex p-2" style="justify-content:center;">
								<a target="_blank" href="<?=$dados['link']?>" class="btn btn-primary">Visitar</a>
							</div>
							<div class="caption-post">
								<p><?=$dados['descricao']?></p>
								
							</div>
							<div class="gallery-post__caption">Work by <a href="home">Matheus Vinicius Quirino</a></div>
							
						</div>
						<?php 
						$file = file_get_contents("./json/comentarios.json");
						$comentarios = json_decode($file, true);
						$x = count($comentarios[$id]);
						?>
						<div class="box-inner box-inner--rounded">
						    <h2 class="title title--h3">Comentários <span class="color--light">(<?=$x?>)</span></h2>
							
							<?php
							date_default_timezone_set('America/Sao_Paulo');
							$horario = date("d/m/Y") . " às " . date("H:i");
							// $comentarios = [
							// 	array(
							// 		array(
							// 		"nome"=>"jubileu","comentario"=>"muito bom o projeto!", "horario"=>"${horario}",
							// 		"nome"=>"jubileu2 do projeto 1","comentario"=>"muito bom o projetox!", "horario"=>"${horario}"
							// 		)
							// 	),
							// 	array(
							// 		array(
							// 		"nome"=>"jubileu","comentario"=>"muito bom o projeto!", "horario"=>"${horario}",
							// 		"nome"=>"jubileu2 do projeto 2","comentario"=>"muito bom o projetox!", "horario"=>"${horario}"
							// 		)
							// 	)
								
							// ];
							// $myjson = json_encode($comentarios, JSON_PRETTY_PRINT);
							// file_put_contents("./json/comentarios.json",$myjson);

							$file = file_get_contents("./json/comentarios.json");
							$comentarios = json_decode($file, true);

							$emoji = [
								" :laughing: " => " \u{1F602} ",
								" :happy 2: " => " \u{1F603} ",
								" :crazy: " => " \u{1F92A} ",
								" :bad: " => " \u{1F620} ",
								" :angry: " => " \u{1F621} ",
								" :happy: " => " \u{1F600} ",
								" :thinking: " => " \u{1F914} ",
								" :sad: " => " \u{2639} ",
								" :pressure: " => " \u{1F62C} ",
								" :in love: " => " \u{1F60D} ",
								" :happy 3: " => " \u{1F60A} ",
								" :shocked: " => " \u{1F631} ",
								" :wink: " => " \u{1F609} ",
								" :sweating: " => " \u{1F605} ",
								" :shocked 2: " => " \u{1F632} "
							];
							// adicionar comentario
							if(isset($_POST['adicionar'])) { 

								if(!$comentarios[$id]){
									$rand = random_int(0,500);
									$com_post = $_POST['comentario'];
									$clean_coment = strtr($com_post, $emoji);
									echo "<script>alert('Erro, tente novamente mais tarde!');</script>";
									
								}else{
									$rand = random_int(0,500);
									$com_post = $_POST['comentario'];
									$clean_coment = strtr($com_post, $emoji);
									$dados = ["nome"=>"Anônimo ${rand}", "comentario"=>"${clean_coment}","horario"=>"${horario}"];
									array_push($comentarios[$id], $dados);
			
									$myjson = json_encode($comentarios, JSON_PRETTY_PRINT);
									file_put_contents("./json/comentarios.json",$myjson);
								}


								
							} 
		
							// echo "<pre>";
							// print_r($comentarios[$id]);
							// echo "</pre>";
							$x = count($comentarios[$id]);
					
							for ($i = 0; $i < $x; $i++) {		
							
							?>
							<!-- Comment -->
			                <div class="comment-box">
							    <div class="comment-box__inner">
                                    <svg class="avatar avatar--60" viewBox="0 0 84 84">
                                        <g class="avatar__hexagon">
                                            <image xlink:href="data:image/png;base64,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" height="100%" width="100%" />
                                        </g>
                                    </svg>
                                    <div class="comment-box__body">
                                        <h5 class="comment-box__details"><span><?= $comentarios[$id][$i]['nome']; ?></span><span class="comment-box__details-date"><?= $comentarios[$id][$i]['horario']; ?></span></h5>
                                        <p><?= $comentarios[$id][$i]['comentario']; ?></p>

										<ul class="comment-box__footer">
										    
										    <a onclick="alert('Em breve irei implementar isso...')"><li><i class="fas fa-reply"></i> <span>Reply</span></li></a>
										</ul>
                                    </div>
								</div>
					        </div>
							<?}?>
							
							
							<form class="comment-form" method="post">
								<input type="hidden" name="adicionar">
							    <textarea id="commentForm" class="textarea textarea--white form-control" required="required" placeholder="Escreva um comentario..." rows="1" name="comentario"></textarea>
								<button type="submit" class="btn"><i class="fas fa-angle-right"></i></button>
								<div class="dropdown dropup">
								    <i class="fas fa-smile" id="dropdownEmoji" data-toggle="dropdown" aria-haspopup="true"></i>
								    <div class="dropdown-menu dropdown-menu-center" aria-labelledby="dropdownEmoji">
									    <div class="emoji-wrap">
                                            <img class="emoji" src="assets/icons/emoji/emoji-laughing.svg" title=":laughing:" alt="laughing"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-happy-2.svg" title=":happy 2:" alt="happy 2"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-crazy.svg" title=":crazy:" alt="crazy"/>
											<img class="emoji" src="assets/icons/emoji/emoji-bad.svg" title=":bad:" alt="bad"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-angry.svg" title=":angry:" alt="angry"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-happy.svg" title="happy" alt="happy"/>
                                            <img class="emoji" src="assets/icons/emoji/emoji-thinking.svg" title=":thinking:" alt="thinking"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-sad.svg" title=":sad:" alt="sad"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-pressure.svg" title=":pressure:" alt="pressure"/>
											<img class="emoji" src="assets/icons/emoji/emoji-in-love.svg" title=":in love:" alt="in love"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-happy-3.svg" title=":happy 3:" alt="happy 3"/>
                                            <img class="emoji" src="assets/icons/emoji/emoji-shocked.svg" title=":shocked:" alt="shocked"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-wink.svg" title=":wink:" alt="wink"/>
										    <img class="emoji" src="assets/icons/emoji/emoji-sweating.svg" title=":sweating:" alt="sweating"/>
											<img class="emoji" src="assets/icons/emoji/emoji-shocked-2.svg" title=":shocked 2:" alt="shocked 2"/>
										</div>	
                                    </div>
                                </div>	
							</form>
							
					    </div>
					</div>
					
					<? include_once 'includes/footer.php';?>
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
	<script src="assets/demo/plugins-demo.js"></script>
	<script src="form-refresh.js"></script>
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