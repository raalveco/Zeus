	function formatNumber(num,prefix){
        prefix = prefix || '';
        num += '';
        
        num = num.replace(/([^0-9\.\-])/g,'');
        
        var splitStr = num.split('.');
        var splitLeft = splitStr[0].length==0 ? "0" : splitStr[0];
        var splitRight = splitStr.length > 1 ? '.' + splitStr[1] : '.00';
        
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
            splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');
        }
        
        return prefix + splitLeft + splitRight ;
    }
    
    function unformatNumber(num) {
        return num.replace(/([^0-9\.\-])/g,'')*1;
    }
    
    function numerico(campo){
    	campo.value = unformatNumber(campo.value);
        campo.value = campo.value.trim();
    }
    
    function dinerito(campo){
    	campo.value = formatNumber(campo.value,"$ ");
        campo.value = campo.value.trim();
    }
    
    function texto(campo){
    	campo.value = campo.value.trim();
    }
    
    function direccionar(url){
        window.location = url;
    }