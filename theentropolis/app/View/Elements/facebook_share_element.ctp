<a class="share_icns FB-icon " href="javascript:void(0)"><img src="https://www.facebook.com/images/fb_icon_325x325.png" style="width:32px;height:32px;"></a>

<a class="share_icns TW-icon"  href="javascript:void(0);" data-related="twitterdev"data-size="large"data-count="none">
 <!-- <img src="https://www.sumobaby.net/news/wp-content/uploads/2011/05/twitter_newbird_boxed_whiteonblue.png" style="width:32px;height:32px;">  -->

<?php echo $this->Html->image('twitter-share.png'); ?>
</a> 


<a class="share_icns LIK-icon"  href="javascript:void(0);" ><?php echo $this->Html->image('linkedin.png');?></a> 

<script>
    window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
	
	$(document).ready(function() {
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1505520973010997',
      xfbml      : true,
      version    : 'v2.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

        });
		
        function share(desitionid,desitiontype,object_type) {
		
		var twitterdescription ;
		 var twedescription ;
		
	   jQuery.ajax({
                type:'post',
                url:"<?php echo Router::url(array('controller'=>'pages', 'action'=>'getDesitionBank'))?>",
                data: {desitionid:desitionid,desitiontype:desitiontype,object_type:object_type},
				dataType: "json",
                success:function(msg)
                {
						//console.log(msg);
						//console.log(msg.title);
						//console.log(msg.objtype);
						//alert(msg.objtype);
						var tempVar = msg.objtype;
						var context_role_user_id = msg.context_role_user_id;
						var object_id = msg.object_id;
						var hreff = document.location.host;


					if(tempVar=='Advice')
                	{
                		
                	var fb_link = hreff+'/pages/sageProfile/'+context_role_user_id+'/'+object_id;
                		//var fb_link ='';
                		//alert();
                	}
                	else if(tempVar=='Hindsight')
                	{
                			var fb_link = hreff+'/pages/seekerProfile/'+context_role_user_id+'/'+object_id;
                		
                	}
					else{
					
					var fb_link = hreff;
					}
					

						//alert(tempVar)

				if(object_type=='facebook')
				{
				


				//	alert(typeof tempVar);
					

				   FB.ui({
										method: 'feed',
										name: msg.title,
										link: fb_link,
										picture: hreff+"/img/link-new-img.png",
										//caption: "Awdhesh Box Facebook",
										description: msg.description
					}); 
				}
				else if(object_type=='twitter')
				{
				
				
//$('.share-button-image').find(".TW-icon").attr('href',"https://twitter.com/intent/tweet?url=https://dev.entropolis1.prospus.com/&amp;text="+msg.description+"");

window.open('https://twitter.com/intent/tweet?url='+hreff+'/&amp;text='+msg.title+ '&', 'twitterwindow', 'height=450, width=550, top='+($(window).height()/2 - 225) +', left='+$(window).width()/2 +', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');

				}
				else {
					
					
					
     var articleUrl = encodeURIComponent('https://dev.entropolis1.prospus.com');
     var articleTitle = encodeURIComponent(msg.title);
     var articleSummary = encodeURIComponent(msg.description);
     var articleSource = encodeURIComponent('https://dev.entropolis1.prospus.com');
     var goto = 'https://www.linkedin.com/shareArticle?mini=true'+
         '&url='+articleUrl+
         '&title='+articleTitle+
         '&summary='+articleSummary+
         '&source='+articleSource;
     window.open(goto, "LinkedIn", "width=660,height=400,scrollbars=no;resizable=no");        
return false;

					}
                }

            })
	   
    }
	
	</script>
				 