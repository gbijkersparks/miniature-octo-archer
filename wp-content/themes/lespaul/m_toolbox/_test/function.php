<?php
//Cria post Custom Chamado de Post Slide.
add_action( 'init', 'zin_create_post_type' );
function zin_create_post_type() {
  register_post_type( 'post_slide',
    array(
      'labels' => array(
        'name' => 'Post Slides',
        'singular_name' => 'Post Slide',
		'add_new' => 'Novo Post Slide',
		'add_new_item' => 'Adicionar Novo Post Slide',
		'edit_item' => 'Editar Post Slide',
		'new_item' => 'Novo Post Slide'
      ),
      'public' => true,
	  'menu_position' => 5,
	  'supports' => array( 'title' , 'editor' , 'sticky' , 'excerpt' , 'comments' ),
	  'exclude_from_search' => true,
	  'taxonomies' => array( 'category' , 'post_tag' ),
      'rewrite' => array('slug' => 'destaque')
    )
  );
}
?>