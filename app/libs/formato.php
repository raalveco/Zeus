<?php
	class Formato{
	    public static function utf8($texto){
	        return utf8_encode($texto);    
	    }
		
		public static function iso88591($texto){
	        return utf8_decode($texto);    
	    }
		
		public static function numero($numero, $decimales = 2, $decimal = ".", $miles = ","){
			return number_format($numero,$decimales,$decimal,$miles);
		}
		
		public static function dinero($numero, $decimal = true){
			if($decimal){
				return "$ ".number_format($numero,2);
			}
			
			return "$ ".number_format($numero,0);
		}
	    
		public static function ceros($numero,$digitos = 4){
			$n = $digitos - strlen($numero);
	
			for($i=0;$i<$n;$i++){
				$numero = "0".$numero;
			}
	
			return $numero;
		}
		
		public static function numeroLetra($n){
            $unidades = $n % 1000;
            $millares = intval($n / 1000) % 1000;
            $millones = intval(intval($n / 1000)/1000);
            
            if($n<0) return "";
            
            if($n==0) return "CERO";
            
            if($n<1000) return Formato::convertir($unidades);
            
            if($n<1000000){
                if($millares == 1) return "MIL ".Formato::convertir($unidades);
            
                return Formato::convertir($millares)." MIL ".Formato::convertir($unidades);    
            }
            
            if($millones == 1){
                if($millares==0 && $unidades==0) return "UN MILLON DE";
                if($millares==0) return "UN MILLON ".Formato::convertir($unidades);
                if($millares==1) return "UN MILLON MIL ".Formato::convertir($unidades);
                return "UN MILLON ".Formato::convertir($millares)." MIL ".Formato::convertir($unidades);    
            }
            
            if($millares==0 && $unidades==0){
                return Formato::convertir($millones)." MILLONES DE";    
            }
            
            return Formato::convertir($millones)." MILLONES ".Formato::convertir($millares)." MIL ".Formato::convertir($unidades);
        }
		
		public static function mayusculas($texto){
			return strtoupper($texto);
		}
		
		public static function minusculas($texto){
			return strtolower($texto);
		}
		
		public static function capital($texto){
			$partes = explode(" ", $texto);
			
			$capital = "";
			
			if($partes){
				foreach($partes as $parte){
					$parte = strtolower($parte);
					$parte = strtoupper(substr($parte,0,1)).substr($parte,1);
					$capital .= $parte." ";
				}
			}
			
			$capital = trim($capital);
		
			return $capital;
		}
		
		public static function texto($texto){
			$partes = explode("_", $texto);
			
			$camello = "";
			
			if($partes){
				$n=0;
				foreach($partes as $parte){
					$parte = strtolower($parte);
					$parte = strtoupper(substr($parte,0,1)).substr($parte,1);
					$camello .= $parte." ";
					$n++;
				}
			}
			
			$camello = trim($camello);
		
			return $camello;
		}
		
		public static function camello($texto){
			$partes = explode("_", $texto);
			
			$camello = "";
			
			if($partes){
				$n=0;
				foreach($partes as $parte){
					$parte = strtolower($parte);
					if($n>0){
						$parte = strtoupper(substr($parte,0,1)).substr($parte,1);
					}
					$camello .= $parte;
					$n++;
				}
			}
		
			return $camello;
		}
		
		public static function inversaCamello($camello){
			$texto = "";
			for($i=0;$i<strlen($camello);$i++){
				if(ctype_upper($camello[$i])){
					$texto .= "_";
				}
				$texto .= strtolower($camello[$i]);
			}
			
			return $texto;
		}
		
		public static function fecha($fecha){
	        if(!$fecha) return "00/00/0000";
	        
	        if(strpos($fecha,"-")>0){
	            return substr($fecha,8,2)."/".substr($fecha,5,2)."/".substr($fecha,0,4);
	        }
	        return $fecha;
	    }
		
		public static function FechaDB($fecha){
	        if(!$fecha) return "0000-00-00";
	        
	        if(strpos($fecha,"/")>0){
	            return substr($fecha,6,4)."-".substr($fecha,3,2)."-".substr($fecha,0,2);
	        }
	        return $fecha;
	    }
	    
	    public static function hora($mins){
	        $m = floor($mins % 60);
	        $h = floor($mins / 60);
	        
	        return Formato::ceros($h,2).":".Formato::ceros($m,2);
	    }
	    
	    public static function mes($m){
			switch($m){
				case 1: return "Enero";
			    case 2: return "Febrero";
			    case 3: return "Marzo";
			    case 4: return "Abril";
			    case 5: return "Mayo";
			    case 6: return "Junio";
			    case 7: return "Julio";
			    case 8: return "Agosto";
			    case 9: return "Septiembre";
			    case 10: return "Octubre";
			    case 11: return "Noviembre";
			    case 12: return "Diciembre";
			}
		}
		
		public static function fechaExtendida($fecha){
		 	$tmp = mktime(0,0,0,substr($fecha,5,2),substr($fecha,8,2),substr($fecha,0,4));
	
			$n = date("N",$tmp);
	
			switch($n){
				case 1: $fecha = "Lunes, "; break;
				case 2: $fecha = "Martes, "; break;
				case 3: $fecha = "Miercoles, "; break;
				case 4: $fecha = "Jueves, "; break;
				case 5: $fecha = "Viernes, "; break;
				case 6: $fecha = "Sabado, "; break;
				case 7: $fecha = "Domingo, "; break;
			}
	
			$d = date("d",$tmp);
			$fecha .= $d." de ";
	
			$m = date("m",$tmp);
	
			switch($m){
				case 1: $fecha .= "Enero"; break;
			    case 2: $fecha .= "Febrero"; break;
			    case 3: $fecha .= "Marzo"; break;
			    case 4: $fecha .= "Abril"; break;
			    case 5: $fecha .= "Mayo"; break;
			    case 6: $fecha .= "Junio"; break;
			    case 7: $fecha .= "Julio"; break;
			    case 8: $fecha .= "Agosto"; break;
			    case 9: $fecha .= "Septiembre"; break;
			    case 10: $fecha .= "Octubre"; break;
			    case 11: $fecha .= "Noviembre"; break;
			    case 12: $fecha .= "Diciembre"; break;
			}
	
			$y = date("Y",$tmp);
	
		    $fecha .= " de ".$y;
	
	
		 	return $fecha;
		 }
	     
	    public static function fechaAbreviada($fecha){
		 	$tmp = mktime(0,0,0,substr($fecha,5,2),substr($fecha,8,2),substr($fecha,0,4));
	
			$d = date("d",$tmp);
			$fecha = $d." ";
	
			$m = date("m",$tmp);
	
			switch($m){
				case 1: $fecha .= "ENE"; break;
			    case 2: $fecha .= "FEB"; break;
			    case 3: $fecha .= "MAR"; break;
			    case 4: $fecha .= "ABR"; break;
			    case 5: $fecha .= "MAY"; break;
			    case 6: $fecha .= "JUN"; break;
			    case 7: $fecha .= "JUL"; break;
			    case 8: $fecha .= "AGO"; break;
			    case 9: $fecha .= "SEP"; break;
			    case 10: $fecha .= "OCT"; break;
			    case 11: $fecha .= "NOV"; break;
			    case 12: $fecha .= "DIC"; break;
			}
	
			$y = date("Y",$tmp);
	
		    $fecha .= " ".$y;
	
	
		 	return $fecha;
		 }
	
	    public static function fechaLetra($fecha){
		 	$tmp = mktime(0,0,0,substr($fecha,5,2),substr($fecha,8,2),substr($fecha,0,4));
	
			$d = date("d",$tmp);
			$fecha = $d." de ";
	
			$m = date("m",$tmp);
	
			switch($m){
				case 1: $fecha .= "Enero"; break;
			    case 2: $fecha .= "Febrero"; break;
			    case 3: $fecha .= "Marzo"; break;
			    case 4: $fecha .= "Abril"; break;
			    case 5: $fecha .= "Mayo"; break;
			    case 6: $fecha .= "Junio"; break;
			    case 7: $fecha .= "Julio"; break;
			    case 8: $fecha .= "Agosto"; break;
			    case 9: $fecha .= "Septiembre"; break;
			    case 10: $fecha .= "Octubre"; break;
			    case 11: $fecha .= "Noviembre"; break;
			    case 12: $fecha .= "Diciembre"; break;
			}
	
			$y = date("Y",$tmp);
	
		    $fecha .= " de ".$y;
	
	
		 	return $fecha;
		 }
	
		public static function convertir($n){
            $u = $n % 10;
            $d = intval($n / 10) % 10;
            $c = intval(intval($n / 10) / 10);
            
            if($n<=20){
                switch($n){
                    case 0: return "";
                    case 1: return "UN";
                    case 2: return "DOS";
                    case 3: return "TRES";
                    case 4: return "CUATRO";
                    case 5: return "CINCO";
                    case 6: return "SEIS";
                    case 7: return "SIETE";
                    case 8: return "OCHO";
                    case 9: return "NUEVE";
                    case 10: return "DIEZ";
                    case 11: return "ONCE";
                    case 12: return "DOCE";
                    case 13: return "TRECE";
                    case 14: return "CATORCE";
                    case 15: return "QUINCE";
                    case 16: return "DIECISEIS";
                    case 17: return "DIECISIETE";
                    case 18: return "DIECIOCHO";
                    case 19: return "DIECINUEVE";
                    case 20: return "VEINTE";
                }
            }
            
            if($n<100){
                switch($d){
                    case 2: return "VEINTI".Formato::convertir($u);
                    case 3: return $u==0 ? "TREINTA" : "TREINTA Y ".Formato::convertir($u);
                    case 4: return $u==0 ? "CUARENTA" : "CUARENTA Y ".Formato::convertir($u);
                    case 5: return $u==0 ? "CINCUENTA" : "CINCUENTA Y ".Formato::convertir($u);
                    case 6: return $u==0 ? "SESENTA" : "SESENTA Y ".Formato::convertir($u);
                    case 7: return $u==0 ? "SETENTA" : "SETENTA Y ".Formato::convertir($u);
                    case 8: return $u==0 ? "OCHENTA" : "OCHENTA Y ".Formato::convertir($u);
                    case 9: return $u==0 ? "NOVENTA" : "NOVENTA Y ".Formato::convertir($u);
                }
            }
                
            if($n==100) return "CIEN";
               
            
            if($n<1000){
                switch($c){
                    case 1: return "CIENTO ".Formato::convertir($d.$u);
                    case 2: return "DOSCIENTOS ".Formato::convertir($d.$u);
                    case 3: return "TRESCIENTOS ".Formato::convertir($d.$u);
                    case 4: return "CUATROCIENTOS ".Formato::convertir($d.$u);
                    case 5: return "QUINIENTOS ".Formato::convertir($d.$u);
                    case 6: return "SEISCIENTOS ".Formato::convertir($d.$u);
                    case 7: return "SETECIENTOS ".Formato::convertir($d.$u);
                    case 8: return "OCHOCIENTOS ".Formato::convertir($d.$u);
                    case 9: return "NOVECIENTOS ".Formato::convertir($d.$u);
                }
            }
            
            if($n==1000) return "MIL";
        }
    }
    ?>