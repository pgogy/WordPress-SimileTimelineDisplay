<?PHP

add_action("the_content", "simile_timeline_display" );
add_action("wp_head","simile_timeline_display_javascript");
add_action("wp_print_scripts","simile_timeline_display_javascript");
	
function simile_timeline_display_javascript(){

	global $post;

	if($post->post_type=="simile_timeline"){
	
		wp_enqueue_script( "simile_timeline_display", "http://static.simile.mit.edu/timeline/api-2.3.0/timeline-api.js?bundle=true");
		
	}
				
}

function simile_timeline_display($content)
{

	global $post;

	if($post->post_type=="simile_timeline"){
	
		$wp_dir = wp_upload_dir();
	
		$data = unserialize(file_get_contents($wp_dir['basedir'] . "/simile_timeline/" . $post->ID . ".inc"));
					
		?><div id="tl"></div><p id='simile_error'>Timeline hasn't displayed correctly - please check for javascript errors.</p><?PHP
		
		?><script>
		
		    var tl;
			
			<?PHP
				
				for($y=0;$y<count($data['zones']);$y++){
				
			?>
			
			
			var timeline_data_<?PHP echo $y; ?> = {  // save as a global variable
				'dateTimeFormat': 'iso8601',
				'wikiSection': "",

				'events' : [
				
					<?PHP
								
					for($x=0;$x<count($data['events']);$x++){
					
						if(is_array($data['events'][$x]['simile_event_zones_' . ($x+1)])){						
																		
							if(in_array($y, $data['events'][$x]['simile_event_zones_' . ($x+1)])){
				
							?>
						
							{
							 'start': '<?PHP echo $data['events'][$x]['simile_event_start_' . ($x+1)]; ?>',
							 'end': '<?PHP echo $data['events'][$x]['simile_event_end_' . ($x+1)]; ?>',
							 'durationEvent' : <?PHP if($data['events'][$x]['simile_event_durationevent_' . ($x+1)]=="on"){ echo "1"; }else{ echo "0"; } ?>,
							 'title': "<?PHP echo str_replace("\\","",$data['events'][$x]['simile_event_title_' . ($x+1)]); ?>",
							 'description': "<?PHP echo str_replace("\\","",(trim($data['events'][$x]['simile_event_description_' . ($x+1)]))); ?>",
							 'image': '<?PHP echo $data['events'][$x]['simile_event_image_' . ($x+1)]; ?>',
							 'link': '<?PHP echo $data['events'][$x]['simile_event_link_' . ($x+1)]; ?>'
							}
							
							<?PHP
										
								if($x<(count($data['events'])-1)){
						
									echo ",";
						
								}						
								
							}
						
						}
					
					}
					
					?>
				]
				
			}
			
			<?PHP
				
				}
				
			?>
        
			function onLoad() {
			
				var tl_el = document.getElementById("tl");
				
				<?PHP
				
				$data = unserialize(file_get_contents($wp_dir['basedir'] . "/simile_timeline/" . $post->ID . ".inc"));
					
				for($y=0;$y<count($data['zones']);$y++){
				
				?>
				
					var eventSource<?PHP echo $y; ?> = new Timeline.DefaultEventSource();
					var theme<?PHP echo $y; ?> = Timeline.ClassicTheme.create();
					theme<?PHP echo $y; ?>.autoWidth = true; // Set the Timeline's "width" automatically.
										 // Set autoWidth on the Timeline's first band's theme,
										 // will affect all bands.
										 
					theme<?PHP echo $y; ?>.timeline_start = new Date(Date.UTC('<?PHP echo $data['simile_start']; ?>', 0, 1));
					theme<?PHP echo $y; ?>.timeline_stop  = new Date(Date.UTC('<?PHP echo $data['simile_stop']; ?>', 0, 1));	
					var d<?PHP echo $y; ?> = Timeline.DateTime.parseGregorianDateTime('<?PHP echo $data['zones'][$y]['simile_zone_start_' . ($y+1)]; ?>');	
				
				<?PHP
				
				}
				
				print_r($data['zones'][$y]);
				
				?>
				
				var bandInfos = [
				
				<?PHP
				
				for($x=0;$x<count($data['zones']);$x++){
				
				?>
				
					Timeline.createBandInfo({
						width:          "100%", // set to a minimum, autoWidth will then adjust
						intervalUnit:   <?PHP
						
											switch($data['zones'][$x]['simile_zone_unit_' . ($x+1)]){
											
												case 0: echo " Timeline.DateTime.HOUR,"; break;
												case 1: echo " Timeline.DateTime.DAY,"; break;
												case 2: echo " Timeline.DateTime.MONTH,"; break;
												case 3: echo " Timeline.DateTime.YEAR,"; break;
												case 4: echo " Timeline.DateTime.DECADE,"; break;
												case 5: echo " Timeline.DateTime.CENTURY,"; break;
											
											}
						
										?>
						intervalPixels: <?PHP echo $data['zones'][$x]['simile_zone_interval_pixels_' . ($x+1)]; ?>,
						eventSource:    eventSource<?PHP echo $x; ?>,
						date:           d<?PHP echo $x; ?>,
						theme:          theme<?PHP echo $x; ?>,
						layout:         'original'  // original, overview, detailed
					})
					
					<?PHP
					
						if($x<(count($data['zones'])-1)){
						
							echo ",";
						
						}						
					
					}
					
					?>
					
					
				];
												
				<?PHP
				
				
				
				for($y=0;$y<count($data['zones']);$y++){
				
				?>
				
				  bandInfos[<?PHP echo $y; ?>].decorators = [
				
					<?PHP
				
					for($x=0;$x<count($data['zone_labels']);$x++){
					
						if(is_array($data['zone_labels'][$x]['simile_event_label_zones_' . ($x+1)])){
					
							if(in_array($y, $data['zone_labels'][$x]['simile_event_label_zones_' . ($x+1)])){
										
								?>
							
									new Timeline.SpanHighlightDecorator({
										startDate:  "<?PHP echo $data['zone_labels'][$x]['simile_zone_label_startdate_' . ($x+1)]; ?>",
										endDate:    "<?PHP echo $data['zone_labels'][$x]['simile_zone_label_enddate_' . ($x+1)]; ?>",
										startLabel: "<?PHP echo $data['zone_labels'][$x]['simile_zone_label_startlabel_' . ($x+1)]; ?>",
										endLabel:   "<?PHP echo $data['zone_labels'][$x]['simile_zone_label_endlabel_' . ($x+1)]; ?>",
										color:      "<?PHP echo $data['zone_labels'][$x]['simile_zone_label_colour_' . ($x+1)]; ?>",
										opacity:    <?PHP echo $data['zone_labels'][$x]['simile_zone_label_opacity_' . ($x+1)]; ?>,
										theme:      theme1
									})
								
								<?PHP
								
									if($x<(count($data['zones'])-1)){
						
										echo ",";
						
									}
													
							}
					
						}
				
					}
								
					?>
													
				];

				<?PHP
				
				}
								
				?>		

				<?PHP
				
				for($y=0;$y<count($data['zones']);$y++){
				
				
					if($data['zones'][$y]['simile_zone_sync_' . ($y+1)]!="-1"&&$data['zones'][$y]['simile_zone_sync_' . ($y+1)]!=""){
					
				?>
				
					bandInfos[<?PHP echo $y; ?>].syncWith = <?PHP echo $data['zones'][$y]['simile_zone_sync_' . ($y+1)] ?>;
				
				<?PHP
				
					}
				
				} 
				
				?>
											
				// create the Timeline
				tl = Timeline.create(tl_el, bandInfos, Timeline.HORIZONTAL);
								
				var url = '.'; // The base url for image, icon and background image
							   // references in the data

				<?PHP 
							   
					for($y=0;$y<count($data['zones']);$y++){
				
				?>
				
						eventSource<?PHP echo $y; ?>.loadJSON(timeline_data_<?PHP echo $y; ?>, url); // The data was stored into the 
														   // timeline_data variable.
				
				<?PHP
				
					}
				
				?>			   							   
				
				tl.layout(); // display the Timeline
			}
			
			onLoad();
			document.getElementById('simile_error').style.display = "none";
		
		</script><?PHP
	
		echo $data['simile_description'];
	
	}else{
	
		return $content;
	
	}

}

?>