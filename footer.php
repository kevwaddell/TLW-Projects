			</div>
			
		</main>
		<!-- MAIN CONTENT END -->
		
		<?php 
		$team_pg = get_page_by_title('Team');
		 ?>
		
		<!-- FOOTER START -->
		<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
			<div class="container">
			
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#footer-collapse-links">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="footer-collapse-links">
				
				<ul class="nav navbar-nav">

					<!--
<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-life-ring"></i> Help <span class="caret"></span></a>
					
					  <?php wp_nav_menu(array( 
						'container' => 'false', 
						'menu' => 'Help Menu', 
						'menu_class'  => 'dropdown-menu',
						'fallback_cb' => false ) ); 
						?>
					
					</li>
-->	
					<li><a href="<?php echo get_option('home'); ?>/" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					<li><a href="<?php echo get_permalink($team_pg->ID); ?>" title="Team"><i class="fa fa-group"></i> Team</a></li>
				
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
						
					<li><a href="https://drive.google.com/folderview?id=0B0YEQYF714l7THBTUE9rd3dFTHc&usp=sharing" target="_blank"><i class="fa fa-google"></i> Google Drive</a></li>
					
					<li><a href="http://adobe.ly/1nq8OxP" target="_blank"><i class="fa fa-cloud fa-lg"></i> Creative Cloud</a></li>
				
				</ul>
				
				</div>
				
			</div>
		</nav>
		
		<div class="content-mask"></div>
		
		</div>
		
		<aside class="help-sidebar sidebar-closed">
			<button class="close-sidebar btn btn-info btn-block"><i class="fa fa-angle-double-right fa-lg"></i></button>
		
		</aside>
		
		<?php wp_footer(); ?>

	</body>
</html>