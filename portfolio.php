<?php
ob_start();
require_once "includes/config.php";
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
		                    <h1 class="title title--h1 first-title title__separate">Portfolio</h1>
					    </div>

						<?php
						$filtros = array('html', 'php','javascript', 'nodejs'); #para paginacao funcionar 
						$categorias = array('HTML e CSS', 'PHP','Javascript', 'NodeJS'); #para ilustracao/design
					
						$file = file_get_contents("./json/projetos.json");
						$projetos = json_decode($file, true);
						
						?>
				
						<!-- Gallery -->
						<div class="pb-0">
							<!-- Filter -->
                            <div class="select">
			                    <span class="placeholder">Selecione a categoria</span>
			                    <ul class="filter">

			                        <li class="filter__item">Categoria</li>
				                    <li class="filter__item active" data-filter="*"><a class="filter__link active" href="portfolio.html#filter">Todos</a></li>
								<?php
								$n = count($filtros);
								
								for ($f = 0; $f < $n; $f++) {
								?>

				                     <li class="filter__item" data-filter="<?=".". $filtros[$f] ?>"><a class="filter__link" href="portfolio.html#filter"><?= $categorias[$f] ?></a></li>
								
								<?php } ?>
								</ul>
			                    <input type="hidden" name="changemetoo"/>
		                    </div>
							
							<!-- Content -->
							<div class="gallery-grid js-masonry js-filter-container">
							    <div class="gutter-sizer"></div>

								<?php
								$x = count($projetos['projetos']);
								
								for ($i = 0; $i < $x; $i++) {

								?>
							    <!-- Item 1 -->
							    <figure class="gallery-grid__item 
								<?php
									$categ = $projetos['projetos'][$i]['categoria'];
									
									for ($fx = 0; $fx < $n; $fx++) {
										if($categ == $filtros[$fx]){
											echo $filtros[$fx];
										}
									}
								?>">
									<div class="gallery-grid__image-wrap">
										<a title="<?= $projetos['projetos'][$i]['nome'] ?>" href="<?= 'projeto?id='.$i; ?>">
											<img class="gallery-grid__image cover lazyload" src="<?= $projetos['projetos'][$i]['imagem'] ?>" data-zoom alt="" />
										</a>
									</div>
									<div class="d-flex">
										<figcaption class="gallery-grid__caption col-10">
											<h4 class="title gallery-grid__title" style=" white-space: nowrap;width: 100%;overflow: hidden;text-overflow:ellipsis;"><?= $projetos['projetos'][$i]['nome'] ?></h4>
											<span class="gallery-grid__category" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"><?= mb_strimwidth($projetos['projetos'][$i]['descricao'], 0, 42, "...")  ?></span>
										</figcaption>
										<?php
											if(isset($_SESSION['login']) && $_SESSION['login']=='true'){ 
										?>
										<div class="col-2 d-flex align-items-center">
											<a href="#"><i class="fas fa-pen-square" style="font-size:35px;"></i></a>
										</div>
										<?php } ?>
									</div>
									</figure>
									
								<?php }?>
							</div>
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

	<!-- Demo Menu -->
	<div class="btnSlideNav slideOpen"></div>
    <div class="btnSlideNav slideClose"></div>
    <ul class="slideNav">
	    <li class="slideNav__item rtl-mode"><h4 class="title title--5">More pages</h4> <a href="rtl/about.html">RTL</a></li>
        <li class="slideNav__item"><a href="one-page.html">1. Single page</a></li>
        <li class="slideNav__item"><a href="background-3.html">2. Background peach</a></li>
        <li class="slideNav__item"><a href="background-2.html">3. Background green</a></li>
		<li class="slideNav__item"><a href="background-5.html">4. Background green 2</a></li>
		<li class="slideNav__item"><a href="background-4.html">5. Background triangles</a></li>
		<li class="slideNav__item"><a href="menu_alternative/about.html">6. Alternative menu</a></li>
    </ul>
	<div class="overlay-slideNav"></div>
    <!-- Demo Menu -->	

	<!-- JavaScripts -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/plugins.min.js"></script>
    <script src="assets/js/common.js"></script>
    
	<script src="assets/demo/plugins-demo.js"></script>
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