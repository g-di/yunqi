@extends(config("app.extends"))
@section('content')
    <section class="content-header">
        <h1>
            模板素材
        </h1>
    </section>
    <div class="row">
        <div class="col-sm-12">
            @include("layouts.message")
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-header with-border box-danger">
                        <h3 class="box-title">素材列表</h3>
                        <div class="box-tools">
                            <a href="/yun/tempadd" class="pull-left">
                                <label class="col-sm-1 control-label right-lable">
                                    <i class="fa fa-plus-circle btn btn-success btn-md btn-add"></i>
                                </label>
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-hover dataTable text-center"
                                           role="grid"
                                           aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting col-sm-2" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Browser: activate to sort column ascending">
                                                孕产期
                                            </th>
                                            <th class="sorting col-sm-1" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Platform(s): activate to sort column ascending">
                                                模板名称
                                            </th>
                                            <th class="sorting col-sm-2" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                链接内容
                                            </th>
                                            <th class="sorting col-sm-2" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                更新时间
                                            </th>
                                            <th class="sorting col-sm-2" aria-controls="example2" rowspan="1"
                                                colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list as $value)
                                            <tr role="row" class="odd">
                                                <td>第{{$value->num}}周</td>
                                                <td>{{$value->title}}</td>
                                                <td><a href="/yun/{{$value->id}}" target="_blank">查看</a></td>
                                                <td>{{$value->updated_at}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <div class="btn-group">
                                                            <a type="button" href="#" class="btn btn-default"
                                                               data-toggle="dropdown">操作</a>
                                                            <button type="button"
                                                                    class="btn btn-default dropdown-toggle"
                                                                    data-toggle="dropdown">
                                                                <span class="caret"></span>
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li>
                                                                    <a href="{{url("/yun/tempupd/".$value->id)}}">修改</a>
                                                                    <a class="btn-delete" data-toggle="modal"
                                                                       data-target="#myModal"
                                                                       data-val="{{url("/yun/tempdel/".$value->id)}}">删除</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
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
    @include("layouts.myModal")
@endsection