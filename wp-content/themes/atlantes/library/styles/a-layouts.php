<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Layouts
*****************************************************
*/

//Website layout
$websiteLayout = array(

	array(
		'name' => __( 'Full width layout', 'atlantes_domain_adm' ),
		'id'   => 'fullwidth',
		'desc' => __( 'Full width - website sections will spread across the whole browser window width', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-full-width.png'
	),

	array(
		'name' => __( 'Boxed layout', 'atlantes_domain_adm' ),
		'id'   => 'boxed',
		'desc' => __( 'Boxed - website sections will be contained in a centered box', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-boxed.png'
	),

);

$websiteLayoutEmpty = array(

	array(
		'name' => __( 'Default website layout', 'atlantes_domain_adm' ),
		'id'   => 'default',
		'desc' => __( 'Use default website layout', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-default.png'
	),

	array(
		'name' => __( 'Boxed layout', 'atlantes_domain_adm' ),
		'id'   => 'boxed',
		'desc' => __( 'Boxed - website sections will be contained in a centered box', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-boxed.png'
	),

	array(
		'name' => __( 'Full width layout', 'atlantes_domain_adm' ),
		'id'   => 'fullwidth',
		'desc' => __( 'Full width - website sections will spread across the whole browser window width', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-full-width.png'
	),

);



//Sidebar positions
$sidebarPosition = array(

	array(
		'name' => __( 'Default theme settings', 'atlantes_domain_adm' ),
		'id'   => '',
		'desc' => __( 'Use default theme position of the sidebar', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-default.png'
	),

	array(
		'name' => __( 'Sidebar right', 'atlantes_domain_adm' ),
		'id'   => 'right',
		'desc' => __( 'Sidebar is aligned right from the page/post content', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-sidebar-right.png'
	),

	array(
		'name' => __( 'Sidebar left', 'atlantes_domain_adm' ),
		'id'   => 'left',
		'desc' => __( 'Sidebar is aligned left from the page/post content', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-sidebar-left.png'
	),

	array(
		'name' => __( 'No sidebar, full width', 'atlantes_domain_adm' ),
		'id'   => 'none',
		'desc' => __( 'No sidebar is displayed, the page content takes the full width of the website', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-sidebar-none.png'
	)

);



//Project layouts
$projectLayouts = array(
	"1OPTGROUP"  => __( 'Media first', 'atlantes_domain_adm' ),
		"media, col-34, col-14 last" => __( '3/4 media - 1/4 excerpt, content below', 'atlantes_domain_adm' ),
		"media, col-12, col-12 last" => __( '1/2 media - 1/2 excerpt, content below', 'atlantes_domain_adm' ),
	"1/OPTGROUP" => "",

	"2OPTGROUP"  => __( 'Excerpt first', 'atlantes_domain_adm' ),
		"excerpt, col-14, col-34 last" => __( '1/4 excerpt - 3/4 media, content below', 'atlantes_domain_adm' ),
		"excerpt, col-12, col-12 last" => __( '1/2 excerpt - 1/2 media, content below', 'atlantes_domain_adm' ),
	"2/OPTGROUP" => "",

	"3OPTGROUP"  => __( 'Post layout', 'atlantes_domain_adm' ),
		"plain"    => __( 'Plain post (large media area, content)', 'atlantes_domain_adm' ),
	"3/OPTGROUP" => "",
);



//Portfolio layout
$portfolioLayout = array(

	array(
		'name' => __( 'Default theme settings', 'atlantes_domain_adm' ),
		'id'   => '',
		'desc' => __( 'Use default theme portfolio layout', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-default.png'
	),

	array(
		'name' => __( 'Zigzag layout', 'atlantes_domain_adm' ),
		'id'   => '1',
		'desc' => __( '1 column zigzag layout', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-1.png'
	),

	array(
		'name' => __( 'Two columns', 'atlantes_domain_adm' ),
		'id'   => '2',
		'desc' => __( 'Two columns preview with basic info', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-2.png'
	),

	array(
		'name' => __( 'Three columns', 'atlantes_domain_adm' ),
		'id'   => '3',
		'desc' => __( 'Three columns preview with basic info', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-3.png'
	),

	array(
		'name' => __( 'Four columns', 'atlantes_domain_adm' ),
		'id'   => '4',
		'desc' => __( 'Four columns preview with basic info', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-4.png'
	),

	array(
		'name' => __( 'One column', 'atlantes_domain_adm' ),
		'id'   => '5',
		'desc' => __( 'Large preview and item description', 'atlantes_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-5.png'
	),

);

?>