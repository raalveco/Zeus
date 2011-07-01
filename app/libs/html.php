<?php
	/* Clase Html
	* Esta clase contiene diferentes metodos que regresan el código html para crear diferentes tags predefinidos de manera sencilla.	
	* 
	* Autor: Ramiro Vera
	* Company: Amecasoft S.A. de C.V. (México)
	* Fecha: 04/06/2011
	* 
	* NOTA: Esta clase esta diseñada para funcionar como libreria en el Kumbia PHP Spirit 1.0
	* 
	*/
	class Html {
		
		public static function link($accion, $texto) {
			$params = is_array($accion) ? $accion : Util::getParams(func_get_args());
			return  link_to($params);
		}
	
		public static function linkConfirmado($accion, $texto, $mensaje) {
			$params = is_array($accion) ? $accion : Util::getParams(func_get_args());
			$params["onclick"] = "return confirm('" . $mensaje . "');";
			return  link_to($params);
		}
	
		public static function linkAjax($accion, $text, $contenedor) {
			$params = is_array($accion) ? $accion : Util::getParams(func_get_args());
			$params["rel"] = "#" . $contenedor;
			$params["class"] = "jsRemote";
			return  link_to($params);
		}
	
		public static function imagen($imagen, $alt="", $w=0, $h=0) {
			$params = is_array($imagen) ? $imagen : Util::getParams(func_get_args());
			
			if($alt != "") {
				$params["alt"] = str_replace(":", "###", $alt);
				$params["title"] = str_replace(":", "###", $alt);
			}
			if($w != "") {
				$params["width"] = $w;
			}
			if($h != "") {
				$params["height"] = $h;
			}
			$params["border"] = "0";
			
			return  str_replace("###", ":", img_tag($params));
		}
	
		public static function youtube($codigo, $w=662, $h=408) {
			$html = '<object width="' . $w . '" height="' . $h . '">
						<param name="movie" value="http://www.youtube.com/v/' . $codigo . '?fs=1&amp;hl=es_ES"></param>
						<param name="allowFullScreen" value="true"></param>
						<param name="allowscriptaccess" value="always"></param>
						<param name="wmode" value="transparent" />
						<embed wmode="transparent" src="http://www.youtube.com/v/' . $codigo . '?fs=1&amp;hl=es_ES" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $w . '" height="' . $h . '"></embed>
					</object>';
			return $html;
		}
	
		public static function botonJS($texto, $javascript="alert('Hola Mundo');") {
			return '<input type="button" value="' . $texto . '" onclick="' . $javascript . '" />';
		}
		
	}
?>