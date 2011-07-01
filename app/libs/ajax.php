<?php
	/* Clase Ajax
	 * Esta clase contiene métodos para aplicar funcionalidades con Ajax
	 * 
	 * Autor: Ramiro Vera
	 * Company: Amecasoft S.A. de C.V. (México)
	 * Fecha: 04/06/2011
	 * 
	 * NOTA: Esta clase esta diseñada para funcionar como libreria en el Kumbia PHP Spirit 1.0
	 * 
	 */
	class Ajax{
		
		public static function formularioInicio($accion, $contenedor="ajax",$referencia=0){
			$params = is_array($accion) ? $accion : Util::getParams(func_get_args());

            $params["enctype"] = "multipart/form-data";
            
            if($referencia==0) $referencia = rand(0,999999);
            
            $params["name"] = "f".$referencia;
            $params["id"] = "f".$referencia;
            
            $opciones = 'target: "#'.$contenedor.'"';
            
            if(isset($params["success"])){
                $opciones .= ', success: function() { '.$params["success"].' }';
            }
            
            if(isset($params["before"])){
                $opciones .= ', beforeSubmit: function() { '.$params["before"].' }';
            }
            
            $code = '<script type="text/javascript"> $.metadata.setType("attr", "validate"); $(document).ready(function() { $("#'.$params["id"].'").validate({});  $("#'.$params["id"].'").ajaxForm({ '.$opciones.' }); }); </script>';
            $code .= form_tag($params);
            
            return $code;
		}
		
		public static function formularioFin(){
            return end_form_tag();
        }
		
		public static function link($href, $texto, $contenedor){
			if(strpos($href, "http://") !== 0){
				$href = get_kumbia_url($href);	
			}
			return '<a rel="#'.$contenedor.'" class="jsRemote" href="'.$href.'">'.$texto.'</a>';
        }
		
		public static function toggle($texto, $contenedor){
            return '<a rel="#'.$contenedor.'" class="jsToggle" href="#">'.$texto.'</a>';
        }
		
		public static function hide($texto, $contenedor){
            return '<a rel="#'.$contenedor.'" class="jsHide" href="#">'.$texto.'</a>';
        }
		
		public static function show($texto, $contenedor){
            return '<a rel="#'.$contenedor.'" class="jsShow" href="#">'.$texto.'</a>';
        }
		
		public static function actualizador($accion, $contenedor="ajax", $tiempo=5000){
			$accion = get_kumbia_url($accion);
			
			$js = '<script>
						$(document).ready(function() {
							$("#'.$contenedor.'").load("'.$accion.'");
   							var refreshId = setInterval(
   								function() {
      								$("#'.$contenedor.'").load("'.$accion.'");
   								},
   								'.$tiempo.'
							);
   							$.ajaxSetup({ cache: false });
						});
				  </script>';
				  
			return $js;
		}
	}
?>