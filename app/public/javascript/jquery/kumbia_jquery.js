jQuery(function($) {
	$("a.jsShow").live('click' , function(event) {
		event.preventDefault();
		$(this.rel).show();
	});
	
	$("a.jsHide").live('click', function(event) {
		event.preventDefault();
		$(this.rel).hide();
	});
	
	$("a.jsToggle").live('click', function(event) {
		event.preventDefault();
		$(this.rel).toggle();
	});
	
	$("a.jsRemote").live('click', function(event) {
		event.preventDefault();
		$(this.rel).load(this.href)
	});
	
	$("a.jsRemoteEliminar").live('click', function(event) {
		event.preventDefault();
		
		if(confirm('Estas seguro que deseas eliminar el registro')){
			$(this.rel).load(this.href);
		}
		else{
			return false;
		}
	});
});