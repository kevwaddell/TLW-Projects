(function($){

	if (Modernizr.touch){
	
	 event_type = 'touchstart';
	  
	} else {
	 
	 event_type = 'click';	
	 
	}
	
	if ( $('input.date-picker').length == 1) {
	    $('input.date-picker').datepicker({
        // Consistent format with the HTML5 picker
        format: 'DD d MM, yyyy',
        weekStart: 1
		});
    }
    
    $('body').on(event_type, '.filter-actions a.btn', function(){
    	
    	var params = $(this).attr("href");
    	var href = window.location.href;
    	var list_wrap = $(this).parents('.content-wrap').attr('id');
	    
	    $("#"+list_wrap).load(href+params+" #"+list_wrap+" .content-inner", function(data){
	    $(this).find('.content-inner');
	    });

	   return false; 
    });
    
     $('body').on(event_type, 'ul.pagination a', function(){
    	
    	var href = $(this).attr("href");
    	var list_wrap = $(this).parents('.panel-footer').parents('.content-wrap').attr('id');
	    
	    
	    $("#"+list_wrap).load(href+" #"+list_wrap+" .content-inner", function(data){
	    $(this).find('.content-inner');
	    });

	   return false; 
    });
    
     $('body').on(event_type, 'a.request-btn', function(){
     	
     	var params = $(this).attr("href");
     	var href = window.location.href;
     	$(this).parents('.btn-group').removeClass('open');
     	     	
     	$('.alerts').load(href+params+" .actions-wrap", function(data){
	     
	     $(this).find('.actions-wrap').hide().fadeIn('fast');
	     
	      if ( $(this).find('input.date-picker').length == 1) {
		    $('input.date-picker').datepicker({
	        // Consistent format with the HTML5 picker
	        format: 'DD d MM, yyyy',
	        weekStart: 1
			});
		 }
	     	
     	});   
     	
    	return false; 
    });
    
     $('body').on(event_type, 'a.cancel-btn', function(){
     	
     	$('.alerts').find('.actions-wrap').fadeOut('fast', function(){
	     	
	    	$('.alerts').empty();	
	     
     	})  
     	
    	return false; 
    });
    
     $('body').on(event_type, 'button.open-sidebar', function(){
     	
     	$('aside.help-sidebar').toggleClass('sidebar-closed sidebar-open');
     	$('.wrapper').toggleClass('sidebar-open');
     	
    	return false; 
    });
    
     $('body').on(event_type, 'button.close-sidebar', function(){
     	
     	$('aside.help-sidebar').toggleClass('sidebar-open sidebar-closed');
     	$('.wrapper').removeClass('sidebar-open');
     	
    	return false; 
    });


})(window.jQuery);