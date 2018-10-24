(function() {  
    tinymce.create('tinymce.plugins.creator', {  

	init : function(ed, url) {  
	    ed.addCommand('zc_embed_window',function(){
		ed.windowManager.open({
			file : url+'/zc_loading.php',
			title : 'Zoho Creator',
			width : 200, 
			height : 80,
			inline :1
		},{plugin_url : url});
		});
		  
            ed.addButton('creator', {  
                title : 'ZohoCreator',
				cmd : 'zc_embed_window',  
                image : url+'/favicon.png' 				
            });
			return false;
        }
	
    
  	  
         
    });  
    tinymce.PluginManager.add('creator', tinymce.plugins.creator);  
	
    
})();  

