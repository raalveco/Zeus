<?php
	/* Clase Formulario
	 * Esta clase contiene diferentes metodos que regresan el código html para crear formularios e inputs de manera sencilla.
	 * 
	 * Autor: Ramiro Vera
	 * Company: Amecasoft S.A. de C.V. (México)
	 * Fecha: 04/06/2011
	 * 
	 * NOTA: Esta clase esta diseñada para funcionar como libreria en el Kumbia PHP Spirit 1.0
	 * 
	 */
	class Formulario{
		
		public static function inicio($accion,$x=0){
			$params = is_array($accion) ? $accion : Util::getParams(func_get_args());
			
			$params["enctype"] = "multipart/form-data";
            
			if($x==0) $x = rand(0,9999999);
            
            $params["name"] = "f".$x;
            $params["id"] = "f".$x;
            
            $opciones = '';
            
            if(isset($params["success"])){
                $opciones .= ', success: function() { '.$params["success"].' }';
            }
            
            if(isset($params["before"])){
                $opciones .= ', beforeSubmit: function() { '.$params["before"].' }';
            }
            
            $code = '<script type="text/javascript"> $.metadata.setType("attr", "validate"); $(document).ready(function() { $("#'.$params["id"].'").validate({}); }); </script>';
            $code .= form_tag($params);
			
            return $code;
		}
		
		public static function inicioAjax($accion, $contenedor,$referencia=0){
			$params = is_array($accion) ? $accion : Util::getParams(func_get_args());

            $params["enctype"] = "multipart/form-data";
            
            if($referencia==0) $referencia = rand(0,9999999);
            
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
		
		public static function fin(){
            return end_form_tag();
        }
        
        public static function submit($texto){
            $params = is_array($texto) ? $texto : Util::getParams(func_get_args());

            $params["value"] = $params[0];

            return submit_tag($params);
        }
        
        public static function imagen($alt, $src){
            $params = is_array($alt) ? $alt : Util::getParams(func_get_args());
            
            $params["alt"] = $params[0];
            $params["title"] = $params[0];
            
            return submit_image_tag($params);
        }
        
        public static function reset($texto){
            $params = is_array($texto) ? $texto : Util::getParams(func_get_args());

            $params["value"] = $params[0];

            return xhtml_tag('input', $params, 'type: reset');
        }
        
        public static function cancelar($texto,$accion){
            $params = is_array($texto) ? $texto : Util::getParams(func_get_args());

            $params["value"] = $params[0];
            $params["onclick"] = "direccionar('".PUBLIC_PATH.$params[1]."');";

            return button_tag($params);
        }
        
		public static function boton($texto,$onclick = ""){
	        $params = is_array($texto) ? $texto : Util::getParams(func_get_args());

            $params["value"] = $params[0];
			$params["onclick"] = $onclick;

            return button_tag($params);
        }
        
        public static function texto($nombre, $valor=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = utf8_encode($valor);
            
            if(!isset($params['onblur'])) {
        		$params['onblur'] = "texto(this)";
        	} else {
        		$params['onblur'].=";texto(this)";
        	}
            
            return @text_field_tag($params);
        }
        
        public static function mayusculas($nombre, $valor=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = utf8_encode(strtoupper($valor));
            
            if(!isset($params['onblur'])) {
        		$params['onblur'] = "texto(this)";
        	} else {
        		$params['onblur'].=";texto(this)";
        	}
            
            return @textupper_field_tag($params);
        }
        
        public static function password($nombre, $valor=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = utf8_encode($valor);
            
            if(!isset($params['onblur'])) {
        		$params['onblur'] = "texto(this)";
        	} else {
        		$params['onblur'].=";texto(this)";
        	}
            
            return @password_field_tag($params);
        }
        
        public static function numerico($nombre, $valor=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = $valor;
            
            if(!isset($params['onblur'])) {
        		$params['onblur'] = "numerico(this)";
        	} else {
        		$params['onblur'].=";numerico(this)";
        	}
            
            return @numeric_field_tag($params);
        }
        
        public static function dinero($nombre, $valor=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = "$ ".number_format($valor,2);
            
            if(!isset($params['onblur'])) {
        		$params['onblur'] = "dinerito(this)";
        	} else {
        		$params['onblur'].=";dinerito(this)";
        	}
            
            return @numeric_field_tag($params);
        }
        
        public static function fecha($nombre,$valor="",$formato="dd/mm/yy",$min=false,$max=false){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = utf8_encode($valor);
            
            if(strpos($min,"-")>0 || strpos($min,"/")>0){
                if(strpos($min,"-")>0){
                    $fm = mktime(0,0,0,substr($min,5,2),substr($min,8,2),substr($min,0,4));
                }
                else{
                    $fm = mktime(0,0,0,substr($min,3,2),substr($min,0,2),substr($min,6,4));
                }
                
                $min = (mktime(0,0,0,date("m"),date("d"),date("Y")) - $fm) / 60 / 60 / 24 ;
                 
            }
            
            if(strpos($max,"-")>0 || strpos($max,"/")>0){
                if(strpos($max,"-")>0){
                    $fm = mktime(0,0,0,substr($max,5,2),substr($max,8,2),substr($max,0,4));
                }
                else{
                    $fm = mktime(0,0,0,substr($max,3,2),substr($max,0,2),substr($max,6,4));
                }
                
                $max = ($fm - mktime(0,0,0,date("m"),date("d"),date("Y"))) / 60 / 60 / 24 ;
                 
            }
            
            $code = "<script type='text/javascript'>
                        $(function() {
                            $( '#".$nombre."' ).datepicker({
                                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            			        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
                                dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                                changeMonth: true,
								changeYear: true,
                                ".($min!==false ? "minDate: -".$min."," : "")."
                                ".($max!==false ? "maxDate: ".$max."," : "")."
                                dateFormat: '".$formato."' 
                            });
                       	});
                      </script>";
                      
                      return $code.text_field_tag($params);
        }
        
        public static function hora($nombre,$inicio="00:00",$fin="23:59",$intervalo=15,$seleccion=""){
        	$hi = strpos($inicio,":") > 0 ? substr($inicio,0,strpos($inicio,":")) : $inicio;
        	$mi = strpos($inicio,":") > 0 ? substr($inicio,strpos($inicio,":")+1) : 0;
        	$inicio = $hi * 60 + $mi;
        	
        	$hf = strpos($fin,":") > 0 ? substr($fin,0,strpos($fin,":")) : $fin;
        	$mf = strpos($fin,":") > 0 ? substr($fin,strpos($fin,":")+1) : 0;
        	$fin = $hf * 60 + $mf;
        	
        	$opciones = array();
        	
            for($i = $inicio ; $i <= $fin ; $i += $intervalo){
            	$h = floor($i / 60); $h = $h < 10 ? "0".$h : $h;
            	$m = $i % 60; $m = $m < 10 ? "0".$m : $m;
            	$opciones[$h.":".$m] = $h.":".$m;
            }
            
            return Formulario::select($nombre,$opciones,$seleccion);
        }
        
        public static function archivo($nombre, $valor=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = utf8_encode($valor);
            
            return file_field_tag($params);
        }
        
        public static function checkbox($nombre, $activo = 0){
        	return '<input type="checkbox" name="'.$nombre.'" '.($activo ? "CHECKED" : "").'>';
        }
        
        public static function select($nombre, $opciones=array(), $seleccion=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["selected"] = $seleccion;
            
            return select_tag($params);
        }
        
        public static function selectModelo($nombre, $registros, $opcion="id", $valor="id", $seleccion=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["selected"] = $seleccion;
            
            $tmp = array();
            
            $bandera = true;
            
            $tmp[""] = "...";
            
            if($registros) foreach($registros as $registro){
                $tmp[$registro -> {$valor}] = $registro -> {$opcion};
                if($seleccion == $registro -> {$valor} && $seleccion != 0){
                    $bandera = false;
                }
            }
            
            if($bandera) $tmp[""] = "";
            
            $params[1] = $tmp;
            
            return select_tag($params);
        }
        
        public static function selectEstados($nombre, $valor=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["selected"] = $valor;
            
            $params[1] = array(
            	"" => "",
                "AGUASCALIENTES" => "AGUASCALIENTES",
                "BAJA CALIFORNIA" => "BAJA CALIFORNIA",
                "BAJA CALIFORNIA SUR" => "BAJA CALIFORNIA SUR",
                "CAMPECHE" => "CAMPECHE",
                "CHIAPAS" => "CHIAPAS",
                "CHIHUAHUA" => "CHIHUAHUA",
                "COAHUILA" => "COAHUILA",
                "COLIMA" => "COLIMA",
                "DISTRITO FEDERAL" => "DISTRITO FEDERAL",
                "DURANGO" => "DURANGO",
                "ESTADO DE MÉXICO" => "ESTADO DE MÉXICO",
                "GUANAJUATO" => "GUANAJUATO",
                "GUERRERO" => "GUERRERO",
                "HIDALGO" => "HIDALGO",
                "JALISCO" => "JALISCO",
                "MICHOACÁN" => "MICHOACÁN",
                "MORELOS" => "MORELOS",
                "NAYARIT" => "NAYARIT",
                "NUEVO LEÓN" => "NUEVO LEÓN",
                "OAXACA" => "OAXACA",
                "PUEBLA" => "PUEBLA",
                "QUERÉTARO" => "QUERÉTARO",
                "QUINTANA ROO" => "QUINTANA ROO",
                "SAN LUIS POTOSÍ" => "SAN LUIS POTOSÍ",
                "SINALOA" => "SINALOA",
                "SONORA" => "SONORA",
                "TABASCO" => "TABASCO",
                "TAMAULIPAS" => "TAMAULIPAS",
                "TLAXCALA" => "TLAXCALA",
                "VERACRUZ" => "VERACRUZ",
                "YUCATÁN" => "YUCATÁN",
                "ZACATECAS" => "ZACATECAS"
            );
            
            return select_tag($params);
        }
        
        public static function selectMes($nombre, $valor=""){
            $params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["selected"] = $valor;
            
            $params[1] = array(
                "01" => "ENERO",
                "02" => "FEBRERO",
                "03" => "MARZO",
                "04" => "ABRIL",
                "05" => "MAYO",
                "06" => "JUNIO",
                "07" => "JULIO",
                "08" => "AGOSTO",
                "09" => "SEPTIEMBRE",
                "10" => "OCTUBRE",
                "11" => "NOVIEMBRE",
                "12" => "DICIEMBRE"
            );
            
            return select_tag($params);
        }
        
        public static function autocomplete($nombre, $opciones, $valor=""){
        	$params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = utf8_encode($valor);
            
            if(!isset($params['onblur'])) {
        		$params['onblur'] = "texto(this)";
        	} else {
        		$params['onblur'].=";texto(this)";
        	}
        	
        	if(!isset($params["case"])){
        		$params["case"] = "minusculas";
        	}
        	
        	$x = count($opciones);
        	$tmp = '';
        	if($opciones) foreach($opciones as $opcion){
        		$x--; 
        		$tmp .= '"'.$opcion.' "'.($x != 0 ? ',' : '');
        	} 
        	
        	$code = '<script>
						$(function() {

			        		var available'.$nombre.' = [
			
			                    '.$tmp.'
			
			        		];
			
			        		$( "#'.$nombre.'" ).autocomplete({
			
			        			source: available'.$nombre.'
			
			        		});
			
			        	});
					</script><div class="ui-widget">'.($params["case"]=="mayusculas" ? textupper_field_tag($params) : text_field_tag($params)).'</div>';
        	
        	return $code;
        }
        
        public static function autocompleteModelo($nombre, $opciones, $opcion="id", $valor=""){
        	$params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
            
            $params["value"] = utf8_encode($valor);
            
            if(!isset($params['onblur'])) {
        		$params['onblur'] = "texto(this)";
        	} else {
        		$params['onblur'].=";texto(this)";
        	}
        	
        	if(!isset($params["case"])){
        		$params["case"] = "minusculas";
        	}
        	
        	$x = count($opciones);
        	$tmp = '';
        	if($opciones) foreach($opciones as $opc){
        		$x--; 
        		$tmp .= '"'.$opc -> {$opcion}.' "'.($x != 0 ? ',' : '');
        	} 
        	
        	$code = '<script>
						$(function() {

			        		var available'.$nombre.' = [
			
			                    '.$tmp.'
			
			        		];
			
			        		$( "#'.$nombre.'" ).autocomplete({
			
			        			source: available'.$nombre.'
			
			        		});
			
			        	});
					</script><div class="ui-widget">'.($params["case"]=="mayusculas" ? textupper_field_tag($params) : text_field_tag($params)).'</div>';
        	
        	return $code;
        }
        
        public static function textarea($nombre,$valor=""){
        	$params = is_array($nombre) ? $nombre : Util::getParams(func_get_args());
        	
        	$params["name"] = $nombre;
        	$params["id"] = $nombre;
        	
        	return textarea_tag($params);
        }
        
        public static function oculto($nombre, $valor){
            return '<input type="hidden" name="'.$nombre.'" value="'.$valor.'" />';
        }
	}
	
?>