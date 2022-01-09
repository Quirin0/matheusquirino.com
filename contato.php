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
			    <!-- Sidebar -->
                <?include 'components/sidebar.php';?>
		        
				<!-- Content -->
		        <div class="col-12 col-md-12 col-xl-9">
				    <div class="box shadow">
					    <!-- Menu -->
					    <?include 'components/menu.php';?>

					    <!-- About -->
						<div class="pb-2">
		                    <h1 class="title title--h1 first-title title__separate">Contato</h1>
					    </div>

						<!-- Contact -->
                        <div class="mapouter"><div class="gmap_canvas"><iframe width="auto" height="458" id="gmap_canvas" src="https://maps.google.com/maps?q=taubate&t=&z=7&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org"></a><br><style>.mapouter{position:relative;text-align:right;height:458px;width:auto;}</style><a href="https://www.embedgooglemap.net">embedding maps</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:458px;width: auto;}</style></div></div>
						<h2 class="title title--h3">Formulário de contato</h2>
							
						<form id="contact-form" class="contact-form" data-toggle="validator">
                            <div class="row">
				                <div class="form-group col-12 col-md-6">
									<i class="font-icon icon-user"></i>
                                    <input type="text" class="input input__icon form-control" id="nameContact" name="nameContact" placeholder="Full name" required="required" autocomplete="on" oninvalid="setCustomValidity('Fill in the field')" onkeyup="setCustomValidity('')">
								    <div class="help-block with-errors"></div>
				                </div>
				                <div class="form-group col-12 col-md-6">
									<i class="font-icon icon-envelope"></i>
                                    <input type="email" class="input input__icon form-control" id="emailContact" name="emailContact" placeholder="Email address" required="required" autocomplete="on" oninvalid="setCustomValidity('Email is incorrect')" onkeyup="setCustomValidity('')">
								    <div class="help-block with-errors"></div>
				                </div>
				                <div class="form-group col-12 col-md-12">
                                    <textarea class="textarea form-control" id="messageContact" name="messageContact" placeholder="Your Message"  rows="4" required="required" oninvalid="setCustomValidity('Fill in the field')" onkeyup="setCustomValidity('')"></textarea>
								    <div class="help-block with-errors"></div>
				                </div>
						    </div>
							<div class="row">
				                <div class="col-12 col-md-6 order-2 order-md-1 text-center text-md-left">
					                <div id="validator-contact" class="hidden"></div>
				                </div>
				                <div class="col-12 col-md-6 order-1 order-md-2 text-right">
					                <button type="submit" class="btn"><i class="font-icon icon-send"></i> Send Message</button>
				                </div>
			                </div>
		                </form>
					</div>
					
					<!-- Footer -->
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

    <!-- Mapbox init -->
	<script src="assets/js/mapbox.init.js"></script>
	
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