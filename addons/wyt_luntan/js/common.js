$(function() {  
	FastClick.attach(document.body);  
});
window.addEventListener("DOMContentLoaded", function() {
	var AdSwiper = new Swiper('.Ad .swiper-container',{
		autoplay:7000,
		calculateHeight:true,
		pagination : '.pagination'
    });
});