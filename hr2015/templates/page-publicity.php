<?php
/**
 * Template Name: Tpl Publicity
 */
?>
<?php get_header(); ?>

	<div id="page-main" class="page-content">
		<div class="row small-collapse medium-collapse large-collapse ohidden">
			<div class="extraTitle medium-6 large-8 medium-centered large-centered columns">
				<div class="extraTitle__one text-center">¿Quieres ver tu <span>noticia</span> ó <span>evento</span> aquí arriba?</div>
				<div class="icon-facebook input-icon"></div>
				<div class="extraTitle__one text-center">¿Qué te vean en el timeline de nuestro
<span>facebook</span>?</div>
			</div>
			<h2 class="publicity text-center small-12 medium-6 large-6 medium-centered large-centered columns">Envíanos tus datos y en donde deseas promocionar tu marca</h2>
		</div>
		<form id="suscription" class="row ohidden" action="post" validate >
			<div class="small-12 medium-6 large-8 medium-centered large-centered columns">
				<label for="username" class="item-box">
					<span class="icon-user input-icon"></span>
					<input type="text" id="username" name="username" placeholder="Nombre completo" required />
				</label>
			</div>
			<div class="small-12 medium-6 large-8 medium-centered large-centered columns">
				<label for="usermail" class="item-box">
					<span class="icon-mail input-icon"></span>
					<input type="email" id="usermail" name="usermail" placeholder="Correo electrónico" required />
				</label>
			</div>
			<div class="small-12 medium-6 large-8 medium-centered large-centered columns">
				<label for="username" class="item-box">
					<span class="icon-phone input-icon"></span>
					<input type="tel" id="cellphone" name="cellphone" placeholder="Teléfono" required />
				</label>
			</div>
			<div class="small-12 medium-6 large-8 medium-centered large-centered columns">
				<label for="usermail" class="item-box">
					<span class="icon-note input-icon"></span>
					<input type="text" id="whereplace" name="whereplace" placeholder="¿Dónde quieres publicitar?" required />
				</label>
			</div>

			<div class="small-12 medium-6 large-8 medium-centered large-centered columns submit-box">
				<input type="submit" id="sendSuscription" value="Quiero publicidad en HRMAG">
			</div>
		</form>
	</div>

<?php get_footer(); ?>