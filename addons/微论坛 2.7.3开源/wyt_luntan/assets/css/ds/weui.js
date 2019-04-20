(function(window) {
    var weui = {};
    weui.dialog = {
        alert: function(content, title, callback) {
            var timestamp = Date.parse(new Date());
            var id = 'weui_dialog_alert' + timestamp;
            var tpl = '<div class="weui_dialog_alert" id="' + id + '" style="display: none;">' +
                    '<div class="weui_mask"></div>' +
                    '<div class="weui_dialog">' +
                    '<div class="weui_dialog_hd"><strong class="weui_dialog_title">{TITLE}</strong></div>' +
                    '<div class="weui_dialog_bd">{CONTENT}</div>' +
                    '<div class="weui_dialog_ft">' +
                    '<a href="javascript:;" class="weui_btn_dialog primary">确定</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            title = title || '';
            content = content || '';
            $("body").append(tpl.replace(/{TITLE}/, title).replace(/{CONTENT}/, content));
            $("#" + id).show();
            $("#" + id).find(".weui_btn_dialog").click(function() {
                if ($.isFunction(callback)) {
                    callback();
                }
                $("#" + id).remove();
            });
        },
        confirm: function(content, title, callback) {
            var timestamp = Date.parse(new Date());
            var id = 'weui_dialog_confirm' + timestamp;
            var tpl = '<div class="weui_dialog_confirm" id="' + id + '" style="display: none;">' +
                    '<div class="weui_mask"></div>' +
                    '<div class="weui_dialog">' +
                    '<div class="weui_dialog_hd"><strong class="weui_dialog_title">{TITLE}</strong></div>' +
                    '<div class="weui_dialog_bd">{CONTENT}</div>' +
                    '<div class="weui_dialog_ft">' +
                    '<a href="javascript:;" class="weui_btn_dialog default" data-res="0">取消</a>' +
                    '<a href="javascript:;" class="weui_btn_dialog primary" data-res="1">确定</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            title = title || '';
            content = content || '';
            $("body").append(tpl.replace(/{TITLE}/, title).replace(/{CONTENT}/, content));
            $("#" + id).show();
            $("#" + id).find(".weui_btn_dialog").click(function() {
                if ($.isFunction(callback)) {
                    callback($(this).data('res'))
                }
                $("#" + id).remove();
            });
        },
        toast: function(type, msg, autoCloseTime) {
            var calss = '';
            type = type || 'loading';
            if (type == 'loading') {
                var content = '<div class="weui_loading">';
                for(var i=0; i <= 11; i++) {
                    content += '<div class="weui_loading_leaf weui_loading_leaf_' + i + '"></div>';
                }
                content += '</div>';
                calss = ' class="weui_loading_toast"';
                msg = msg || '数据加载中';
            }else{
                var content = '<i class="weui_icon_toast"></i>';
                msg = msg || '已完成';
            }
            var timestamp = Date.parse(new Date());
            var id = 'weui_loading_toast' + timestamp;
            var tpl = '<div id="' + id + '" ' + calss + ' style="display:none;">' + 
                        '<div class="weui_mask_transparent"></div>' + 
                        '<div class="weui_toast">' + 
                            content +
                            '<p class="weui_toast_content">{MSG}</p>' + 
                        '</div>' + 
                    '</div>';
                autoCloseTime = autoCloseTime || false;
                $("body").append(tpl.replace(/{MSG}/, msg));
            var $loadingToast = $("#" + id);

                $loadingToast.show();
            if (autoCloseTime) {
                setTimeout(function () {
                    $loadingToast.hide();
                }, autoCloseTime);
            }
            return $loadingToast;
        },
        loading: function(msg, autoCloseTime) {
            return this.toast('loading', msg, autoCloseTime);
        }
    };
    window.weui = weui;
    window.dialog = window.weui.dialog;
})(window);