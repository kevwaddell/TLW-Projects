<?php 
global $current_user;
get_currentuserinfo();	

//echo '<pre>';print_r($current_user->ID);echo '</pre>';
$account_pg = get_page_by_title("My Account");
?>
<ul class="nav navbar-nav navbar-right">

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $current_user->display_name; ?> <span class="caret"></span></a>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo get_author_posts_url( $current_user->ID, $current_user->user_nicename); ?>">My Projects</a></li>
    <li><a href="<?php echo get_permalink($account_pg->ID); ?>"><?php echo $account_pg->post_title; ?></a></li>
    <?php if (current_user_can('administrator')) { ?>
    <li class="divider"></li>
    <li><a href="<?php echo admin_url(); ?>">Admin</a></li>
    <?php } ?>
    <li><a href="<?php echo wp_logout_url(); ?>"><i class="fa fa-unlock"></i> Logout</a></li>
  </ul>
</li>

</ul>

