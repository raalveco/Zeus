	jQuery(function($){
 		$('#jcrop').Jcrop({
	        onChange: updatePreview,
	        onSelect: updatePreview,
	        aspectRatio: 1
	      },function(){
	        // Use the API to get the real image size
	        var bounds = this.getBounds();
	        boundx = bounds[0];
	        boundy = bounds[1];
	        // Store the API in the jcrop_api variable
	        jcrop_api = this;
	    });
	});
 
 
 	function showCoords(c)
    {
      $('#x1').val(c.x);
      $('#y1').val(c.y);
      $('#x2').val(c.x2);
      $('#y2').val(c.y2);
      $('#w').val(c.w);
      $('#h').val(c.h);
    };
 
    function clearCoords()
    {
		$('#coords input').val('');
		$('#h').css({color:'red'});
		window.setTimeout(function(){
			$('#h').css({color:'inherit'});
		},500);
    };
    
    function updatePreview(c)
    {
		$('#x1').val(c.x);
	    $('#y1').val(c.y);
	    $('#x2').val(c.x2);
	  	$('#y2').val(c.y2);
		$('#w').val(c.w);
	    $('#h').val(c.h);
      	
        if (parseInt(c.w) > 0)
        {
          var rx = 100 / c.w;
          var ry = 100 / c.h;
 
          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
    };