$(function () {

    var $fullText = $('.admin-fullText');
    $('#admin-fullscreen').on('click', function () {
        $.AMUI.fullscreen.toggle();
    });

    var dataType = $('body').attr('data-type');
    for (key in pageData) {
        if (key == dataType) {
            pageData[key]();
        }
    }

    $('.tpl-switch').find('.tpl-switch-btn-view').on('click', function () {
        $(this).prev('.tpl-switch-btn').prop("checked", function () {
            if ($(this).is(':checked')) {
                return false
            } else {
                return true
            }
        })

    })
})

// 页面数据
var pageData = {
    'index': function indexData() {
        var sinvite_url = location.href.split('/web/index.php');
        sinvite_url = sinvite_url[0] + '/web/index.php?s=/urge/index/userCount';
        var curDate = new Date();
        var curMonth = curDate.getMonth();
        curDate.setMonth(curMonth + 1);
        curDate.setDate(0);
        var echartsA = echarts.init(document.getElementById('tpl-echarts-A'));
        var echartData = new Array();
        if (curDate.getDate() > 30) {
            for (var i = 0; i < 31; i++) {
                echartData.push(i + 1 + '日');
            }
        } else {
            for (var i = 0; i < 30; i++) {
                echartData.push(i + 1 + '日');
            }
        }
        var sanimate = new Array();
        $.ajax({
            url: sinvite_url,
            async: false,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                echartsA.setOption({
                    title: {
                        text: '本月新增用户'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    xAxis: {
                        data: echartData
                    },
                    yAxis: {
                        splitLine: {
                            show: false
                        }
                    },
                    toolbox: {
                        left: 'center',
                        feature: {
                            dataZoom: {
                                yAxisIndex: 'none'
                            },
                            restore: {},
                            saveAsImage: {}
                        }
                    },
                    visualMap: {
                        top: 10,
                        right: 10,
                        pieces: [{
                            gt: 0,
                            color: '#99CCFF'
                        }],
                        outOfRange: {
                            color: '#999'
                        }
                    },
                    series: {
                        name: '新增用户',
                        type: 'line',
                        data: data,
                        markLine: {
                            silent: true,
                            data: [{
                                yAxis: 50
                            }, {
                                yAxis: 100
                            }, {
                                yAxis: 150
                            }, {
                                yAxis: 200
                            }, {
                                yAxis: 300
                            }]
                        }
                    }
                });
            }
        });
    }
}