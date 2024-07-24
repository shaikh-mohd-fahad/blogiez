click="yes";
$("#opensidebar").click(function(){
	//alert(click);
	if(click=="yes"){
		$("#leftside").css({"display":"block","width":"80%","z-index":"100","transition":"transform 1000ms ease-in-out"});
		click="no";
	}else{
		$("#leftside").css("display","none");
		click="yes";
	}
});
//count download App
$(".download_app").click(function(){
	$.ajax({
		url:"server.php",
		type:"post",
		data:"download=download_app",
		success:function(){}
	});
});