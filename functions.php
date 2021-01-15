<?php
/**
 * Theme custom functions 
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function fabrica_scripts() {
	if ( is_page('fabrica-de-billetes') ) {

		wp_deregister_script('jquery');

		wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery.min.js',  array('jquery'), false, true );

		wp_enqueue_script('bootstrap_js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.4.1', true);
 
		wp_enqueue_script('cropper_js', get_stylesheet_directory_uri() . '/js/cropper.js', false, true);
 
		  wp_enqueue_style( 
			 'slider', 
			 get_stylesheet_directory_uri()  . '/css/bootstrap.min.css',
			 false,'1.1','all'
		  );
 
		 wp_enqueue_style( 
			 'cropper', 
			 get_stylesheet_directory_uri()  . '/css/cropper.min.css',
			 false,'1.1','all'
			 );   
 
		 wp_enqueue_style( 
			 'fabrica', 
			 get_stylesheet_directory_uri()  . '/css/fabrica.min.css',
			 false,'1.1','all'
			 );   
		 
		 }
 }
 add_action( 'wp_print_scripts', 'fabrica_scripts', 100 );

function formularioFabrica() {
	ob_start();
	?>
    
	<form id="formulario-fabrica" class="fabrica" action="">  
		<!-- One "tab" for each step in the form: -->

		<div class="tab">
			<h2>Selecciona la denominación</h2>
			<h3>La denominación de los billetes es el valor nominal que viene impreso en ellos.</h3>
			
			<input type="radio" class="radio" name="tipoBillete" id="b-100" value="billeteCien" checked/>
			<label for="b-100" class="label-b" >Billete 100</label>

			<input type="radio" class="radio" name="tipoBillete" id="b-200" value="billeteDocientos" />
			<label for="b-200" class="label-b">Billete 200</label>

			<input type="radio" class="radio" name="tipoBillete" id="b-500"  value="billeteQuinientos" />
			<label for="b-500" class="label-b">Billete 500</label>	

			<h4>En México existen denominaciones de: 20, 50, 100, 200, 500 y 1,000 pesos.</h4>
		</div>

		<div class="tab">
			<h2>Elige tu sellos distintivo</h2>
			<h3>Los sellos distintivos ayudan a aumentar la seguridad de los billetes.</h3>

			<input type="radio" class="radio" name="sellosBillete" id="s-001" value="selloUno" checked />
			<label for="s-001" class="label-b">Sello 01</label>

			<input type="radio" class="radio" name="sellosBillete" id="s-002" value="selloDos"  />
			<label for="s-002" class="label-b">Sello 02</label>

			<input type="radio" class="radio" name="sellosBillete" id="s-003" value="selloTres"  />
			<label for="s-003" class="label-b">Sello 03</label>

			<input type="radio" class="radio" name="sellosBillete" id="s-004" value="selloCuatro" />
			<label for="s-004" class="label-b">Sello 04</label>

		</div>

		<div class="tab">
			<h2>Sube tu foto</h2>	
			<label for="upload_image">
				<img src="<?php  echo get_stylesheet_directory_uri()?>/images/id-facial.png" id="uploaded_image" class="img-responsive img-circle" />
				<div class="overlay">
					<div class="text">Click to Change Profile Image</div>
				</div>
				<input type="file" name="image" class="image" id="upload_image" style="display:none" />
			</label>				
		</div>

		<div class="tab">
			<h2>Sube tu foto</h2>	
			<img src="<?php  echo get_stylesheet_directory_uri()?>/images/loading.gif" id="imageID"/>
			<!-- <input class="btn-merge" type="button" value="Unir" /> -->
			<button type="button" id="nextBtn" class="btn-merge" onclick="nextPrev(1)" class="fabrica__botones__siguiente">Siguiente</button>
		</div>


		<div class="tab">Listo para el acercamiento?		
			<img class="merged-image hidden" alt="merged image" />
			<canvas id="canvas" class="hidden"></canvas>
		</div>

		<div class="fabrica__steps">
			<span class="step"></span>
			<span class="step"></span>
			<span class="step"></span>
			<span class="step"></span>
			<span class="step"></span>
		</div>

		<div class="fabrica__botones">
			<button type="button" id="prevBtn" onclick="nextPrev(-1)" class="fabrica__botones__regresar">Regresar</button>
			<button type="button" id="nextBtn" onclick="nextPrev(1)" class="fabrica__botones__siguiente">Siguiente</button>
		</div>
	</form>

	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<h5 class="modal-title">Crop Image Before Upload</h5>
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          			<span aria-hidden="true">×</span>
			        		</button>
			      		</div>
			      		<div class="modal-body">
			        		<div class="img-container">
			            		<div class="row">
			                		<div class="col-md-8">
			                    		<img src="" id="sample_image" />
			                		</div>
			                		<div class="col-md-4">
			                    		<div class="preview"></div>
			                		</div>
			            		</div>
			        		</div>
			      		</div>
			      		<div class="modal-footer">
			      			<button type="button" id="crop" class="btn btn-primary">Crop</button>
			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			      		</div>
			    	</div>
			  	</div>
		</div>			

	<script>
		var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
          // This function will display the specified tab of the form ...
          var x = document.getElementsByClassName("tab");
          x[n].style.display = "block";

			//Ocultar imagen despues de un tiempo
			setTimeout(function() {
				document.getElementById('imageID').style.display='none'
			}, 10*5000);

          // ... and fix the Previous/Next buttons:
          if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
          } else {
            document.getElementById("prevBtn").style.display = "inline";
          }
          if (n == (x.length)) {
            //document.getElementById("nextBtn").innerHTML = "Submit";
			document.getElementById("nextBtn").style.display = "none";

          } else {
            document.getElementById("nextBtn").innerHTML = "Siguiente";
          }
          // ... and run a function that displays the correct step indicator:
          fixStepIndicator(n)
        }

        function nextPrev(n) {
          // This function will figure out which tab to display
          var x = document.getElementsByClassName("tab");
          // Exit the function if any field in the current tab is invalid:
          if (n == 1 && !validateForm()) return false;
          // Hide the current tab:
          x[currentTab].style.display = "none";
          // Increase or decrease the current tab by 1:
          currentTab = currentTab + n;
          // if you have reached the end of the form... :
          if (currentTab >= x.length) {
            //...the form gets submitted:
            document.getElementById("formulario-fabrica").submit();
            return false;
          }
          // Otherwise, display the correct tab:
          showTab(currentTab);
        }

        function validateForm() {
          // This function deals with validation of the form fields
          var x, y, i, valid = true;
          x = document.getElementsByClassName("tab");
          y = x[currentTab].getElementsByTagName("input");
          // A loop that checks every input field in the current tab:
          for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
              // add an "invalid" class to the field:
              y[i].className += " invalid";
              // and set the current valid status to false:
              valid = false;
            }
          }
          // If the valid status is true, mark the step as finished and valid:
          if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
          }
          return valid; // return the valid status
        }

        function fixStepIndicator(n) {
          // This function removes the "active" class of all steps...
          var i, x = document.getElementsByClassName("step");
          for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
          }
          //... and adds the "active" class to the current step:
          x[n].className += " active";
        }
	</script>
	<script>

function merge() {

var canvas = document.getElementById('canvas'),
	ctx = canvas.getContext('2d'),
	imageObj1 = new Image(),
	imageObj2 = new Image();

	//imageObj1.src = $('.image1').attr('src');
	imageObj1.src = billeteFinal();
	imageObj1.onload = function() {
		ctx.globalAlpha = 1;
		canvas.width = 750;
		canvas.height = 400;
		ctx.filter = 'sepia(0.5)';
		ctx.drawImage(imageObj1, 0, 0, 750, 400);
		imageObj2.src = $('#uploaded_image').attr('src');;
		imageObj2.onload = function() {
			ctx.globalAlpha = 1;
			ctx.filter = 'contrast(1.25) sepia(0.5)';
			ctx.drawImage(imageObj2, 300, 85, 220, 220);
			var img = canvas.toDataURL('image/jpeg');
			$('.merged-image').attr('src', img);
			$('.merged-image').removeClass('hidden');
		}
};

}

function billeteFinal(){
	if ($("input[name='tipoBillete']").is(":checked")) {
		var tipoBillete = $("input[name='tipoBillete']:checked").val();
	}  

	if ($("input[name='sellosBillete']").is(":checked")) {
		var sellosBillete = $("input[name='sellosBillete']:checked").val();
	} 

	var urlBillete;
		switch(tipoBillete){
			case 'billeteCien':
				switch (sellosBillete){
					case 'selloUno': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_100_s_01.png'; break;
					case 'selloDos': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_100_s_02.png'; break;
					case 'selloTres': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_100_s_03.png'; break;
					case 'selloCuatro': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_100_s_04.png'; break;
				}
				break;

			case 'billeteDocientos':
				switch (sellosBillete){
					case 'selloUno': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_200_s_01.png'; break;
					case 'selloDos': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_200_s_02.png'; break;
					case 'selloTres': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_200_s_03.png'; break;
					case 'selloCuatro': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_200_s_04.png'; break;
				}
				break;
				
			case 'billeteQuinientos':
				switch (sellosBillete){
					case 'selloUno': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_500_s_01.png'; break;
					case 'selloDos': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_500_s_02.png'; break;
					case 'selloTres': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_500_s_03.png'; break;
					case 'selloCuatro': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_500_s_04.png'; break;
				}
				break;
		} 
	return urlBillete;
}

$('#formulario-fabrica input').on('change', function() {

	if ($("input[name='tipoBillete']").is(":checked")) {
		var tipoBillete = $("input[name='tipoBillete']:checked").val();
	}  

	if ($("input[name='sellosBillete']").is(":checked")) {
		var sellosBillete = $("input[name='sellosBillete']:checked").val();
	} 

	var urlBillete;
		switch(tipoBillete){
			case 'billeteCien':
				switch (sellosBillete){
					case 'selloUno': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_100_s_01.png'; break;
					case 'selloDos': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_100_s_02.png'; break;
					case 'selloTres': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_100_s_03.png'; break;
					case 'selloCuatro': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_100_s_04.png'; break;
				}
				break;

			case 'billeteDocientos':
				switch (sellosBillete){
					case 'selloUno': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_200_s_01.png'; break;
					case 'selloDos': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_200_s_02.png'; break;
					case 'selloTres': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_200_s_03.png'; break;
					case 'selloCuatro': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_200_s_04.png'; break;
				}
				break;
				
			case 'billeteQuinientos':
				switch (sellosBillete){
					case 'selloUno': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_500_s_01.png'; break;
					case 'selloDos': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_500_s_02.png'; break;
					case 'selloTres': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_500_s_03.png'; break;
					case 'selloCuatro': urlBillete = '<?php  echo get_stylesheet_directory_uri()?>/images/billete_500_s_04.png'; break;
				}
				break;
		} 
	return urlBillete;
});

$('.file1, .file2').on('change', function() {
var reader = new FileReader(),
	imageSelector = $(this).data('image-selector');

if (this.files && this.files[0]) {
	reader.onload = function(e) {
	imageIsLoaded(e, imageSelector)
	};
	reader.readAsDataURL(this.files[0]);
}
});

$('.btn-merge').on('click', merge);

function imageIsLoaded(e, imageSelector) {
$(imageSelector).attr('src', e.target.result);
$(imageSelector).removeClass('hidden');
};



$(document).ready(function(){

	var $modal = $('#modal');

	var image = document.getElementById('sample_image');

	var cropper;

	$('#upload_image').change(function(event){
		var files = event.target.files;

		var done = function(url){
			image.src = url;
			$modal.modal('show');
		};

		if(files && files.length > 0)
		{
			reader = new FileReader();
			reader.onload = function(event)
			{
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	});

	$modal.on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 1,
			viewMode: 3,
			preview:'.preview'
		});
	}).on('hidden.bs.modal', function(){
		cropper.destroy();
		cropper = null;
	});

	function getRoundedCanvas(sourceCanvas) {
		var canvas = document.createElement('canvas');
		var context = canvas.getContext('2d');
		var width = sourceCanvas.width;
		var height = sourceCanvas.height;
		canvas.width = width;
		canvas.height = height;
		context.imageSmoothingEnabled = true;
		context.drawImage(sourceCanvas, 0, 0, width, height);
		context.globalCompositeOperation = 'destination-in';
		context.beginPath();
		context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
		context.fill();
		return canvas;
	}

	$('#crop').click(function(){
		canvas = cropper.getCroppedCanvas({
			width:200,
			height:200
		});

		//canvas = getRoundedCanvas(canvas);
		getRoundedCanvas(cropper.getCroppedCanvas()).toBlob(function(blob){
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function(){
				var ajaxurl = '<?php  echo get_stylesheet_directory_uri()?>/';
				console.log(ajaxurl);
				var base64data = reader.result;
				$.ajax({
					url:'<?php  echo get_stylesheet_directory_uri()?>/upload.php',
					method:'POST',
					data:{image:base64data},
					success:function(data)
					{
						$modal.modal('hide');
						$('#uploaded_image').attr('src', ajaxurl + data);
					}
				});
			};
		});
	});
	
});
</script>
	<?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
   }
add_shortcode('fabricaBilletes', 'formularioFabrica');



add_action( 'widgets_init', 'widget_academia' );
function widget_academia () {
	register_sidebar( array(
	'name' => 'Academia MIDE',
	'id' => 'academia-mide',
	'class' => 'academia-mide',
	) );
}