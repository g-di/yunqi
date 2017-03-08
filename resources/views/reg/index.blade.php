<!doctype html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
    <link rel="stylesheet" href="/static/css/normalize3.0.2.min.css"/>
    <link rel="stylesheet" href="/static/css/style.css"/>
    <link href="/static/css/mobiscroll.css" rel="stylesheet"/>
    <link href="/static/css/mobiscroll_date.css" rel="stylesheet"/>
    <style>
        *, body, div, img, a, p, h2 {
            margin: 0px;
            padding: 0px;
            border: 0px;
        }

        body {
            background-color: #00a0e9;
            text-align: center;
            font-size: 14px;
        }

        .reg_tit {
            margin: 30px auto 40px;
        }

        .reg_input {
            -webkit-appearance: none;
            width: 70%;
            height: 26px;
            line-height: 34px;
            outline: none;
            border: 1px solid #6ce26c;
            margin: 20px auto;
            padding: 4px 12px;
        }

        .reg_sub {
            padding: 10px 20px;
            height: 36px;
            line-height: 20px;
            color: #1e282c;
            background-color: #9FAFD1;
            font-weight: bold;
            border-radius: 6px;
            margin-top: 60px;;
        }
    </style>
</head>
<body>
<div>
    <h2 class="reg_tit">注册</h2>
    <div class="reg_con">
        <form action="#" method="post">
            <input class="reg_input" type="text" name="name" value="" placeholder="姓名">
            <input class="reg_input" id="USER_AGE" type="text" name="date" value="" placeholder="孕产期">
            <br>
            <input class="reg_sub" id="tj" type="submit" value="提交">
        </form>
    </div>
</div>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/mobiscroll_date.js" charset="gb2312"></script>
<script src="/static/js/mobiscroll.js"></script>
<script type="text/javascript">
    $(function () {
        var currYear = (new Date()).getFullYear();
        var opt = {};
        opt.date = {preset: 'date'};
        opt.datetime = {preset: 'datetime'};
        opt.time = {preset: 'time'};
        opt.default = {
            theme: 'android-ics light', //皮肤样式
            display: 'modal', //显示方式
            mode: 'scroller', //日期选择模式
            dateFormat: 'yyyy-mm-dd',
            lang: 'zh',
            showNow: true,
            nowText: "今天",
            startYear: currYear - 50, //开始年份
            endYear: currYear + 10 //结束年份
        };
        $("#USER_AGE").mobiscroll($.extend(opt['date'], opt['default']));



    });
</script>
</body>
</html>