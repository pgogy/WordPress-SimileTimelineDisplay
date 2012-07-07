<?PHP

	add_action('init', 'simile_timeline_custom_page_type_create');

	function simile_timeline_custom_page_type_create() 
	{
	  $labels = array(
		'name' => _x('Simile Timelines', 'post type general name'),
		'singular_name' => _x('Simile Timeline', 'post type singular name'),
		'add_new' => _x('Add New', 'simile_timeline'),
		'add_item' => __('Add New '),
		'edit_item' => __('Edit Simile Timeline'),
		'item' => __('New Simile Timeline'),
		'view_item' => __('View Simile Timeline'),
		'search_items' => __('Search Simile Timeline'),
		'not_found' =>  __('No Simile Timelines found'),
		'not_found_in_trash' => __(	'No Simile Timelines found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Simile Timeline'

	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'menu_item' => plugin_dir_url(__FILE__) . "logo.jpg",
		'_edit_link' => 'post.php?post=%d',	
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'rewrite' => false,
		'description' => 'A Collection of terms which which to search for resources with',
		'supports' => array('title'),
		'taxonomies' => array('category')
	  ); 
	  register_post_type('simile_timeline',$args);

	}

?>