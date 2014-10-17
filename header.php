<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->
<head id="projects-tlwsolicitors-co-uk" data-template-set="tlw-projects-theme" profile="http://gmpg.org/xfn/11">

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php if (is_search()) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title><?php bloginfo('name');?></title>
	
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/_/img/favicon.ico">

	<?php wp_head(); ?>
	
	<!-- <script src="http://maxcdn.bootstrapcdn.com/bootlint/0.4.0/bootlint.min.js"></script> -->
	
	<?php 
	$url = explode('/',$_SERVER['REQUEST_URI']);
	$dir = $url[1] ? $url[1] : 'dashboard';
	?>
	
</head>

<body id="<?php echo $dir ?>" <?php body_class(); ?>>

<div class="wrapper">
	
	<!-- TOP BAR START -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		
		<div class="container">
		
			<div class="navbar-header">
			<?php if (is_user_logged_in()) { ?>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-links">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
			<?php }  ?>
				<a href="<?php echo get_option('home'); ?>/" class="navbar-brand"><span class="sr-only"><?php bloginfo('name'); ?></span></a>		
			</div>
			
			<?php if (is_user_logged_in()) { ?>
			<div class="collapse navbar-collapse" id="navbar-collapse-links">
			
			<?php include (STYLESHEETPATH . '/_/inc/global/project-links.php'); ?>
			<?php include (STYLESHEETPATH . '/_/inc/global/company-links.php'); ?>
			
			<?php include (STYLESHEETPATH . '/_/inc/global/user-actions.php'); ?>
					     
			</div><!-- /.navbar-collapse -->
			<?php }  ?>
					
		</div><!-- /.container -->
		
	</nav>
	<?php if (!is_front_page()) { ?>
	<div class="breadcrumbs-outer">
		<div class="container">
			<?php if(function_exists('bcn_display')) { bcn_display();}?>
		</div>
	</div>
	<?php } ?>
	
	<!-- TOP BAR END -->
		
	<!-- MAIN CONTENT START -->
	<main class="content">
	
		<div class="container">