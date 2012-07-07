<?PHP

add_action("save_post", "simile_timeline_create");
add_action("before_delete_post", "simile_timeline_delete"); 

function simile_timeline_create($post_id)
{

	$data = get_post($post_id);
	
	$wp_dir = wp_upload_dir();
	
	if($data->post_type=="simile_timeline"){

		if(!empty($_POST)){

			if (!wp_verify_nonce($_POST['simile_timeline_save_field'],'simile_timeline_save') ){
			   print 'Sorry, your nonce did not verify.';
			   exit;
			}

		}
			
		$data = array();
		
		$data['simile_description'] = strip_tags($_POST['simile_description'],"<p><a><img>");
		$data['simile_start'] = htmlentities(strip_tags($_POST['simile_start']));
		$data['simile_stop'] = htmlentities(strip_tags($_POST['simile_stop']));
		
		$counter = 1;
		
		$save_counter = 1;
		
		$data['zones'] = array();
		
		while(isset($_POST['simile_zone_width_' . $counter])){
		
			$zone = array();
			
			if($_POST['simile_zone_delete_' . $counter]!="on"){
			
				$zone['simile_zone_start_' . $save_counter] = $_POST['simile_zone_start_' . $counter];
				$zone['simile_zone_stop_' . $save_counter] = $_POST['simile_zone_stop_' . $counter];
				$zone['simile_zone_width_' . $save_counter] = $_POST['simile_zone_width_' . $counter];
				$zone['simile_zone_interval_pixels_' . $save_counter] = $_POST['simile_zone_interval_pixels_' . $counter];
				$zone['simile_zone_unit_' . $save_counter] = $_POST['simile_zone_unit_' . $counter];
				$zone['simile_zone_sync_' . $save_counter] = $_POST['simile_zones_sync_' . $counter];
									
				if($_POST['simile_zone_width_' . $counter]!=""){
							
					$zone = array_filter($zone);		
							
					array_push($data['zones'], $zone);
					$save_counter++;
				
				}
			
			}
			
			$counter++;
		
		}
						
		$data['zone_labels'] = array();
		
		$counter = 1;
		
		$save_counter = 1;
		
		while(isset($_POST['simile_zone_label_startdate_' . $counter])){
		
			$zone_label = array();
			
			if($_POST['simile_zone_label_delete_' . $counter]!="on"){
									
				$zone_label['simile_zone_label_startdate_' . $save_counter] = $_POST['simile_zone_label_startdate_' . $counter];
				$zone_label['simile_zone_label_enddate_' . $save_counter] = $_POST['simile_zone_label_enddate_' . $counter];
				$zone_label['simile_zone_label_startlabel_' . $save_counter] = $_POST['simile_zone_label_startlabel_' . $counter];
				$zone_label['simile_zone_label_endlabel_' . $save_counter] = $_POST['simile_zone_label_endlabel_' . $counter];
				$zone_label['simile_zone_label_colour_' . $save_counter] = $_POST['simile_zone_label_colour_' . $counter];
				$zone_label['simile_zone_label_opacity_' . $save_counter] = $_POST['simile_zone_label_opacity_' . $counter];
				$zone_label['simile_event_label_zones_' . $save_counter] = $_POST['simile_event_label_zones_' . $save_counter];
			
				if($_POST['simile_zone_label_startdate_' . $counter]!=""){
				
					$zone_label = array_filter($zone_label);	
			
					array_push($data['zone_labels'], $zone_label);
					$save_counter++;
				
				}
						
			}
									
			$counter++;
		
		}
		
		$data['events'] = array();
				
		$counter = 1;
		
		$save_counter = 1;
		
		while(isset($_POST['simile_event_title_' . $counter])){
		
			$event = array();
			
			if($_POST['simile_event_delete_' . $counter]!="on"){
			
				$event['simile_event_title_' . $save_counter] = stripslashes($_POST['simile_event_title_' . $counter]);
				$event['simile_event_description_' . $save_counter] = $_POST['simile_event_description_' . $counter];
				$event['simile_event_link_' . $save_counter] = $_POST['simile_event_link_' . $counter];
				$event['simile_event_image_' . $save_counter] = $_POST['simile_event_image_' . $counter];
				$event['simile_event_start_' . $save_counter] = $_POST['simile_event_start_' . $counter];
				$event['simile_event_lateststart_' . $save_counter] = $_POST['simile_event_lateststart_' . $counter];
				$event['simile_event_earliestend_' . $save_counter] = $_POST['simile_event_earliestend_' . $counter];
				$event['simile_event_end_' . $save_counter] = $_POST['simile_event_end_' . $counter];
				$event['simile_event_durationevent_' . $save_counter] = $_POST['simile_event_durationevent_' . $counter];
				$event['simile_event_color_' . $save_counter] = $_POST['simile_event_color_' . $counter];
				$event['simile_event_textcolor_' . $save_counter] = $_POST['simile_event_textcolor_' . $counter];
				$event['simile_event_opacity_' . $save_counter] = $_POST['simile_event_opacity_' . $counter];
				$event['simile_event_zones_' . $save_counter] = $_POST['simile_event_zones_' . $counter];
								
				if($_POST['simile_event_title_' . $counter]!=""){
						
					$event = array_filter($event);	
				
					array_push($data['events'], $event);
					$save_counter++;
					
				}
			
			}
			
			$counter++;
		
		}
					
		if(isset($_POST)){
			
			file_put_contents($wp_dir['basedir'] . "/simile_timeline/" . $post_id . ".inc", serialize($data));
			
		}
	
	}

}


function simile_timeline_delete($post_id){

	$data = get_post($post_id);
	
	if($data->post_type=="simile_timeline"){

		$wp_dir = wp_upload_dir();
	
	
	}

}

?>