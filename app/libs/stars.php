<?php if (function_exists('javascript_include_tag')) { ?>
	<?= javascript_include_tag("stars/jquery.ui.stars.min") ?>
	<?= stylesheet_link_tag('stars/jquery.ui.stars.min') ?>
<?php } ?>
<?php
	/* Clase Stars
	 * Esta clase contiene métodos para recortar imagenes.
	 * 
	 * Autor: Ramiro Vera(raalveco) y Carlos Lizaola(clizaola)
	 * Company: Amecasoft S.A. de C.V. (México)
	 * Fecha: 18/08/2011
	 * 
	 * NOTA: Esta clase esta diseñada para funcionar como libreria en el Kumbia PHP Spirit 1.0
	 * 
	*/
	
	class Stars{
		public static function rating($href, $m, $s=0, $promedio=0,$mensaje = "Tu voto ha sido contabilizado, Gracias!!"){
			$tmp = rand(0,100000);
			
			$html = '<div id="stars'.$tmp.'"><select name="xyz">';
			
			if($s==5){
				$html .= '<option value="0.20" '.($promedio == 0.20 ? "SELECTED" : "").'>0.20</option>';
				$html .= '<option value="0.40" '.($promedio == 0.40 ? "SELECTED" : "").'>0.40</option>';
				$html .= '<option value="0.60" '.($promedio == 0.60 ? "SELECTED" : "").'>0.60</option>';
				$html .= '<option value="0.80" '.($promedio == 0.80 ? "SELECTED" : "").'>0.80</option>';
			}
			
			if($s==4){
				$html .= '<option value="0.25" '.($promedio == 0.25 ? "SELECTED" : "").'>0.25</option>';
				$html .= '<option value="0.50" '.($promedio == 0.50 ? "SELECTED" : "").'>0.50</option>';
				$html .= '<option value="0.75" '.($promedio == 0.75 ? "SELECTED" : "").'>0.75</option>';
			}
			
			if($s==3){
				$html .= '<option value="0.33" '.($promedio == 0.33 ? "SELECTED" : "").'>0.33</option>';
				$html .= '<option value="0.67" '.($promedio == 0.67 ? "SELECTED" : "").'>0.67</option>';
			}
			
			if($s==2){
				$html .= '<option value="0.50" '.($promedio == 0.50 ? "SELECTED" : "").'>0.50</option>';
			}
			
			for($i=1;$i<$m;$i+=1){
				if($s==5){
					$html .= '<option value="'.$i.'.00" '.($promedio == $i + 0.00 ? "SELECTED" : "").'>'.$i.'.00</option>';
					$html .= '<option value="'.$i.'.20" '.($promedio == $i + 0.20 ? "SELECTED" : "").'>'.$i.'.20</option>';
					$html .= '<option value="'.$i.'.40" '.($promedio == $i + 0.40 ? "SELECTED" : "").'>'.$i.'.40</option>';
					$html .= '<option value="'.$i.'.60" '.($promedio == $i + 0.60 ? "SELECTED" : "").'>'.$i.'.60</option>';
					$html .= '<option value="'.$i.'.80" '.($promedio == $i + 0.80 ? "SELECTED" : "").'>'.$i.'.80</option>';
				}
				
				if($s==4){
					$html .= '<option value="'.$i.'.00" '.($promedio == $i + 0.00 ? "SELECTED" : "").'>'.$i.'.00</option>';
					$html .= '<option value="'.$i.'.25" '.($promedio == $i + 0.25 ? "SELECTED" : "").'>'.$i.'.25</option>';
					$html .= '<option value="'.$i.'.50" '.($promedio == $i + 0.50 ? "SELECTED" : "").'>'.$i.'.50</option>';
					$html .= '<option value="'.$i.'.75" '.($promedio == $i + 0.75 ? "SELECTED" : "").'>'.$i.'.75</option>';
				}
				
				if($s==3){
					$html .= '<option value="'.$i.'.00" '.($promedio == $i + 0.00 ? "SELECTED" : "").'>'.$i.'.00</option>';
					$html .= '<option value="'.$i.'.33" '.($promedio == $i + 0.33 ? "SELECTED" : "").'>'.$i.'.33</option>';
					$html .= '<option value="'.$i.'.67" '.($promedio == $i + 0.67 ? "SELECTED" : "").'>'.$i.'.67</option>';
				}
				
				if($s==2){
					$html .= '<option value="'.$i.'.00" '.($promedio == $i + 0.00 ? "SELECTED" : "").'>'.$i.'.00</option>';
					$html .= '<option value="'.$i.'.50" '.($promedio == $i + 0.50 ? "SELECTED" : "").'>'.$i.'.50</option>';
				}
				
				if($s==0 || $s==1){
					$html .= '<option value="'.$i.'" '.($promedio == $i ? "SELECTED" : "").'>'.$i.'</option>';
				}
			}
			
			$html .= '<option value="'.$m.'" '.($promedio == $m ? "SELECTED" : "").'>'.$m.'</option>';
			
			if(strpos($href, "http://") !== 0){
				$href = get_kumbia_url($href);	
			}
			
			$html .= '</select></div>';
			
			$html .= '<script type="text/javascript"> 
				$(function(){
					$("#stars'.$tmp.'").stars({
						split: '.$s.',
						cancelShow: false,
						oneVoteOnly: true,
						inputType: "select",
						callback: function(ui, type, value)
						{
							$("#xyz").load("'.$href.'");
							alert("'.$mensaje.'");
						}
					});
							
				});
			</script>';
			
			return $html;
		}
	}
?>