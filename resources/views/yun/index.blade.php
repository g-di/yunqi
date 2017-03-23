@extends(config("app.extends"))
@section('content')
    <section class="content-header">
        <h1>
            用户管理
            {{--<small>用于查找用户发送测试群发消息</small>--}}
        </h1>
    </section>
    <section class="content">
        {{--<div class="row">--}}
            {{--<div class="col-xs-12">--}}
                {{--<div class="box">--}}
                    {{--<div class="box-header with-border">--}}
                        {{--<h3 class="box-title">搜索</h3>--}}
                        {{--<div class="box-tools"></div>--}}
                    {{--</div>--}}
                    {{--<div class="box-body">--}}
                        {{--<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">--}}
                            {{--<form class="form-inline" role="form" method="get" id="frmSearch">--}}
                                {{--<div class="form-group col-sm-2">--}}
                                    {{--<input type="text" name="nickname" class="form-control input-sm" style="width:9em" placeholder="请输入昵称">--}}
                                {{--</div>&nbsp;--}}
                                {{--<div class="form-group col-sm-2" >--}}
                                    {{--<label class="radio-inline">--}}
                                        {{--<input type="radio" name="sex" id="sex1" value="1"> 男--}}
                                    {{--</label>--}}
                                    {{--<label class="radio-inline">--}}
                                        {{--<input type="radio" name="sex" id="sex2" value="2"> 女--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-sm-2">--}}
                                    {{--<label class="radio-inline">--}}
                                        {{--<input type="radio" name="status" id="status0" value="0"> 关注--}}
                                    {{--</label>--}}
                                    {{--<label class="radio-inline">--}}
                                        {{--<input type="radio" name="status" id="status1" value="1"> 取关--}}
                                    {{--</label>--}}
                                {{--</div>&nbsp;--}}
                                {{--<input type="submit" class="btn  btn-success" value="搜索">&nbsp;--}}
                                {{--<a href="/ad_user/index" class="btn  btn-primary">重置搜索条件</a>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-header with-border box-danger">
                        <h3 class="box-title">用户列表</h3>
                    </div>
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-hover dataTable text-center" role="grid"
                                           aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting col-sm-2" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Browser: activate to sort column ascending">
                                                姓名
                                            </th>
                                            <th class="sorting col-sm-1" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Platform(s): activate to sort column ascending">
                                                预产期
                                            </th>
                                            <th class="sorting col-sm-1" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Platform(s): activate to sort column ascending">
                                                IP
                                            </th>
                                            <th class="sorting col-sm-1" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Platform(s): activate to sort column ascending">
                                                地址
                                            </th>
                                            <th class="sorting col-sm-1" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Platform(s): activate to sort column ascending">
                                                注册设备（不完全）
                                            </th>
                                            <th class="sorting col-sm-2" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                注册时间
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list as $value)
                                            <tr role="row" class="odd">
                                                <td>{{$value->name}}</td>
                                                <td>{{$value->date}}</td>
                                                <td>{{$value->ip}}</td>
                                                <td>{{$value->cname}}</td>
                                                <td>{{$value->device}}</td>
                                                <td>{{$value->created_at}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @include("pagination.tfoot",['paginator'=>$list])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection