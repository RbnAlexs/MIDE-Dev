<?php /* Template Name: Fabrica de Billetes */

get_header();?>


<main <?php post_class( 'site-main' ); ?> role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<header class="page-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>
	<div class="page-content">
	<form id="formulario" action="">  

			<div class="tab">			
				<h1>Bienvenido a la fabrica de billetes:</h1>
			</div>

			<div class="tab">
				Selecciona la denominación
				<input type="radio" class="radio" name="tipoBillete" id="b-100" value="billeteCien" />
				<label for="b-100" class="label">Example 1</label>

				<input type="radio" class="radio" name="tipoBillete" id="b-200" value="billeteDocientos" />
				<label for="b-200" class="label">Example 2</label>

				<input type="radio" class="radio" name="tipoBillete"id="b-500"  value="billeteQuinientos" />
				<label for="b-500" class="label">Example 3</label>	
			</div>

			<div class="tab">
				Selecciona los sellos de seguridad
				<input type="radio" class="radio" name="sellosBillete" id="s-001" value="selloUno" />
				<label for="s-001" class="label">Example 1</label>
				
			</div>

			<div class="tab">Listo para el acercamiento?
				<label for="upload_image">
					<img src="upload/user.png" id="uploaded_image" class="img-responsive img-circle" />
					<div class="overlay">
					<div class="text">Click to Change Profile Image</div>
					</div>
					<input type="file" name="image" class="image" id="upload_image" style="display:none" />
				</label>				
			</div>

			<div class="tab">Listo para el acercamiento?
				<input class="btn-merge" type="button" value="Unir" />
				<img class="merged-image hidden" alt="merged image" />
				<canvas id="canvas" class="hidden"></canvas>
			</div>

			<div style="overflow:auto;">
				<div style="float:right;">
				<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
				<button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
				</div>
			</div>

			<!-- Circles which indicates the steps of the form: -->
			<div style="text-align:center;margin-top:40px;">
				<span class="step"></span>
				<span class="step"></span>
				<span class="step"></span>
				<span class="step"></span>

			</div>
		
	</form>
		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
		</div>
		<?php wp_link_pages(); ?>
	</div>

	<?php comments_template(); ?>
</main>

<?php get_footer();?>
