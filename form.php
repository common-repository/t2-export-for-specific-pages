<?php

/** Load WordPress Bootstrap */
require_once( ABSPATH . '/wp-admin/admin.php' );

/** Advanced export_wp */
require_once(dirname( __FILE__ ).'/includes/export_wp.php');

/** Download action */
if ( isset($_POST['download'],$_POST['post_type']) ){
	$post_types = $_POST['post_type'];
	$page_ids = array();
	if( in_array('page', $post_types) && $_POST['page_ids']!='' ){
		unset( $post_types[array_search('page', $post_types)] );
		$page_ids = explode( ',', trim($_POST['page_ids']) );
	}

	$args = array();
	$args['post_types'] = $post_types;
	$args['page_ids'] = $page_ids;

	if( in_array('post', $post_types) ){
		$args['category'] = (int)$_POST['cat'];
	}

	$args = apply_filters( 'export_args', $args );

	ob_clean();
	t2export_wp( $args );
	die();
}


?>

<div class="wrap">
<h2>Wordpress T2 Export</h2>

<p><?php _e('When you click the button below T2 Export will create an XML file for you to save to your computer.'); ?></p>
<p><?php _e('This format, which we call WordPress eXtended RSS or WXR, will contain your posts, pages, comments, custom fields, categories, and tags.'); ?></p>
<p><?php _e('Once you&#8217;ve saved the download file, you can use the Import function in another WordPress installation to import the content from this site.'); ?></p>

<h3><?php _e( 'Choose what to export' ); ?></h3>

<form action="" method="post" id="export-filters">
	<input type="hidden" name="download" value="true" />

	<!-- POST -->
	<p><label><input type="checkbox" name="post_type[]" value="post" /> Posts</label></p>
	<ul id="post-filters" class="export-filters">
		<li>
			<label>Categories:</label> 
			<?php wp_dropdown_categories( array( 'show_option_all' => __('All') ) ); ?>
		</li>
	</ul>

	<!-- PAGE -->
	<p><label><input type="checkbox" name="post_type[]" value="page" /> Pages</label></p>
	<ul id="page-filters" class="export-filters">
		<li>
			<input type="hidden" id="t2export_allpages" name="page_ids" />
			<div id="hidden_pages">
	            <?php
	            $pages = get_pages();
	            foreach ($pages as $page){
                	echo '<span data-id="' . $page->ID . '">' . $page->post_title . '</span>';
	            }
                ?>
            </div>
			<p class="description">If you leave blank this field, all pages will export.</p>
		</li>
	</ul>

	<!-- NAV MENU -->
	<p><label><input type="checkbox" name="post_type[]" value="nav_menu_item" /> Navigation Menu</label></p>
		

	<?php foreach ( get_post_types( array( '_builtin' => false, 'can_export' => true ), 'objects' ) as $post_type ) : ?>
	<p>
		<label>
			<input type="checkbox" name="post_type[]" value="<?php echo esc_attr( $post_type->name ); ?>" />
			<?php echo esc_html( $post_type->label ); ?>
		</label>
	</p>
	<?php endforeach; ?>

	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Download Export File">
	</p>

</form>