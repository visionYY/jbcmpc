<?php

namespace App\Http\Controllers\Admin;

use App\Models\TutorStudent;
use App\Services\Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorStudentController extends Controller
{
    //首页
    public function index(){
        $list = TutorStudent::paginate(20);
        return view('Admin.TutorStudent.index',compact('list',$list));
    }

    //展示(单条)
    public function show($id){

    }

    //添加
    public function create(){
        return view('Admin.TutorStudent.create');
    }

    //执行添加
    public function store(Request $request){
        $verif = array('name'=>'required|unique:tutor_student',
            'type'=>'required|numeric',
            'position'=>'required',
            'intro'=>'required',
            'classic_quote'=>'required',
            'head_pic'=>'required');
        $credentials = $this->validate($request,$verif);
        //上传头像
        $pic_path = Upload::baseUpload($credentials['head_pic'],'upload/TutorStudent');
        if ($pic_path){
            $credentials['head_pic'] = $pic_path;
        }else{
            return back() -> with('hint',config('hint.upload_failure'));
        }
        if (TutorStudent::create($credentials)){
            return redirect('admin/tutorStudent')->with('success', config('hint.add_success'));
        }else{
            return back()->with('hint',config('hint.add_failure'));
        }
    }

    //修改
    public function edit($id){
        $tutor = TutorStudent::find($id)->toArray();
        return view('Admin.TutorStudent.edit',compact('tutor',$tutor));
    }

    //执行修改
    public function update(Request $request,$id){
        $verif = array('name'=>'required|unique:tutor_student,name,'.$id,
            'type'=>'required|numeric',
            'position'=>'required',
            'intro'=>'required',
            'classic_quote'=>'required');
        $credentials = $this->validate($request,$verif);
        //图像上传
        if ($request->get('head_pic')){
            $pic_path = Upload::baseUpload($request->get('head_pic'),'upload/TutorStudent');
            if ($pic_path){
                $credentials['head_pic'] = $pic_path;
                @unlink(public_path($request->get('head_old_pic')));
            }else{
                return back() -> with('hint',config('hint.upload_failure'));
            }
        }else{
            $credentials['head_pic'] = $request->get('head_old_pic');
        }
        if(TutorStudent::find($id)->update($credentials)){
            return redirect('admin/tutorStudent')->with('success', config('hint.mod_success'));
        }else{
            return back()->with('hint',config('hint.mod_failure'));
        }
    }

    //删除
    public function destroy($id){
        $tutorObj = TutorStudent::find($id);
        if (!$tutorObj){
            return back() -> with('hint',config('hint.data_exist'));
        }
        $tutor = $tutorObj->toArray();
        if (TutorStudent::destroy($id)){
            unlink(public_path($tutor['head_pic']));
            return back() -> with('success',config('hint.del_success'));
        }else{
            return back() -> with('hint',config('hint.del_failure'));
        }
    }
}
