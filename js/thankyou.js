if (typeof(kd_total) == 'undefined'){
	kd_total = 1;
}
if (typeof(kd_client) == 'undefined'){
	kd_client = 0;
}
function kd_cookie(k){return(document.cookie.match('(^|; )'+k+'=([^;]*)')||0)[2]}
var kiddo_cookie = kd_cookie('kiddo');
var scr = document.createElement('script');
var prev = document.getElementsByTagName('script')[0];
scr.async = 1;
scr.src = 'https://kiddosity.com/tracking/'+btoa(kd_client+'&'+kiddo_cookie+'&'+kd_total);
prev.parentNode.insertBefore(scr, prev);
