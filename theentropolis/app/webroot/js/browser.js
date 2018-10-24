/*------------------- 
File Name : "browser.js"
Description : This js file detects the client browser and gives css classes to the body for browser compatible theming
Author : Prospus Consulting Pvt. Ltd. 
Website : http://prospus.com
Date Created : 27th August 2012
Time : 11:09:50
Developer : Ankit Bhatia
--------------------*/

$(document).ready(function(){
	checkBrowser();
});

function checkBrowser(){
	var val = navigator.userAgent.toLowerCase();
		if(val.indexOf("firefox") > -1){
			$('body').addClass('firefox');
		}
		else if(val.indexOf("opera") > -1){
			$('body').addClass('opera');
		}
		else if(val.indexOf("msie") > -1){
			$('body').addClass('ie');		
			// get ie version
			version = parseFloat(navigator.appVersion.split("MSIE")[1]);
			$('body').addClass('ie'+version);
		}	
		else if(val.match('chrome') != null){
			$('body').addClass('chrome');
		}
		else if(val.indexOf("safari") > -1){
			$('body').addClass('safari');
		}	
}
