<ul class="nav navbar-nav">

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-building-o"></i> Company <span class="caret"></span></a>

  <?php wp_nav_menu(array( 
	'container' => 'false', 
	'menu' => 'Company Links', 
	'menu_class'  => 'dropdown-menu',
	'fallback_cb' => false ) ); 
	?>

</li>

</ul>