<?php
if (!class_exists("terminus_google_maps")) {

	class terminus_google_maps {

		function __construct() {
			add_action( 'wp_enqueue_scripts', array($this, 'google_map_script'), 1 );
			add_action( 'vc_before_init', array($this, 'add_map_google_maps') );
		}

		function google_map_script() {
			wp_register_script( "terminus-vc-googleapis", "https://maps.googleapis.com/maps/api/js?v=3.23", null, null, false );
		}

		function add_map_google_maps(){

			if ( function_exists('vc_map')) {

				vc_map( array(
					"name" => esc_html__("Google Map", "terminus"),
					"base" => "vc_mad_google_map",
					"class" => "vc_google_map",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "icon-wpb-mad-google-map",
					"description" => esc_html__("Display Google Maps to indicate your location.", "terminus"),
					'category' => esc_html__( 'Terminus', 'terminus' ),
					"params" => array(
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Width (in %)", "terminus"),
							"param_name" => "width",
							"admin_label" => true,
							"value" => "100%",
							"group"  => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Height (in px)", "terminus"),
							"param_name" => "height",
							"admin_label" => true,
							"value" => "300px",
							"group"  => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Map type", "terminus"),
							"param_name" => "map_type",
							"admin_label" => true,
							"value" => array(
								esc_html__("Roadmap", "terminus") => "ROADMAP",
								esc_html__("Satellite", "terminus") => "SATELLITE",
								esc_html__("Hybrid", "terminus") => "HYBRID",
								esc_html__("Terrain", "terminus") => "TERRAIN"),
							"group"  => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Latitude", "terminus"),
							"param_name" => "lat",
							"admin_label" => true,
							"value" => "40.7707307",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','terminus').'</a> '. esc_html__('where you can find Latitude & Longitude of your location', 'terminus'),
							"group"  => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => esc_html__("Longitude", "terminus"),
							"param_name" => "lng",
							"admin_label" => true,
							"value" => "-74.0210859",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','terminus').'</a> '. esc_html__('where you can find Latitude & Longitude of your location', "terminus"),
							"group"  => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Map Zoom", "terminus"),
							"param_name" => "zoom",
							"value" => array(
								esc_html__("18 - Default", "terminus") => 18, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 14, 15, 16, 17, 18, 19, 20
							),
							"group" => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "checkbox",
							"heading" => "",
							"param_name" => "scrollwheel",
							"value" => array(
								esc_html__("Disable map zoom on mouse wheel scroll", "terminus") => "disable",
							),
							"group" => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => esc_html__("Info Window Text", "terminus"),
							"param_name" => "content",
							"value" => "",
							"group"  => esc_html__('Info Window', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Marker/Point icon", "terminus"),
							"param_name" => "marker_icon",
							"value" => array(
								esc_html__("Use Google Default", "terminus") => "default",
								esc_html__('Use Theme Default', "terminus") => "default_self",
								esc_html__("Upload Custom", "terminus") => "custom"
							),
							"group"  => esc_html__('Marker', 'terminus')
						),
						array(
							"type" => "attach_image",
							"class" => "",
							"heading" => esc_html__("Upload Image Icon:", "terminus"),
							"param_name" => "icon_img",
							"admin_label" => true,
							"value" => "",
							"description" => esc_html__("Upload the custom image icon.", "terminus"),
							"dependency" => array(
								"element" => "marker_icon",
								"value" => array("custom")
							),
							"group"  => esc_html__('Marker', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Street view control", "terminus"),
							"param_name" => "streetviewcontrol",
							"value" => array(
								esc_html__("Disable", "terminus") => "false",
								esc_html__("Enable", "terminus") => "true"
							),
							"group"  => esc_html__('Advanced', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Map type control", "terminus"),
							"param_name" => "maptypecontrol",
							"value" => array(
								esc_html__("Disable", "terminus") => "false",
								esc_html__("Enable", "terminus") => "true"
							),
							"group"  => esc_html__('Advanced', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Map pan control", "terminus"),
							"param_name" => "pancontrol",
							"value" => array(
								esc_html__("Disable", "terminus") => "false",
								esc_html__("Enable", "terminus") => "true"
							),
							"group" => "Advanced"
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Zoom control", "terminus"),
							"param_name" => "zoomcontrol",
							"value" => array(esc_html__("Disable", "terminus") => "false", esc_html__("Enable", "terminus") => "true"),
							"group"  => esc_html__('Advanced', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Zoom control size", "terminus"),
							"param_name" => "zoomcontrolsize",
							"value" => array(esc_html__("Small", "terminus") => "SMALL", esc_html__("Large", "terminus") => "LARGE"),
							"dependency" => Array("element" => "zoomControl","value" => array("true")),
							"group"  => esc_html__('Advanced', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Disable dragging on Mobile", "terminus"),
							"param_name" => "dragging",
							"value" => array( esc_html__("Enable", "terminus") => "true", esc_html__("Disable", "terminus") => "false"),
							"group"  => esc_html__('Advanced', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Top margin", "terminus"),
							"param_name" => "top_margin",
							"value" => array(
								esc_html__("Page (small)", "terminus") => "page_margin_top",
								esc_html__("Section (large)", "terminus") => "page_margin_top_section",
								esc_html__("None", "terminus") => "none"
							),
							"group"  => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("Map Width Override", "terminus"),
							"param_name" => "map_override",
							"value" =>array(
								esc_html__("Default Width", 'terminus')=>"0",
								esc_html__("Apply 1st parent element's width", 'terminus')=>"1",
								esc_html__("Apply 2nd parent element's width", 'terminus')=>"2",
								esc_html__("Apply 3rd parent element's width", 'terminus')=>"3",
								esc_html__("Apply 4th parent element's width", 'terminus')=>"4",
								esc_html__("Apply 5th parent element's width", 'terminus')=>"5",
								esc_html__("Apply 6th parent element's width", 'terminus')=>"6",
								esc_html__("Apply 7th parent element's width", 'terminus')=>"7",
								esc_html__("Apply 8th parent element's width", 'terminus')=>"8",
								esc_html__("Apply 9th parent element's width", 'terminus')=>"9",
								esc_html__('Full Width', 'terminus')=>"full",
								esc_html__('Maximum Full Width', 'terminus')=>"ex-full",
							),
							"description" => esc_html__("By default, the map will be given to the Visual Composer row. However, in some cases depending on your theme's CSS - it may not fit well to the container you are wishing it would. In that case you will have to select the appropriate value here that gets you desired output..", "terminus"),
							"group"  => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "textarea",
							"class" => "",
							"heading" => esc_html__("Google Styled Map JSON", "terminus"),
							"param_name" => "map_style",
							"value" => "",
							"description" => "<a target='_blank' href='http://googlemaps.github.io/js-samples/styledmaps/wizard/index.html'>".__("Click here","terminus")."</a> ".__("to get the style JSON code for styling your map.","terminus"),
							"group"  => esc_html__('Styling', 'terminus')
						),
						array(
							"type" => "textfield",
							"heading" => esc_html__("Extra class name", "terminus"),
							"param_name" => "el_class",
							"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "terminus"),
							"group"  => esc_html__('General Settings', 'terminus')
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => esc_html__("MapBorder Style", "terminus"),
							"param_name" => "map_border_style",
							"value" => array(
								esc_html__('None', 'terminus')=> "",
								esc_html__('Solid', 'terminus')=> "solid",
								esc_html__('Dashed', 'terminus') => "dashed",
								esc_html__('Dotted', 'terminus') => "dotted",
								esc_html__('Double', 'terminus') => "double",
								esc_html__('Inset', 'terminus') => "inset",
								esc_html__('Outset', 'terminus') => "outset",
							),
							"description" => "",
							"group"  => esc_html__('Border', 'terminus')
						),
						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => esc_html__("Border Color", "terminus"),
							"param_name" => "map_color_border",
							"value" => "",
							"description" => "",
							"dependency" => array(
								"element" => "map_border_style",
								"not_empty" => true
							),
							"group"  => esc_html__('Border', 'terminus')
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => esc_html__("Border Width", "terminus"),
							"param_name" => "map_border_size",
							"value" => 1,
							"min" => 1,
							"max" => 10,
							"suffix" => "px",
							"description" => "",
							"dependency" => array(
								"element" => "map_border_style",
								"not_empty" => true
							),
							"group"  => esc_html__('Border', 'terminus')
						),
						array(
							"type" => "number",
							"class" => "",
							"heading" => esc_html__("Border Radius","terminus"),
							"param_name" => "map_radius",
							"value" => 3,
							"min" => 0,
							"max" => 500,
							"suffix" => "px",
							"description" => "",
							"dependency" => array(
								"element" => "map_border_style",
								"not_empty" => true
							),
							"group"  => esc_html__('Border', 'terminus')
						)
					)
				));
			}
		}

	}

	if (class_exists('WPBakeryShortCode')) {

		class WPBakeryShortCode_vc_mad_google_map extends WPBakeryShortCode {

			protected function content($atts, $content = null) {

				$width = $height = $map_type = $lat = $lng = $zoom = $streetviewcontrol = $maptypecontrol = $map_style = $top_margin = $pancontrol = $zoomcontrol = $zoomcontrolsize = $dragging = $marker_icon = $icon_img = $map_override = $output = $scrollwheel = $el_class = $map_border_style = $map_color_border = $map_border_size = $map_radius ='';

				extract(shortcode_atts(array(
					"width" => "100%",
					"height" => "300px",
					"map_type" => "ROADMAP",
					"lat" => "40.7707307",
					"lng" => "-74.0210859",
					"zoom" => "18",
					"scrollwheel" => "",
					"streetviewcontrol" => "false",
					"maptypecontrol" => "false",
					"pancontrol" => "false",
					"zoomcontrol" => "false",
					"zoomcontrolsize" => "SMALL",
					"dragging" => "true",
					"marker_icon" => "default",
					"icon_img" => "",
					"top_margin" => "page_margin_top",
					"map_override" => "0",
					"map_style" => "",
					"el_class" => "",
					"map_border_style" => "",
					"map_color_border" => "",
					"map_border_size" => "",
					"map_radius" => ""
				), $atts));

				$border_css = $gmap_design_css ='';
				$marker_lat = $lat;
				$marker_lng = $lng;

				if ( $marker_icon == "default_self" ) {
					$icon_url = get_template_directory_uri() . '/config-composer/assets/images/marker.png';
				} elseif ( $marker_icon == "default" ) {
					$icon_url = "";
				} else {
					$icon_url = TERMINUS_HELPER::get_post_attachment_image($icon_img, '');
				}

				$id = "map_" . uniqid();
				$wrap_id = "wrap_" . $id;
				$map_type = strtoupper($map_type);
				$width = (substr($width, -1)!="%" && substr($width, -2) != "px" ? $width . "px" : $width);
				$map_height = (substr($height, -1)!="%" && substr($height, -2) != "px" ? $height . "px" : $height);

				$margin_css = '';

				if ( $top_margin != 'none' ) {
					$margin_css = $top_margin;
				}

				if ( $map_border_style !='' ) {
					$border_css .= 'border-style:'.$map_border_style.';';
				}

				if ( $map_color_border != '' ) {
					$border_css .= 'border-color:'. $map_color_border .';';
				}

				if ( $map_border_size != '' ) {
					$border_css .= 'border-width:'. $map_border_size .'px;';
				}

				if ( $map_radius !='' ) {
					$border_css .= 'border-radius:'. $map_radius .'px;';
				}

				$output .= "<div class='wpb_content_element'>";

				$output .= "<div id='". $wrap_id ."' class='terminus-map-wrapper ". $el_class ."' style='".( $map_height != "" ? "height:" . $map_height . ";" : "")."'><div id='" . $id . "' data-map_override='". $map_override ."' class='terminus_google_map ". $margin_css. "'" . ($width!="" || $map_height!="" ? " style='".$border_css . ($width!="" ? "width:" . $width . ";" : "") . ($map_height!="" ? "height:" . $map_height . ";" : "") . "'" : "") . "></div></div>";

				if ( $scrollwheel == "disable" ) {
					$scrollwheel = 'false';
				} else {
					$scrollwheel = 'true';
				}

					$output .= "<script type='text/javascript'>

						(function($) {

							'use strict';

							var map_$id = null;
							var coordinate_$id;
							var isDraggable = $(document).width() > 641 ? true : $dragging;
							try {
								var map_$id = null;
								var coordinate_$id;
								coordinate_$id=new google.maps.LatLng($lat, $lng);
								var mapOptions = {
									zoom: $zoom,
									center: coordinate_$id,
									scaleControl: true,
									streetViewControl: $streetviewcontrol,
									mapTypeControl: $maptypecontrol,
									panControl: $pancontrol,
									zoomControl: $zoomcontrol,
									scrollwheel: $scrollwheel,
									draggable: isDraggable,
									zoomControlOptions: {
									  style: google.maps.ZoomControlStyle.$zoomcontrolsize
									},";

								if ( $map_style == "" ) {
									$output .= "mapTypeId: google.maps.MapTypeId.$map_type,";
								} else {
									$output .= " mapTypeControlOptions: {
											mapTypeIds: [google.maps.MapTypeId.$map_type, 'map_style']
										}";
								}

								$output .= "};";

								if ( $map_style !== "" ) {
									$output .= 'var styles = '. rawurldecode(strip_tags($map_style)) .';
										var styledMap = new google.maps.StyledMapType(styles, { name: "'. esc_html__('Styled Map', 'terminus') .'" });';
								}

								$output .= "var map_$id = new google.maps.Map(document.getElementById('$id'), mapOptions);";

								if ( $map_style !== "" ) {
									$output .= "map_$id.mapTypes.set('map_style', styledMap);
											 map_$id.setMapTypeId('map_style');";
								}

								if ( $marker_lat != "" && $marker_lng != "" ) {

									$output .= "
										var marker_$id = new google.maps.Marker({
										position: new google.maps.LatLng($marker_lat, $marker_lng),
										animation:  google.maps.Animation.DROP,
										map: map_$id,
										icon: '". $icon_url ."'
									});

									google.maps.event.addListener(marker_$id, 'click', Terminus_VC_ToggleBounce);";

									if ( trim($content) !== "" ) {
										$output .= "var infowindow = new google.maps.InfoWindow();
											infowindow.setContent('<div class=\"map_info_text\" style=\'color:#000;\'>".trim(preg_replace('/\s+/', ' ', do_shortcode($content)))."</div>');";

										$output .= "google.maps.event.addListener(marker_$id, 'click', function() {
												infowindow.open(map_$id,marker_$id);
											});";

									}

								}

								$output .= "}
							catch(e){};

								jQuery(document).ready(function($){
									google.maps.event.trigger(map_$id, 'resize');
									$(window).resize(function(){
										google.maps.event.trigger(map_$id, 'resize');
										if(map_$id!=null)
											map_$id.setCenter(coordinate_$id);
									});
								});

								$(window).load(function(){
									setTimeout(function(){
										$(window).trigger('resize');
									},200);
								});

								function Terminus_VC_ToggleBounce() {
								  if (marker_$id.getAnimation() != null) {
									marker_$id.setAnimation(null);
								  } else {
									marker_$id.setAnimation(google.maps.Animation.BOUNCE);
								  }
								}

						})(jQuery);
				</script>";

				$output .= '</div>';

				return $output;

			}

		}

	}

	new terminus_google_maps();

}