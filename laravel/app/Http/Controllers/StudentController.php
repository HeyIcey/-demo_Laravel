<?php 	 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class StudentController extends Controller{
	//学生列表页
	public function index(){
		// $students = Student::get();
		//分也
		$students = Student::paginate(5);
		//把获取的$students值传给页面
		return view('student.index',[
			'students'=>$students]);
	}
	public function create(Request $request){

		$student = new Student();
		if($request->isMethod('POST')){
			//1.控制器验证
			// $this->validate($request,[
			// 	'student.name'=>'required|min:2|max:20',
			// 	'student.age'=>'required|integer',
			// 	'student.sex'=>'required|integer'],
			// 	['required'=>':attribute 为必填项',
			// 	 'min'=>':attribute 长度不符合要求',
			// 	 'integer'=>':attribute 必需为整数'],
			// 	['student.name'=>'姓名',
			// 	 'student.age'=>'年龄',
			// 	 'student.sex'=>'性别']);

			//2.Validator类验证
			$validator = \Validator::make($request->input(),[
				'student.name'=>'required|min:2|max:20',
				'student.age'=>'required|integer',
				'student.sex'=>'required|integer'],
				['required'=>':attribute 为必填项',
				 'min'=>':attribute 长度不符合要求',
				 'integer'=>':attribute 必需为整数'],
				['student.name'=>'姓名',
				 'student.age'=>'年龄',
				 'student.sex'=>'性别']);
			if($validator->fails()){
				return redirect()->back()->withErrors($validator)
				->withInput();
			}

			$data = $request->input('student');
			if(Student::create($data)){
				return redirect('student/index')->with('success','添加成功');
			}else{
				return redirect()->back();
			}
		}
		return view('student.create',[
			'student'=>$student]);
	}
	//保存添加
	public function save(Request $request){
		$data = $request->input('$student');
		$student = new Student();
		$student->name = $data['name'];
		$student->age = $data['age'];
		$student->sex = $data['sex'];
		if($student->save()){
			return redirect('student/index');
		}else{
			return redirect()->back();
		}
	}
	public function update(Request $request, $id){
		$student = Student::find($id);
		if($request->isMethod('POST')){
			$data = $request->input('student');
	
			$this->validate($request,[
				'student.name'=>'required|min:2|max:20',
				'student.age'=>'required|integer',
				'student.sex'=>'required|integer'],
				['required'=>':attribute 为必填项',
				 'min'=>':attribute 长度不符合要求',
				 'integer'=>':attribute 必需为整数'],
				['student.name'=>'姓名',
				 'student.age'=>'年龄',
				 'student.sex'=>'性别']);

			$student->name = $data['name'];
			$student->age = $data['age'];
			$student->sex = $data['sex'];
			if($student->save()){
						return redirect('student/index')->with('success','修改成功-'.$id);
			}

		}

		return view('student.update',[
			'student'=>$student]);
	}

	public function detail($id){
		$student = Student::find($id); //获得Student模型，按ID查找
		return view('student.detail',['student'=>$student]); //把模型分配到视图上去
	}

	public function delete($id){
		$student =Student::find($id);
		if($student->delete()){
			return redirect('student/index')->with('success','删除成功-'.$id);
		}else{
			return redirect('student/index')->with('errors','删除失败-'.$id);
		}
	}
}
?>