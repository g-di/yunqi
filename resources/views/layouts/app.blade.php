<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>微信管理后台</title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/bower_components/AdminLTE/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css">
    <script src="http://cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
        var AdminLTEOptions = {
            //Enable sidebar expand on hover effect for sidebar mini
            //This option is forced to true if both the fixed layout and sidebar mini
            //are used together
            sidebarExpandOnHover: true,
            //BoxRefresh Plugin
            enableBoxRefresh: true,
            //Bootstrap.js tooltip
            enableBSToppltip: true
        };
    </script>
    <script src="/bower_components/AdminLTE/dist/js/app.min.js" type="text/javascript"></script>
</head>

<body class="skin-blue">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">微信管理后台</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

        </nav>
    </header>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-star-half-full "></i>
                        <span>注册用户</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{strpos(Request::path(),'yun/user')!==false?'active':''}}">
                            <a href="{{url("/yun/user")}}"><i class="fa fa-circle-o"></i>用户管理</a>
                        </li>
                        <li class="{{strpos(Request::path(),'yun/temp')!==false?'active':''}}">
                            <a href="{{url("/yun/temp")}}"><i class="fa fa-circle-o"></i>模板素材</a>
                        </li>
                    </ul>
                </li>
                {{--<li class="header">系统</li>--}}
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-star-half-full "></i>
                        <span>微信管理</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{strpos(Request::path(),'ad_user/index')!==false?'active':''}}">
                            <a href="{{url("/ad_user/index")}}"><i class="fa fa-circle-o"></i>用户管理</a>
                        </li>
                        <li class="{{strpos(Request::path(),'wechat/menu')!==false?'active':''}}">
                            <a href="{{url("/wechat/menu")}}"><i class="fa fa-circle-o"></i>自定义菜单</a>
                        </li>
                        <li class="{{strpos(Request::path(),'media ')!==false?'active':''}}">
                            <a href="{{url("/media ")}}"><i class="fa fa-circle-o"></i>素材管理</a>
                        </li>
                        <li class="{{strpos(Request::path(),'mass/index')!==false?'active':''}}">
                            <a href="{{url("/mass/index")}}"><i class="fa fa-circle-o"></i>正式群发</a>
                        </li>
                        <li class="{{strpos(Request::path(),'mass/test')!==false?'active':''}}">
                            <a href="{{url("/mass/test")}}"><i class="fa fa-circle-o"></i>测试群发</a>
                        </li>
                        <li class="{{strpos(Request::path(),'wechat/follow')!==false?'active':''}}">
                            <a href="{{url("/wechat/follow")}}"><i class="fa fa-circle-o"></i>关注回复</a>
                        </li>
                        <li class="{{strpos(Request::path(),'wechat/rule')!==false?'active':''}}">
                            <a href="{{url("/wechat/rule")}}"><i class="fa fa-circle-o"></i>关键字回复</a>
                        </li>
                        <li class="{{strpos(Request::path(),'message')!==false?'active':''}}">
                            <a href="{{url("/message")}}"><i class="fa fa-circle-o"></i>粉丝消息</a>
                        </li>
                        <li class="{{strpos(Request::path(),'template/list')!==false?'active':''}}">
                            <a href="{{url("/template/list")}}"><i class="fa fa-circle-o"></i>模板消息</a>
                        </li>
                        <li class="{{strpos(Request::path(),'qrcode')!==false?'active':''}}">
                            <a href="{{url("/qrcode")}}"><i class="fa fa-circle-o"></i>定义二维码</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>
</body>
</html>
