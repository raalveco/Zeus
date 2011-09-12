<?php if (function_exists('javascript_include_tag')) { ?>
	<?= javascript_include_tag("jcrop/jquery.jcrop.min") ?>
	<?= javascript_include_tag("jcrop/jquery.jcrop.extras") ?>
	<?= javascript_include_tag("jcrop/jquery.color") ?>
	<?= stylesheet_link_tag('jcrop/jquery.jcrop') ?>
<?php } ?>
<?php
	/* Clase Jcrop
	 * Esta clase contiene métodos para recortar imagenes.
	 * 
	 * Autor: Ramiro Vera(raalveco) y Carlos Lizaola(clizaola)
	 * Company: Amecasoft S.A. de C.V. (México)
	 * Fecha: 16/08/2011
	 * 
	 * NOTA: Esta clase esta diseñada para funcionar como libreria en el Kumbia PHP Spirit 1.0
	 * 
	*/
	
	class JCrop{
		public static function cortar($origen, $destino, $x, $y, $w, $h, $cuadro= true, $wf = 150, $hf = 150){
			$jpeg_quality = 100;
			
			$src = APP_PATH."public/img/".$origen;
			$mini = APP_PATH."public/img/".$destino;
			
			if(file_exists($mini)){
				unlink($mini);
			}
			
			if(!$cuadro){
				$wf = $w;
				$hf = $h;
			}
			
			$ext = substr($src,strlen($src)-3,3);
			
			if($ext == "png"){
				$img_r = imagecreatefrompng($src);
			}
			else{
				$img_r = imagecreatefromjpeg($src);
			}
			
			$dst_r = ImageCreateTrueColor( $wf, $hf );
			
			imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$wf,$hf,$w,$h);
			
			imagejpeg($dst_r,$mini,$jpeg_quality);
		}
		
		public static function imagen($imagen, $alt="", $radio = true){
			$params = is_array($imagen) ? $imagen : Util::getParams(func_get_args());
			
			if($alt != "") {
				$params["alt"] = str_replace(":", "###", $alt);
				$params["title"] = str_replace(":", "###", $alt);
			}
			
			$params["border"] = "0";
			
			if($radio){
				$params["id"] = "jcrop";	
			}
			else{
				$params["id"] = "jcropRECTANGULO";
			}
			
			$code = str_replace("###", ":", img_tag($params));
			
			$code .= '<input type="hidden" size="4" id="imagen" name="imagen" value="'.$imagen.'" /> 
            			<input type="hidden" size="4" id="x1" name="x1" />
						<input type="hidden" size="4" id="y1" name="y1" /> 
						<input type="hidden" size="4" id="x2" name="x2" /> 
						<input type="hidden" size="4" id="y2" name="y2" /> 
						<input type="hidden" size="4" id="w" name="w" /> 
						<input type="hidden" size="4" id="h" name="h" />';
			
			return $code;
			
			
		}
		
		public static function previa($imagen, $alt="Previsualización", $w=100, $h=100){
			return '<div style="width:'.$w.'px;height:'.$h.'px;overflow:hidden;">'.img_tag($imagen,$alt,"id: preview").'</div>';
		}
	}
?>