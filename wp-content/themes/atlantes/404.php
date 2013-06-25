<?php get_header(); ?>
<div class="wrap-inner">

<section class="main page-404 twelve pane">

	<?php wm_start_main_content(); ?>

	<article class="text-center">

		<h1>Página ou conteúdo não encontrada!</h1>
		<br />
		<a href="<?php echo get_option('home'); ?>">Voltar a página inicial</a>
		<?php //echo do_shortcode( wm_option( 'p404-text' ) ); ?>

	</article>

</section> <!-- /main -->

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>