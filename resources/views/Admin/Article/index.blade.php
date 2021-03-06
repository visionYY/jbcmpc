@extends('layouts.admin')
@section('title','文章')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>文章列表</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">选项 01</a>
                                </li>
                                <li><a href="#">选项 02</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="">
                            <a href="article/create" class="btn btn-primary J_menuItem">添加文章</a>
                        </div>
                        @include('layouts.admin_error')
                         <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th>标题</th>
                                    <th>分类</th>
                                    <th>来源</th>
                                    <th>状态</th>
                                    <th>上传时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($list as $v)
                                <tr class="gradeC">
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->title}}</td>
                                    <td class="center">{{$v->cg_name}}</td>
                                    <td class="center">{{$v->nav_name}}</td>
                                    <td class="center">
                                        @if($v->status == 1)
                                            <span class="label label-info">正常</span>
                                        @else
                                            <span class="label label-danger">禁用</span>
                                        @endif
                                    </td>
                                    <td class="center">{{$v->publish_time}}</td>
                                    <td class="center">
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">操作 <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{url('article/id/'.$v->id)}}" target="_blank">详情</a></li>
                                                <li><a href={{url("admin/article/$v->id/edit")}} class="font-bold">修改</a></li>
                                                <li>
                                                    @if($v->cho != 0)
                                                    <a href="{{url('admin/choiceness/cancel/id/'.$v->cho)}}" >取消精选</a>
                                                    @else
                                                    <a href={{url('admin/choiceness/setting/type/1/id/'.$v->id)}} >设置精选</a>
                                                    @endif
                                                </li>
                                                <li class="divider"></li>
                                                <li><a href="javascript:;" id="{{$v->id}}" class="delete" url="{{url('admin/article/'.$v->id)}}">删除</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <?php echo $list->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     @include('layouts.admin_js')
    <script src={{asset("Admin/js/plugins/footable/footable.all.min.js")}}></script>
    <!-- <script src={{asset("Admin/js/plugins/layer/layer.min.js")}}></script> -->
    <script src={{asset("Admin/js/plugins/sweetalert/sweetalert.min.js")}}></script>
    <script>
        $(document).ready(function(){$(".footable").footable();$(".footable2").footable()});
    </script>
    @include('layouts.admin_delete')
@stop