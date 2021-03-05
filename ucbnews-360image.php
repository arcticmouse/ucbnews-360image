<?php
/*
Plugin Name:  UCBNews 360 Image
Plugin URI: http://news.berkeley.edu
Description: Uses JS libraries to display a 360 image from a shortcode
			 Uses https://github.com/JeremyHeleine/Photo-Sphere-Viewer
Author: Public Affairs - Leta Negandhi
Version: 1.5

Added to photo-sphere-viewer.js line 688
startDeviceOrientation(); <- in order to auto start gyroscope on devices that support it
*/
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;



//[image360 image_id="xxx" caption="xxx"]
function image360_func($arr){
	
	ob_start();	
	
	if(!empty($arr[image_id])) {
		$image_data = wp_prepare_attachment_for_js($arr[image_id]);
		$class = '';
	
		if(is_page_template('news-template-1.php')) {
			$speed = '0.5rpm';
			$class = 'rotund-image';
			$height = '800px';
		} else {
			$speed = '1rpm';
			$height = '500px';			
		}
		
		if(strlen($image_data[description]) >= 140) {
			$user_data = array(
				'image' => $image_data[url],
				'loading_gif' => '<img src="'.plugins_url('Berkeleymark_animation.gif', __FILE__).'" style="margin: auto auto;">',
				'description' => $image_data[description],
				'speed' => $speed,
				);
		
			wp_enqueue_style( 'image360css', plugins_url('css/image360css.css', __FILE__ ));
			wp_enqueue_script( 'three', plugins_url('js/three.min.js', __FILE__ ), false, null);
			wp_enqueue_script( 'photo-sphere-viewer', plugins_url('js/photo-sphere-viewer.min.js', __FILE__ ), false, null);
			wp_enqueue_script( 'image360js', plugins_url('js/image360js.js', __FILE__ ), false, null);
			wp_localize_script( 'image360js', 'image_var', $user_data);
			
			echo '<meta property="og:image" content="'.$image_data[url].'" />
					<div id="360-image-container" class="col-xs-12 '. $class .'" style="height:'. $height .'; margin: 10px 0; padding: 0; text-align: center;" aria-label="'.$user_data[description].'" />
						<div id="360-image" style="width: 100%; height: 100%;"/>
						</div></div>';
			if( !empty($arr[caption]) )
				echo '<div class="caption-360" style="background-color: #f7f7f7; border-bottom: 1px solid #eee; margin: 0; padding: 5px; color: #003262; height: auto;">'.$arr[caption].'</div>';
			
			echo '<p>&nbsp;&nbsp;&nbsp;</p>';
		} //if image description is long enough
	} //if image id not empty	
	
	$result = ob_get_contents(); 
    ob_end_clean();
    return $result;
}

add_shortcode('image360', 'image360_func');

?>