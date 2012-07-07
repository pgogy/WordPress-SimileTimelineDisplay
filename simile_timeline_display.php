<?PHP

	/*
	Plugin Name: Simile timeline display
	Description: Simile timeline display allowed for an MIT Simile timeline to be displayed on a WordPress site
	Version: 0.3
	Author: pgogy
	Author URI: http://www.pgogy.com
	*/

	require_once("simile_timeline_display_editor.php");
	require_once("simile_timeline_display_show.php");
	require_once("simile_timeline_display_custompost.php");
	require_once("simile_timeline_display_posthandling.php");
	
	register_activation_hook( __FILE__, 'simile_timeline_activate' );
	
	register_deactivation_hook( __FILE__ , 'simile_timeline_deactivate');
	
	function simile_timeline_activate(){
				
		$wp_dir = wp_upload_dir();
		
		if(!file_exists($wp_dir['basedir'] . "/simile_timeline/")){
		
			mkdir($wp_dir['basedir'] . "/simile_timeline/");
			chmod($wp_dir['basedir'] . "/simile_timeline/",0755);
			
		}
		
	
	}
	
	function simile_timeline_deactivate(){
	
		$wp_dir = wp_upload_dir();
	
		if(!file_exists($wp_dir['basedir'] . "/simile_timeline/")){
		
			$dir = opendir($wp_dir['basedir'] . "/simile_timeline/");
		
			while($file = readdir($dir)){
		
				if($file!="."&&$file!=".."){
			
					if(!@unlink($wp_dir['basedir'] . "/simile_timeline/" . $file)){
		
						wp_die($file . " did not delete");
		
					}
			
				}	
		
			}
		
			rmdir($wp_dir['basedir'] . "/simile_timeline/");
			
		}
	
	}

?>