<?php
	/* Clase Acordeon
	 * Esta clase contiene métodos para configurar y agregar a la aplicación, presentaciones de acordeon con JQuery
	 * 
	 * Autor: Ramiro Vera
	 * Company: Amecasoft S.A. de C.V. (México)
	 * Fecha: 03/07/2011
	 * 
	 * NOTA: Esta clase esta diseñada para funcionar como libreria en el Kumbia PHP Spirit 1.0
	 * 
	 */
	class Acordeon{
		private $referencia;
		
		private $js;
		private $html;
			
		//Variables que modifican el Javascript
		private $iconos = true;
		private $relleno = true;
		private $colapsable = false;
		private $evento = "click";
		private $escalable = false;
		private $wmin = 0;
		private $hmin = 0;
		private $wmax = 0;
		private $hmax = 0;
		private $ordenable = false;
		
		//Variables que modifican el Html
		private $ancho = 300;
		private $alto = 200;
		private $contenedor = true;
		private $secciones = array();
		private $ns = 0;
		
		function Acordeon($ancho = 300, $alto = 200){
			$this -> referencia = rand(0,999999);
			
			$this -> ancho = $ancho;
			$this -> alto = $alto;
			$this -> contenedor = true;
			
			$this -> iconos = true;
			$this -> relleno = false;
			$this -> colapsable = false;
			$this -> evento = "click";
			
			$this -> escalable = false;
			$this -> ordenable = false;
			
			$this -> construirJS();
			$this -> construirHTML();
		}
		
		function ancho($ancho = 0){
			if($ancho == 0){
				return $this -> ancho;
			}
			$this -> ancho = $ancho;
			
			$this -> construirHTML();
		}
		
		function alto($alto = 0){
			if($alto == 0){
				return $this -> alto;
			}
			$this -> alto = $alto;
			
			$this -> construirHTML();
		}
		
		function contenedor($contenedor){
			$this -> contenedor = $contenedor;
			
			$this -> construirHTML();
		}
		
		function iconos($iconos){
			$this -> iconos = $iconos;
			
			$this -> construirJS();
		}
		
		function relleno($relleno){
			$this -> relleno = $relleno;
			
			$this -> construirJS();
		}
		
		function colapsable($colapsable){
			$this -> colapsable = $colapsable;
			
			$this -> construirJS();
		}
		
		function evento($evento){
			$this -> evento = $evento;
			
			$this -> construirJS();
		}
		
		function escalable($escalable, $wmin=200, $hmin=200, $wmax=600, $hmax=600){
			$this -> escalable = $escalable;
			
			$this -> wmin = $wmin;
			$this -> hmin = $hmin;
			$this -> wmax = $wmax;
			$this -> hmax = $hmax;
			
			$this -> construirJS();
		}
		
		function ordenable($ordenable){
			$this -> ordenable = $ordenable;
			
			$this -> construirJS();
		}
		
		function agregaSeccion($titulo, $contenido){
			$this -> secciones[$this -> ns++] = new Seccion($titulo,$contenido);
			
			$this -> construirJS();
			$this -> construirHTML();
		}
		function eliminaSeccion($index){
			$this -> secciones[$index] = null;
			
			$this -> construirJS();
			$this -> construirHTML();
		}
		
		function construirJS(){
			$this -> js = '<script>';
			
			$opciones = "";
			
			if($this -> iconos){
				$this -> js .= 'var icons = {header: "ui-icon-circle-arrow-e",headerSelected: "ui-icon-circle-arrow-s"};';
						
				$opciones .= "icons: icons,";
			}	

			if($this -> relleno){
				$opciones .= "fillSpace: true,";
			}
				
			if($this -> colapsable){
				$opciones .= "collapsible: true,";
			}
				
			if($this -> evento == "mouseover"){
				$opciones .= 'event: "mouseover",';
			}
			
			if($this -> ordenable){
				$opciones .= 'header: "> div > h3",';
			}
						
			if($opciones!=""){
				$tmp1 = "";$tmp2 = "";
				
				if($this -> ordenable){
					$tmp1 .= 'var stop = false;$( "#accordion'.$this -> referencia.' h3" ).click(function( event ) {if ( stop ) {event.stopImmediatePropagation();event.preventDefault();stop = false;}});';
					
					$tmp2 = '.sortable({axis: "y",handle: "h3",stop: function(){stop = true;}})';
				}
				
				$opciones = substr($opciones,0,strlen($opciones)-1);
				
				$this -> js .= '$(function() {'.$tmp1.'$( "#accordion'.$this -> referencia.'" ).accordion({'.$opciones.'})'.$tmp2.';});';	
					
			}
			else{
				$this -> js .= '$(function() { $( "#accordion'.$this -> referencia.'" ).accordion();});';
			}
			
			if($this -> escalable){
				$this -> js .= '$(function() {$( "#contenedor'.$this -> referencia.'" ).resizable({minHeight: '.$this -> hmin.',minWidth: '.$this -> wmin.',maxHeight:'.$this -> hmax.',maxWidth:'.$this -> wmax.',resize: function() {$( "#accordion'.$this -> referencia.'" ).accordion( "resize" );}});});';
			}
			
			$this -> js .= '</script>';
		}
		function construirHTML(){
			$this -> html = '<div id="contenedor'.$this -> referencia.'" style="width: '.$this -> ancho.'px; height: '.$this -> alto.'px; padding: 5px;" '.($this -> contenedor ? 'class="ui-widget-content"' : '').'>';
			$this -> html .= '<div id="accordion'.$this -> referencia.'">';
			
			foreach($this -> secciones as $seccion){
				if($seccion != null){
					if($this -> ordenable) $this -> html .= '<div>';
					$this -> html .= '<h3><a href="#">'.$seccion -> titulo.'</a></h3>';	
					$this -> html .= '<div>'.$seccion -> contenido.'</div>';
					if($this -> ordenable) $this -> html .= '</div>';	
				}	
			}					
								
			$this -> html .= '</div>';
			$this -> html .= '</div>';
		}
		
		function html(){
			$this -> construirJS();
			$this -> construirHTML();
			return $this -> js."\n".$this -> html;
		}
	}
	
	class Seccion{
		var $titulo;
		var $contenido;
		
		function Seccion($titulo, $contenido){
			$this -> titulo = $titulo;
			$this -> contenido = $contenido;
		}
	}
?>