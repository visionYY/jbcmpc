@extends('layouts.admin')
@section('title','视频修改')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>视频修改</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="form_basic.html#">选项1</a>
                                </li>
                                <li><a href="form_basic.html#">选项2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form action={{url('admin/video/'.$data['video']['id'])}} class="form-horizontal m-t" id="signupForm" method="POST" enctype="multipart/form-data">
                            @include('layouts.admin_error')
                            <!-- 标题： -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">标题：</label>
                                <div class="col-sm-8">
                                    <input  name="title" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" value="{{$data['video']['title']}}">
                                </div>
                            </div>
                            <!-- 视频地址 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">视频地址：</label>
                                <div class="col-sm-8">
                                    <input name="address" class="form-control" type="text" value="{{$data['video']['address']}}">
                                    <!-- <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 这里写点提示的内容</span> -->
                                </div>
                            </div>
                            <!-- 视频时长 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">视频时长：</label>
                                <div class="col-sm-8">
                                    <input name="duration" class="form-control" type="text" value="{{$data['video']['duration']}}">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 时长格式：时：分：秒，例 00:21:46</span>
                                </div>
                            </div>
                            <!-- 分类 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">分类：</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="cg_id">
                                        @foreach($data['cate'] as $cate)
                                        <option value={{$cate['id']}} {{$cate['id']==$data['video']['cg_id']? 'selected' : ''}}>{{$cate['cg_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- 导航 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">导航：</label>
                               <div class="col-sm-6">
                                <select class="form-control" name="nav_id">
                                    @foreach($data['nav'] as $nav)
                                    <option value={{$nav['id']}} {{$nav['id']==$data['video']['nav_id']? 'selected' : ''}}>{{$nav['text']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <!-- 发布时间 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">发布时间：</label>
                                <div class="col-sm-6">
                                    <input class="form-control layer-date" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" name="publish_time" value="{{$data['video']['publish_time']}}">
                                    <label class="laydate-icon"></label>
                                </div>
                            </div>
                            <!-- 发布者 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">发布者：</label>
                                <div class="col-sm-8">
                                    <input name="author" class="form-control" type="text" value="{{$data['video']['author']}}">
                                </div>
                            </div>
                            <!-- 标签 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">标签：</label>
                                <div class="col-sm-6">
                                    <select data-placeholder="{{$data['video']['labels'] ? $data['video']['labels'] : '选择标签'}}" class="chosen-select" multiple style="width:100%;" tabindex="4" name="labels[]">
                                        @foreach($data['label'] as $label)
                                        <option value="{{$label['name']}}" hassubinfo="true">{{$label['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- 封面 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">封面：</label>
                                <div class="col-sm-8">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> 选择图片</button>
                                </div>
                            </div>
                             <!-- 封面 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-8">
                                    <img width="100px;" src="{{$data['video']['cover']}}" id="cover">
                                </div>
                            </div>
                             <!-- 简介 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">简介：</label>
                                <div class="col-sm-8">
                                    <textarea class="form-group" style="width: 100%;height: 150px;resize: none;" name="intro">{{$data['video']['intro']}}</textarea>
                                    <!-- <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 这里写点提示的内容</span> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="old_cover" value="{{$data['video']['cover']}}">
                                            <input type="hidden" name="old_labels" value="{{$data['video']['labels']}}">
                                            <input type="hidden" name="_method" value="put"/>
                                            <input type="hidden" name="cover">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit">提交</button>
                                    <a class="btn btn-outline btn-default" href={{url("admin/video")}} >返回</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.admin_js')
    <script src={{asset("Admin/js/plugins/layer/laydate/laydate.js")}}></script>
    
    <script src={{asset("Admin/js/plugins/chosen/chosen.jquery.js")}}></script>
    <script src={{asset("Admin/js/demo/form-advanced-demo.min.js")}}></script>

    @include('layouts.admin_picpro')
    <script type="text/javascript">
        var sgw = $('[name=scre_gm_width]').val(),
            sgh = $('[name=scre_gm_height]').val(),
            ogw = $('[name=opt_gm_width]').val(),
            ogh = $('[name=opt_gm_height]').val();
        //图片比例 814:513
        var clipArea = new bjj.PhotoClip("#clipArea", {
        size: [sgw, sgh],
        outputSize: [ogw, ogh],
        file: "#file",
        view: "#view",
        ok: "#clipBtn",
        loadStart: function() {
            console.log("照片读取中");
        },
        loadComplete: function() {
            console.log("照片读取完成");
        },
        clipFinish: function(dataURL) {
            // console.log(dataURL);
            $('#cover').attr('src',dataURL);
            $('[name=cover]').attr('value',dataURL);
        }
    });
    </script>
@stop
