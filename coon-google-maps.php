<?php
/*
Plugin Name: Coon Google Maps
Author: Andrico
Author URI: https://profiles.wordpress.org/andrico/
Description: You can insert google maps in your site. It's very easy to use, and you can show routes, markers.
Version: 1.0
*/

add_action("init","coon_google_maps_init");
function coon_google_maps_init(){
	wp_enqueue_script("maps","https://maps.googleapis.com/maps/api/js?v=3.exp");
    
    add_shortcode("map","coon_google_maps");
    add_shortcode("marker","coon_google_maps_marker");
}

function coon_google_maps($atts_old,$content){
	$atts = shortcode_atts( array(
        'to' => '',
        'from' => '',
        'address' => false,
        'centerlat' => 0,
        'centerlng' => 0,
        'width' => '500px',
        'height' => '200px',
        'zoom' => '10',
        'pancontrol' => 'false',
	    'zoomcontrol' => 'false',
	    'scalecontrol' => 'false',
	    'zoomcontrol' => 'false',
	    'maptypecontrol' => 'false',
    ), $atts_old );
    $ret = "";
    $nameMap = 'map_'.uniqid();
    if($atts["address"]){
    	$request = wp_remote_get('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($atts["address"]).'&sensor=true');
    	$response = wp_remote_retrieve_body( $request );
    	$address = json_decode($response);
    	$atts["centerlat"] = $address->results[0]->geometry->location->lat;
    	$atts["centerlng"] = $address->results[0]->geometry->location->lng;
    }

    $mapData = array("#{{nameMap}}#","#{{centerlat}}#","#{{centerlng}}#");
    $mapReplace = array($nameMap,$atts["centerlat"],$atts["centerlng"]);
    $markers = preg_replace($mapData,$mapReplace,strip_tags(do_shortcode($content)));

    $ret .= '<script defer="defer" type="text/javascript">
    	var '.$nameMap.';
		function initialize_'.$nameMap.'() {
			var mapOptions = {
				zoom: '.$atts["zoom"].',
				panControl: '.(string)$atts["pancontrol"].',
			    zoomControl: '.(string)$atts["zoomcontrol"].',
			    scaleControl: '.(string)$atts["scalecontrol"].',
			    mapTypeControl: '.(string)$atts["maptypecontrol"].',
			    zoomControl: '.(string)$atts["zoomcontrol"].',
			    zoomControlOptions: {
					style: google.maps.ZoomControlStyle.SMALL
			    },
				center: new google.maps.LatLng('.$atts["centerlat"].','.$atts["centerlng"].'),
			};
			'.$nameMap.' = new google.maps.Map(document.getElementById("'.$nameMap.'"),mapOptions);
			'.$markers.'
		}
		jQuery(function(){
			google.maps.event.addDomListener(window, "load", initialize_'.$nameMap.'());
		})
		
		</script>
		<div id="'.$nameMap.'" class="map" style="width:'.$atts["width"].';height:'.$atts["height"].';"></div>';
    return $ret;
}
function coon_google_maps_marker($atts,$content){
	$atts = shortcode_atts( array(
        'lat' => '',
        'lng' => '',
        'icon' => '',
    ), $atts );
    $ret = "";
    $atts["lat"] = $atts["lat"]=="map"?"{{centerlat}}":$atts["lat"];
    $atts["lng"] = $atts["lng"]=="map"?"{{centerlng}}":$atts["lng"];
    $nameMap = 'map_'.uniqid();
    $ret .= 'var myLatlng{{nameMap}} = new google.maps.LatLng('.$atts["lat"].','.$atts["lng"].');
    		var marker = new google.maps.Marker({
		      position: myLatlng{{nameMap}},
		      map: {{nameMap}},
		      title: "'.$content.'"
		  });';

    return $ret;
}
