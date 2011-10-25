<?php
	/* Clase Google
	* Esta clase contiene diferentes metodos que llaman a la API de Google Maps	
	* 
	* Autor: Ramiro Vera(raalveco) y Carlos Lizaola(clizaola)
	* Company: Amecasoft S.A. de C.V. (México)
	* Fecha: 04/06/2011
	* 
	* NOTA: Esta clase esta diseñada para funcionar como libreria en el Kumbia PHP Spirit 1.0
	* 
	*/
	
	echo '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>';
	
	class GoogleMaps{
		static $tipo_mapa = "ROADMAP"; //ROADMAP, SATELLITE, HYBRID, TERRAIN
		static $x_centro = 20.5419;
		static $y_centro = -104.0459;
		static $zoom = 14;
		static $width = 500;
		static $height = 500;
		
		public $marcadores;
		public $nm;
		
		public function GoogleMaps($x = false, $y = false, $zoom = false, $w = false, $h = false){
			if($x) self::$x_centro = $x;
			if($y) self::$y_centro = $y;
			if($zoom) self::$zoom = $zoom;
			if($w) self::$width = $w;
			if($h) self::$height = $h; 
			
			$this -> marcadores = array();
			$this -> nm = 0;
		}
		
		public function addMarker($x, $y, $html = ""){
			$this -> marcadores[$this -> nm++] = new GMarker($x, $y, $html);	
		}
		
		public function render(){
			$code = '<script type="text/javascript">
						function initialize() {
							var center = new google.maps.LatLng('.self::$x_centro.', '.self::$y_centro.');
			    			var myOptions = {
			      				zoom: '.self::$zoom.',
			      				center: center,
			      				mapTypeId: google.maps.MapTypeId.'.self::$tipo_mapa.'
			    			};
							
							var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
							';
			$mk = 0;
			if($this -> marcadores) foreach($this -> marcadores as $marcador){ $mk++;
				$code .= '	var marker'.$mk.' = new google.maps.Marker({
								position: new google.maps.LatLng('.$marcador -> x.', '.$marcador -> y.'), 
								map: map,
								draggable: false
							});
							';
					
				$code .= $marcador -> html ? '	var infowindow'.$mk.' = new google.maps.InfoWindow({ content: \''.$marcador -> html.'\'});
						google.maps.event.addListener(marker'.$mk.', "click", function() {
				   			infowindow'.$mk.'.open(map,marker'.$mk.');
				  		});' : '';
			}
							
			$code .= '}
					
					</script>
					<script type="text/javascript">window.onload = initialize;</script>';
			
			
			$code .= '<div id="map_canvas" style="width:'.self::$width.'px; height:'.self::$height.'px"></div>';
			
			return $code;
		}
		
		public static function input($nombre, $x = false, $y = false, $zoom = false, $w = 500, $h = 500){
			Load::lib("formulario");
			
			$code = '<script type="text/javascript">
						function initialize() {
							var center = new google.maps.LatLng('.self::$x_centro.', '.self::$y_centro.');
			    			var myOptions = {
			      				zoom: '.($zoom ? $zoom : self::$zoom).',
			      				center: center,
			      				mapTypeId: google.maps.MapTypeId.'.self::$tipo_mapa.'
			    			};
							
							var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
							';
			
			if($x || $y){
							
				$code .= '	var marker = new google.maps.Marker({
								position: new google.maps.LatLng('.$x.', '.$y.'), 
								map: map,
								draggable: true
							});
							';
			
			}
			else{
				
				$code .= '	var marker = null;
							google.maps.event.addListener(map, "click", function(objeto) {
								marker = new google.maps.Marker({
									position: objeto.latLng, 
									map: map,
									draggable: true
								});
								
								document.getElementById("'.$nombre.'").value = objeto.latLng;
								
								google.maps.event.clearListeners(map, "click");
								
								google.maps.event.addListener(marker, "drag", function() {
									document.getElementById("'.$nombre.'").value = marker.getPosition();
								});
							});
							';	
				
			}
							
			$code .= '		google.maps.event.addListener(marker, "drag", function() {
								document.getElementById("'.$nombre.'").value = marker.getPosition();
							});
						}
					</script>
					<script type="text/javascript">window.onload = initialize;</script>';
			
			
			
			$code .= Formulario::texto($nombre,$x || $y ? "(".$x.", ".$y.")" : "","style: visibility: hidden;");
			
			$code .= '<div id="map_canvas" style="width:'.$w.'px; height:'.$h.'px"></div>';
			
			return $code;
		}

		public static function output($x, $y, $html = "", $zoom = false, $w = 500, $h = 500){
			$code = '<script type="text/javascript">
						function initialize() {
							var center = new google.maps.LatLng('.self::$x_centro.', '.self::$y_centro.');
			    			var myOptions = {
			      				zoom: '.($zoom ? $zoom : self::$zoom).',
			      				center: center,
			      				mapTypeId: google.maps.MapTypeId.'.self::$tipo_mapa.'
			    			};
							
							var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
							';
							
			$code .= '	var marker = new google.maps.Marker({
								position: new google.maps.LatLng('.$x.', '.$y.'), 
								map: map,
								draggable: false
							});
							';
					
			$code .= $html ? '	var infowindow = new google.maps.InfoWindow({ content: \''.$html.'\'});
						google.maps.event.addListener(marker, "click", function() {
				   			infowindow.open(map,marker);
				  		});' : '';
							
			$code .= '}
					
					</script>
					<script type="text/javascript">window.onload = initialize;</script>';
			
			
			$code .= '<div id="map_canvas" style="width:'.$w.'px; height:'.$h.'px"></div>';
			
			return $code;
		}
	}

	class GMarker{
		public $x;
		public $y;
		public $html = "";
		
		public function GMarker($x, $y, $html = ""){
			$this -> x = $x;
			$this -> y = $y;
			$this -> html = $html;
		}
	}
?>