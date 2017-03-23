@extends(config("app.extends")) @section('content')
    <!-- 配置文件 -->
    <script type="text/javascript" src="/assets/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/assets/ueditor/ueditor.all.min.js"></script>
    <section class="content-header">
        <h1>
            模板列表
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">模板列表</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="/yun/tempupd" method="post">
                                {{ csrf_field() }}
                                <div class="">
                                    <div class="box-body">
                                        <div id="example2_wrapper">
                                            <div class="row">
                                                <div class="col-sm-12 template">
                                                    <div class="box-header with-border box-danger form-group">
                                                        <label class="col-sm-2 control-label right-lable">选择模板:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control selectpicker show-tick"
                                                                    id="temp" data-style="btn-info" name="tid">
                                                                <option value=""></option>
                                                                @foreach($list as $value)
                                                                    <option value="{{$value->id}}">{{$value->title}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                                $('#temp').val('<?=$info[0]['id']?>');
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div id="html">
                                                        <?php $i = 0; foreach (json_decode($temp['data']) as $k => $v): ?>
                                                        <div class="box-header with-border box-danger form-group">
                                                            <label class="col-sm-2 control-label right-lable"><?=$info[$i]['value']?>:</label>
                                                            <input type="hidden" name="gdk<?=$i?>" value="<?=$k?>"/>
                                                            <div class="col-sm-10">
                                                                <input name="gdkey<?=$i?>" type="text" value="<?=$v?>" required="" class="form-control"/>
                                                            </div>
                                                        </div>
                                                        <?php $i++; endforeach;?>
                                                    </div>
                                                    <div class="box-header with-border box-danger form-group">
                                                        <label class="col-sm-2 control-label right-lable">预产期周数:</label>
                                                        <div class="col-sm-10">
                                                            <span>第<?=$temp['num']?>周</span>
                                                            <input type="hidden" name="num" value="<?=$temp['num']?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>正文</label>
                                                        <!-- 加载编辑器的容器 -->
                                                        <script id="mm_container" name="content"
                                                                type="text/plain"><?=$temp['content']?></script>

                                                        <!-- 实例化编辑器 -->
                                                        <script type="text/javascript">
                                                            var ue_multi = UE.getEditor('mm_container', {
                                                                toolbars: [['source',
                                                                    'undo',
                                                                    'redo',
                                                                    'bold',
                                                                    'italic',
                                                                    'underline',
                                                                    'justifyleft', //居左对齐
                                                                    'justifyright', //居右对齐
                                                                    'justifycenter', //居中对齐
                                                                    'forecolor',
                                                                    'backcolor',
                                                                    'removeformat',
                                                                    '|',
                                                                    'insertorderedlist',
                                                                    'insertunorderedlist',
                                                                    'simpleupload',
                                                                    'link',
                                                                    'insertvideo'
                                                                ]],
                                                                initialFrameHeight: 200
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="form-group col-sm-12 form-submit"
                                                         style="padding-bottom: 0">
                                                        <input type="submit" value="保存" name="resubmit"
                                                               class="btn btn-primary"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(function () {
            $('#temp').bind('change', function () {
                if ($(this).val() != '') {
                    $.ajax({
                        url: '/yun/tempinfo',
                        type: 'POST', //GET
                        async: true, //或false,是否异步
                        data: {
                            id: $(this).val()
                        },
                        timeout: 5000, //超时时间
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            var html = ''
                            $.each(data, function (i, v) {
                                html += '<div class="box-header with-border box-danger form-group">';
                                html += '<label class="col-sm-2 control-label right-lable">' + v.value + ':</label>';
                                html += '<input type="hidden" name="gdk' + i + '" value="' + v.key + '">';
                                html += '<div class="col-sm-10"><input name="gdkey' + i + '" type="text" value="" required class="form-control"></div></div>';
                                console.log(v.value);
                                console.log(v.key);
                            });
                            $('#html').html(html);
                        }
                    })
                } else {
                    $('#html').html('');
                }
            });
        });
    </script>
@endsection
