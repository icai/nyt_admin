function dragEvent(obj) {
	var posterIndex = obj.attr('index');
	var posterrs = new Resize(obj, {
		Max : true,
		mxContainer : "#tiger_poster"
	});
	posterrs.Set($(".dRightDown", obj), "right-down");
	posterrs.Set($(".dLeftDown", obj), "left-down");
	posterrs.Set($(".dRightUp", obj), "right-up");
	posterrs.Set($(".dLeftUp", obj), "left-up");
	posterrs.Set($(".dRight", obj), "right");
	posterrs.Set($(".dLeft", obj), "left");
	posterrs.Set($(".rUp", obj), "up");
	posterrs.Set($(".rDown", obj), "down");
	posterrs.Scale = true;
	var type = obj.attr('type');
	if (type == 'name' || type == 'img' || type == 'code') {
		posterrs.Scale = false;
	}
	new Drag(obj, {
		Limit : true,
		mxContainer : "#tiger_poster"
	});
	
	$('.drag .remove').unbind('click').click(function() {
		$(this).parent().remove();
	});
	
	obj.unbind('click').click(function() {
		tiger_bind($(this));
	});
}


function tiger_bind(obj){
	var imgsset = $('#imgsset');
	var namesset = $("#namesset");
	imgsset.hide();
	namesset.hide();
	var type = obj.attr('type');
	
	if(type=='name'){
		namesset.show();
		var size = obj.attr('size') || "16";
		var picker = namesset.find('.sp-preview-inner');
		var input = namesset.find('input:first');
		var namesize = namesset.find('#namesize');
		var color = obj.attr('color') || "#000";
		input.val(color); namesize.val(size.replace("px",""));  
		picker.css( {'background-color':color,'font-size':size});
		ncounter = setInterval(function(){
			obj.attr('color',input.val()).find('.text').css('color',input.val());
			obj.attr('size',namesize.val() +"px").find('.text').css('font-size',namesize.val() +"px");
		},100);
	}
}

function delete_drag(obj){
	obj.remove();
}

$('.btn-poster').click(function(){
	var imgsset = $('#imgsset');	
	var namesset = $("#namesset");

	imgsset.hide();
	namesset.hide();

	var type = $(this).data('type');
	var img = "";
	var modulename = $('#modulename').val();
	if(type=='img' || type=='thumb'){
	   img = '<img src="../addons/'+modulename+'/images/default.jpg" />';
	}else if(type=='name'){
	   img = '<div class=text>昵称</div>';
	}else if(type=='qr'){
	   img = '<img src="../addons/'+modulename+'/images/qr.png" />';
	}
	
	var index = $('#tiger_poster .drag').length+1;
	var obj = $('<div class="drag" onclick="tiger_bind($(this));" ondblclick="delete_drag(this);"  type="' + type +'" index="' + index +'" style="z-index:' + index+'">' + img+'<div class="dRightDown"> </div><div class="dLeftDown"> </div><div class="dRightUp"> </div><div class="dLeftUp"> </div><div class="dRight"> </div><div class="dLeft"> </div><div class="rUp"> </div><div class="rDown"></div></div>');
	
	$('#tiger_poster').append(obj);
	dragEvent(obj);
});

 $('.drag').each(function(){
	 dragEvent($(this));
 });


$('form').submit(function(){
	var poster = [];
	$('.drag').each(function(){
		var obj = $(this);
		var type = obj.attr('type');
		var left = obj.css('left');
		var top = obj.css('top');
		var d= {left:left,top:top,type:obj.attr('type'),width:obj.css('width'),height:obj.css('height')};
		if(type=='name'){
			d.size = obj.attr('size');
			d.color = obj.attr('color');
		}
		poster.push(d);
	});
	$('input[name="data"]').val(JSON.stringify(poster));
	return true;
});
	


function deleteTimers() {
	clearInterval(imgcounter);
	clearInterval(ncounter);
	clearInterval(bscounter);
}

function getUrl(val) {
	if (val.indexOf('http://') == -1) {
		val = attachurl + val;
	}
	return val;
}



function PreviewImg(imgFile){
    var image = new Image();
	image.src = imgFile;
	return image;
}



$('#posterbg').find('button:first').click(function(){

    var oldbg = $(':input[name=bg]').val();

    bscounter = setInterval(function(){

         var bg = $(':input[name=bg]').val();

         if(oldbg!=bg){

        	 var img = PreviewImg(attachurl+bg);

        	 $('#bgtd').css('width',img.width/2+'px').css('height',img.height/2+'px');

        	 $('#tiger_poster').css('width',img.width/2+'px').css('height',img.height/2+'px');

        	 

               if(bg.indexOf('http://')==-1){

                    bg = attachurl + bg;

               }

              $('#tiger_poster .bg').remove();

              var bgh = $("<img src='" + bg + "' class='bg' style='width:"+img.width/2+"px;height:"+img.height/2+"px'/>");

               var first = $('#tiger_poster .drag:first');

                if(first.length>0){

                   bgh.insertBefore(first);  

                } else{

                   $('#tiger_poster').append(bgh);      

                }

               

              oldbg = bg;

         }

    },10);

})