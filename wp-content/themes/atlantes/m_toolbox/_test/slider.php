<?php	$loop = new WP_Query( array( 'post_type' => 'post_slide', 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'ASC') );
if ($loop->have_posts()): //Se existe posts Side.?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/slide_custom.js"></script>

<div id="slide-center" class="spliter-main">
	<div id="slide-center-home">
		<ul id="slideshow">
			<?php	while ( $loop->have_posts() ) : $loop->the_post(); //Primeiro while loop em busca de posts Slide. ?>

			<?php if(the_thumb_imagem()) { //Verifica se o post possui imagem, se não tiver não exibe o post no Slide. ?>
				<li>
					<div class="post-slide">
						<h2><?php the_title(); ?></h2>
						<p class="slide-content"><?php the_content_limite(240); ?></p>
						<a  class="more-slide" href="<?php the_permalink() ?>" title="Veja mais detalhes de <?php the_title(); ?>">Leia Mais</a>
						<img class="thumb-slide" src="<?php echo get_template_directory_uri(); ?>/scripts/timthumb.php?src=<?php echo the_thumb_imagem('full');?>&w=560&h=210&zc=1" alt="<?php the_title(); ?>"/>
					</div>
				</li>
			<?php } ?>
			<?php endwhile; //Fim do Primeiro loop. ?>
		</ul>

		<ul id="slide-nav">
			<?php	while ( $loop->have_posts() ) : $loop->the_post(); //Novo while loop para gerar as miniaturas do Slide. ?>

				<?php if(the_thumb_imagem()) { //Verifica se o post possui imagem, se não tiver não exibe a miniatura do Slide. ?>
					<li><a href="#"><img class="thumb-nav" src="<?php echo get_template_directory_uri(); ?>/scripts/timthumb.php?src=<?php echo the_thumb_imagem('thumbnail');?>&w=108&h=50&zc=1" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/></a></li>
				<?php } ?>

			<?php endwhile; //fim do segundo loop. ?>
		</ul>

	</div><!--#slide-center-home-->
</div><!--#slide-center-->
<?php else: //Se não existe posts para o Slide.?>
<div id="slide-center-no-post" class="spliter-main"></div>
<?php endif; ?>