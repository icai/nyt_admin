(function () {  
    $.MsgBox = {  
        Alert: function (title, msg,callback) {  
            GenerateHtml("alert", title, msg);  
            btnOk(callback);  //alert只是弹出消息，因此没必要用到回调函数callback  
            btnNo();  
        },  
        Confirm: function (title, msg, callback) {  
            GenerateHtml("confirm", title, msg);  
            btnOk(callback);  
            btnNo();  
        }  
    }  
    //生成Html  
    var GenerateHtml = function (type, title, msg) {  
        var _html = "";  
        _html += '<div id="mb_box"></div><div id="mb_con"><span id="mb_tit">' + title + '</span>';  
        _html += '<div id="mb_msg">' + msg + '</div><div id="mb_btnbox">';  
        if (type == "alert") {  
            _html += '<span id="mb_btn_ok">'+Config.MsgBox_ok+'</span>';  
        }  
        if (type == "confirm") {  
            _html += '<span id="mb_btn_ok">'+Config.MsgBox_ok+'</span>';  
            _html += '<span id="mb_btn_no">'+Config.MsgBox_no+'</span>';  
        }  
        _html += '</div></div>';  
        //必须先将_html添加到body，再设置Css样式  
        $("body").append(_html);   
        //生成Css  
         GenerateCss();  
    }  
    //生成Css  
    var GenerateCss = function () {  
        var _widht = document.documentElement.clientWidth;  //屏幕宽  
        var _height = document.documentElement.clientHeight; //屏幕高  
        var boxWidth = $("#mb_con").width(); 
        var boxHeight = $("#mb_con").height();  
        //让提示框居中  
        //$("#mb_con").css({ top: (_height - boxHeight) / 2 - 40 + "px", left: (_widht - boxWidth) / 2 + "px" });  
    }  
    //确定按钮事件  
    var btnOk = function (callback) {
		$(document).on('click','#mb_btn_ok',function(){
            $("#mb_box,#mb_con").remove();  
            if (typeof (callback) == 'function') {  
                callback();  
            }  
        });  
    }  
    //取消按钮事件  
    var btnNo = function () {  
		$(document).on('click','#mb_btn_no,#mb_ico',function(){
            $("#mb_box,#mb_con").remove();  
        });  
    }  
})();