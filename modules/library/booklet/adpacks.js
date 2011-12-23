jQuery(function($){
	
	var adpacksstyles = {
		lightHorizontal	: '\
		#codrops-ad-wrapper{right:8px;top:32px;background:transparent url(http://tympanus.net/codrops/adpacks/bg_ad_light.png) repeat top left;}\
		#codrops-ad-wrapper .one .bsa_it_ad a{color:#000;}\
		#adpack-remove{background:url(http://tympanus.net/codrops/adpacks/adclose_black.png) no-repeat center center;}\
	    ',
		lightHorizontalBottom	: '\
		#codrops-ad-wrapper{color:#000;right:8px;bottom:32px;background:transparent url(http://tympanus.net/codrops/adpacks/bg_ad_light.png) repeat top left;}\
		#codrops-ad-wrapper .one .bsa_it_ad a{color:#000;}\
		#adpack-remove{background:url(http://tympanus.net/codrops/adpacks/adclose_black.png) no-repeat center center;}\
	    ',
		lightVertical	: '\
		#codrops-ad-wrapper{color:#000;right:8px;top:32px;background:transparent url(http://tympanus.net/codrops/adpacks/bg_ad_light.png) repeat top left;}\
		#codrops-ad-wrapper .one .bsa_it_ad a{color:#000;}\
		#adpack-remove{background:url(http://tympanus.net/codrops/adpacks/adclose_black.png) no-repeat center center;}\
	    ',
		lightVerticalBottom	: '\
		#codrops-ad-wrapper{color:#000;right:8px;bottom:32px;background:transparent url(http://tympanus.net/codrops/adpacks/bg_ad_light.png) repeat top left;}\
		#codrops-ad-wrapper .one .bsa_it_ad a{color:#000;}\
		#adpack-remove{background:url(http://tympanus.net/codrops/adpacks/adclose_black.png) no-repeat center center;}\
	    ',
		darkHorizontal	: '\
		#codrops-ad-wrapper{right:8px;top:32px;}\
	    ',
		darkHorizontalRightSpace	: '\
		#codrops-ad-wrapper{right:110px;top:32px;}\
	    ',
		darkHorizontalBottom	: '\
		#codrops-ad-wrapper{right:8px;bottom:32px;}\
	    ',
		darkHorizontalLeft	: '\
		#codrops-ad-wrapper{left:8px;top:32px;}\
	    ',
		darkHorizontalBottomLeft	: '\
		#codrops-ad-wrapper{left:8px;bottom:32px;}\
	    ',
		darkVertical	: '\
		#codrops-ad-wrapper{right:8px;top:32px;}\
	    ',
		darkVerticalBottom	: '\
		#codrops-ad-wrapper{right:8px;bottom:32px;}\
	    ',
		darkVerticalBottomLeft	: '\
		#codrops-ad-wrapper{left:8px;bottom:32px;}\
	    ',
		darkVerticalLeft	: '\
		#codrops-ad-wrapper{left:10px;top:10px;}\
	    ',
		commonStyle	: '\
		#codrops-ad-wrapper{width:180px;color:#fff;text-shadow:none;text-transform:none;opacity:0.8;position:fixed;z-index:1000000;background:transparent url(http://tympanus.net/codrops/adpacks/bg_ad_dark.png) repeat top left;}\
		#codrops-ad-wrapper:hover{opacity:1.0;}\
		#codrops-ad-wrapper a.ad1{display:block;margin: 10px auto 30px auto;width: 130px;height:100px;}\
		#codrops-ad-wrapper .one .bsa_it_ad a{color:#fff;}\
		#codrops-ad-wrapper .one .bsa_it_ad{background:none;padding:10px 10px 20px 10px;border:none;}\
		#codrops-ad-wrapper .one .bsa_it_ad .bsa_it_d{}\
		#codrops-ad-wrapper .one .bsa_it_ad a{text-align:left;text-decoration:none;font-family:Arial,serif;font-style:italic; font-size:12px;}\
		#codrops-ad-wrapper .one .bsa_it_ad a:hover img{opacity:1.0;};\
		#codrops-ad-wrapper .one .bsa_it_ad img{float:left; opacity:0.8;}\
		#codrops-ad-wrapper .one .bsa_it_ad .bsa_it_i{padding:0;float:left;margin:0 12px 0px 0;}\
		#codrops-ad-wrapper .one .bsa_it_ad .bsa_it_i img{padding:0;border:none;}\
		#codrops-ad-wrapper .one .bsa_it_ad .bsa_it_t{padding:6px 0 5px 0;display:block;font-size:12px; font-weight:bold;}\
		#codrops-ad-wrapper .one .bsa_it_p{display:none;}\
		#bsap_aplink,#bsap_aplink:hover{text-decoration:none;position:absolute; bottom:4px; right:4px;font-size:10px;text-align:right;font-family:Georgia,serif;font-style:italic;color:#d24e42;}\
		#adpack-remove{opacity:0.4;width:10px;height:10px;position:absolute;top:5px;right:5px;background:url(http://tympanus.net/codrops/adpacks/adclose_white.png) no-repeat center center;}\
		#adpack-remove:hover{opacity:1.0;}\
		#codrops-ad-wrapper .adhere {width: 130px;height: 100px;display: block;background: rgba(255, 255, 255, 0.5);margin: 15px 0px 24px 26px;box-shadow: 1px 1px 2px rgba(0,0,0,0.3);line-height: 100px;text-align: center;font-size: 11px;font-family: Arial;font-style: italic;color: #333;text-shadow: 1px 1px 1px white;}\
		#codrops-ad-wrapper .bsap_adhere a{position: absolute;bottom: 4px;left: 8px;font-size: 9px;font-family: arial;text-transform: uppercase;text-decoration: none;color: #333;}\
		#codrops-ad-wrapper .bsap_adhere a:hover{color:#296a8b;}\
		#codrops-ad-wrapper .bsap_backfillframe{margin:10px 0px 20px 32px; height:125px;}\
	    '
	};
	prependStyle(adpacksstyles["commonStyle"]);
	prependStyle(adpacksstyles[ADPACKSSTYLE]);

	$('body').prepend('<div id="codrops-ad-wrapper">\
    	<div id="bsap_1269685" class="bsarocks bsap_af25dfd2f1908889af7a1aa5f4dcbd9e"></div>\
	    <a href="http://buysellads.com/buy/detail/17086" target="_blank" id="bsap_aplink">via BuySellAds</a>\
	</div>');
	
	$('<a>').attr('href','').attr('id','adpack-remove').bind('click',function(){
		$(this).parent().remove();
		return false;
	}).appendTo('#codrops-ad-wrapper');
	
	(function(){
	  var bsa = document.createElement('script');
		 bsa.type = 'text/javascript';
		 bsa.async = true;
		 bsa.src = '//s3.buysellads.com/ac/bsa.js';
	  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
	})();
		
	function prependStyle(str){
		var style = document.createElement('style');
		style.setAttribute("type", "text/css");
		if (style.styleSheet) { 
			style.styleSheet.cssText = str;
		} else {                
			style.appendChild(document.createTextNode(str));
		}
		jQuery('head').append(style);
	}
});