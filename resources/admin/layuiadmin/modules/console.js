/** layuiAdmin.std-v1.0.0-beta7 LPPL License By http://www.layui.com/admin/ */
;
layui.define(function(e) {
    layui.use(["admin", "carousel"],
    function() {
        var e = layui.$,
        t = (layui.admin, layui.carousel),
        a = layui.element,
        i = layui.device();
        e(".layadmin-carousel").each(function() {
            var a = e(this);
            t.render({
                elem: this,
                width: "100%",
                arrow: "none",
                interval: a.data("interval"),
                autoplay: a.data("autoplay") === !0,
                trigger: i.ios || i.android ? "click": "hover",
                anim: a.data("anim")
            })
        }),
        a.render("progress")
    }),
    layui.use(["carousel", "echarts","jquery"],
    function() {
        var name = [], list = [];
        var $ = layui.jquery;

var broname = [], bronamelist = [];
    //调用ajax来实现异步的加载数据
    function getusers(type) {
        $.ajax({
            type: "get",
            async: false,
            url: "/admin/main",
            data: {type:type},
            dataType: "json",
            success: function(result){                
            	if(result && type==2){
                    for(var i = 0 ; i < result.length; i++){
                        broname.push(result[i].name);
                        broname;
                        
                    }
                }
                bronamelist[type] = result;
                console.log(bronamelist);
            },
            error: function(errmsg) {
                alert("Ajax获取服务器数据出错了！"+ errmsg);
            }
        });
      return broname, bronamelist;
    }
    //调用ajax来实现异步的加载数据

    // 执行异步请求
    getusers(1);
    getusers(2);
    getusers(3);

        var e = layui.$,
        t = layui.carousel,
        a = layui.echarts,
        i = [],
        l = [{
            title: {
                text: "今日流量趋势",
                x: "center",
                textStyle: {
                    fontSize: 14
                }
            },
            tooltip: {
                trigger: "axis"
            },
            legend: {
                data: ["", ""]
            },
            xAxis: [{
                type: "category",
                boundaryGap: !1,
                data: bronamelist[1].date
            }],
            yAxis: [{
                type: "value"
            }],
            series: [{
                name: "PV",
                type: "line",
                smooth: !0,
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: "default"
                        }
                    }
                },
                data: bronamelist[1].num
            },
//            {
//                name: "UV",
//                type: "line",
//                smooth: !0,
//                itemStyle: {
//                    normal: {
//                        areaStyle: {
//                            type: "default"
//                        }
//                    }
//                },
//                data: [11, 22, 33, 44, 55, 66, 333, 3333, 5555, 12666, 3333, 333, 666, 1188, 2666, 3888, 6666, 4222, 3999, 2888, 1777, 966, 655, 555, 333, 222, 311, 699, 588, 277, 166, 99, 88, 77]
//            }
        ]
        },
        {
            title: {
                text: "访客浏览器分布",
                x: "center",
                textStyle: {
                    fontSize: 14
                }
            },
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: "vertical",
                x: "left",
                data: broname
            },
            series: [{
                name: "访问来源",
                type: "pie",
                radius: "55%",
                center: ["50%", "50%"],
                data: bronamelist[2]
            }]
        },
        {
            title: {
                text: "最近一月新增的用户量",
                x: "center",
                textStyle: {
                    fontSize: 14
                }
            },
            tooltip: {
                trigger: "axis",
                formatter: "{b}<br>新增用户：{c}"
            },
            xAxis: [{
                type: "category",
                data: bronamelist[3].date
            }],
            yAxis: [{
                type: "value"
            }],
            series: [{
                type: "line",
                data: bronamelist[3].num
            }]
        }],
        n = e("#LAY-index-dataview").children("div"),
        r = function(e) {
            i[e] = a.init(n[e], layui.echartsTheme),
            i[e].setOption(l[e]),
            window.onresize = i[e].resize
        };
        if (n[0]) {
            r(0);
            var o = 0;
            t.on("change(LAY-index-dataview)",
            function(e) {
                r(o = e.index)
            }),
            layui.admin.on("side",
            function() {
                setTimeout(function() {
                    r(o)
                },
                300)
            }),
            layui.admin.on("hash(tab)",
            function() {
                layui.router().path.join("") || r(o)
            })
        }
    }),
    layui.use("table",
    function() {
        var e = (layui.$, layui.table);
        e.render({
            elem: "#LAY-index-topSearch",
            url: "/admin/getArticle",
            page: !0,
            cols: [[
            {
                field: "art_thumb",
                title: "预览图",
                width:"6%",
                templet: "<div class='slt'><img src='{{d.art_thumb }}'></div>"
            },
            {
                field: "art_title",
                title: "标题",
                minWidth: 420,
                sort: !0
            },
            {
                field: "defectsname",
                title: "分类",
                maxWidth: 20,
                sort: !0
            },
            {
                field: "art_view",
                title: "点击率",
                maxWidth: 10,
                sort: !0
            }]],
            skin: "line"
        }),
        e.render({
            elem: "#LAY-index-topCard",
            url: "/admin/getUser",
            page: !0,
            cellMinWidth: 20,
            cols: [[
            {
                field: "userface",
                title: "头像",
                maxWidth: 30,
                templet: "<div><img src='{{d.userface }}'></div>"
            },
            {
                field: "nickname",
                title: "昵称"
            },
            {
                field: "created_at",
                title: "加入时间"
            }]],
            skin: "line"
        })
    }),
    e("console", {})
});