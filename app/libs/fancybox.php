<?php if (function_exists('javascript_include_tag')) { ?>
	<?= javascript_include_tag('fancybox/jquery.mousewheel-3.0.4.pack') ?>
	<?= javascript_include_tag('fancybox/jquery.fancybox-1.3.4.pack') ?>
	<?= stylesheet_link_tag('fancybox/jquery.fancybox-1.3.4') ?>
<?php } ?>
<?php
	/* Clase FancyBox
	 * Esta clase contiene métodos para aplicar funcionalidades con Ajax
	 * 
	 * Autor: Ramiro Vera(raalveco) y Carlos Lizaola(clizaola)
	 * Company: Amecasoft S.A. de C.V. (México)
	 * Fecha: 12/08/2011
	 * 
	 * NOTA: Esta clase esta diseñada para funcionar como libreria en el Kumbia PHP Spirit 1.0
	 * 
	*/
	
	/*
	 * Opciones:
	 * 
	 *	padding = 10 					Space between FancyBox wrapper and content
	 *	margin = 2						Space between viewport and FancyBox wrapper
	 *	opacity = false					When true, transparency of content is changed for elastic transitions
	 *	modal = false					When true, 'overlayShow' is set to 'true' and 'hideOnOverlayClick', 'hideOnContentClick', 'enableEscapeButton', 'showCloseButton' are set to 'false'
	 *	cyclic = false					When true, galleries will be cyclic, allowing you to keep pressing next/back.
	 *	scrolling = 'auto'				Set the overflow CSS property to create or hide scrollbars. Can be set to 'auto', 'yes', or 'no'
	 *	width = 560						Width for content types 'iframe' and 'swf'. Also set for inline content if 'autoDimensions' is set to 'false'
	 *	height = 340					Height for content types 'iframe' and 'swf'. Also set for inline content if 'autoDimensions' is set to 'false'
	 *	autoScale = true				If true, FancyBox is scaled to fit in viewport
	 *	autoDimensions = true			For inline and ajax views, resizes the view to the element recieves. Make sure it has dimensions otherwise this will give unexpected results
	 *	centerOnScroll = false			When true, FancyBox is centered while scrolling page
	 *	ajax = {}						Ajax options. Note: 'error' and 'success' will be overwritten by FancyBox
	 *	swf = {wmode: 'transparent'}	Params to put on the swf object
	 *	hideOnOverlayClick = true		If true, FancyBox is scaled to fit in viewport
	 *	hideOnContentClick = false		For inline and ajax views, resizes the view to the element recieves. Make sure it has dimensions otherwise this will give unexpected results
	 *	overlayShow = true				When true, FancyBox is centered while scrolling page
	 *	overlayOpacity = 0.3			Ajax options. Note: 'error' and 'success' will be overwritten by FancyBox
	 *	overlayColor = '#666'			Params to put on the swf object
	 
	 *	titleShow = true				Toggle title
	 *	titlePosition = 'outside'		The position of title. Can be set to 'outside', 'inside' or 'over'
	 *	titleFormat = null				Callback to customize title area. You can set any html - custom image counter or even custom navigation
	 *	transitionIn = 'fade'			The transition type. Can be set to 'elastic', 'fade' or 'none'
	 *	transitionOut = 'fade'			The transition type. Can be set to 'elastic', 'fade' or 'none'
	 
	 *	speedIn = 300					Speed of the fade and elastic transitions, in milliseconds
	 *	speedOut = 300					Speed of the fade and elastic transitions, in milliseconds
	 *	showCloseButton = true			Toggle close button
	 *	showNavArrows = true			Toggle navigation arrows
	 *	enableEscapeButton = true		Toggle if pressing Esc button closes FancyBox
	 
	 *	onStart = null					Will be called right before attempting to load the content
	 *	onCancel = null					Will be called after loading is canceled
	 *	onComplete = null				Will be called once the content is displayed
	 *	onCleanup = null				Will be called just before closing
	 *	onClosed = null					Will be called once FancyBox is closed
	*/
	
	Load::lib("html");
	
	class FancyBox{
		private $opciones; 
		private $id;
		private $tipo;
		
		public function FancyBox($tipo = "imagen", $opciones = null){
			if(is_array($tipo)){
				$opciones = $tipo;
				$tipo = "imagen";
			}
			else{
				if($tipo == "imagen" && $opciones == null){
					$opciones = array("transitionIn" => "none", "transitionOut" => "none");
				}
				
				if($tipo == "galeria" && $opciones == null){
					$opciones = array("transitionIn" => "none", "transitionOut" => "none");
				}
				
				if($tipo == "inline" && $opciones == null){
					$opciones = array("transitionIn" => "none", "transitionOut" => "none");
				}
				
				if($tipo == "ajax" && $opciones == null){
					$opciones = array("transitionIn" => "none", "transitionOut" => "none");
				}
				
				if($tipo == "iframe" && $opciones == null){
					$opciones = array("transitionIn" => "none", "transitionOut" => "none");
				}
			}
			
			if($opciones == null){
				$opciones = array("transitionIn" => "none", "transitionOut" => "none");
			}
			
			$this -> opciones = $opciones;
			$this -> id = rand(0,99999);
			
			$this -> tipo = $tipo;
			
			if($tipo == "imagen"){
				$js = '<script type="text/javascript">
					$(document).ready(function(){
						$("a#fancybox'.$this -> id.'").fancybox(
						'.json_encode($this -> opciones).'
						);
					});
				</script>';
			}
			
			if($tipo == "galeria"){
				$this -> opciones["titleFormat"] = 'function(title, currentArray, currentIndex, currentOpts) {return \'<span id="fancybox-title-over">Image \' + (currentIndex + 1) + \' / \' + currentArray.length + (title.length ? \' &nbsp; \' + title : \'\') + \'</span>\';}'; 
				$this -> opciones["cyclic"] = true;
				$js = 	'<script type="text/javascript">
							$(document).ready(function() {
								$("a[rel=fancybox'.$this -> id.']").fancybox(
									'.json_encode($this -> opciones).'
								);
							});
						</script>';
			}
			
			if($tipo == "iframe"){
				$this -> opciones["type"] = "iframe";
				$js = '<script type="text/javascript">
					$(document).ready(function(){
						$("a#fancybox'.$this -> id.'").fancybox(
						'.json_encode($this -> opciones).'
						);
					});
				</script>';
			}
				
			echo $js;
		}
		
		public function galeria($imagen, $thumbnail,$titulo = "", $width = 0, $height = 0){
			if(strpos($imagen,"http://")===false){
				$imagen = "img/{$imagen}";
			}
			return Html::link($imagen,Html::imagen($thumbnail,$titulo,$width,$height),"title: ".$titulo,"rel: fancybox".$this -> id);
		}
		
		public function imagen($imagen, $thumbnail,$titulo = "", $width = 0, $height = 0){
			if(strpos($imagen,"http://")===false){
				$imagen = "img/{$imagen}";
			}
			return Html::link($imagen,Html::imagen($thumbnail,$titulo,$width,$height),"title: ".$titulo,"id: fancybox".$this -> id);
		}
		
		public function inline($id, $titulo, $texto=""){
			if($texto == ""){
				$texto = $titulo;
			}
			
			return Html::link("#".$id,$texto,"title: ".$titulo,"id: fancybox".$this -> id);
		}
		
		public function ajax($accion, $texto, $titulo=""){
			return Html::link($accion,$texto,"title: ".$titulo,"id: fancybox".$this -> id);
		}	
		
		public function iframe($accion, $texto, $titulo=""){
			return Html::link($accion,$texto,"title: ".$titulo,"id: fancybox".$this -> id);
		}
		
		public function swf($accion, $texto, $titulo=""){
			return Html::link($accion,$texto,"title: ".$titulo,"id: fancybox".$this -> id);
		}		
		
		private function js(){
			
			return $js;
		}
	}
?>