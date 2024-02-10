<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Http\Requests\TeacherRequest;

class TeacherController extends Controller
{

    public function index(){
        $teachers = Teacher::paginate(10);
        return view('teacher.index', compact('teachers'));
    }


    public function addEdit(Teacher $teacher=null){
        return view('teacher.addEdit', compact('teacher'));
    }

    public function storeUpdate(TeacherRequest $request, Teacher $teacher=null){
        $data = $request->validated();

        if($teacher != null){
            $teacher->update($data);

            $notification = array(
                'message' =>    'Profesorul a fost modificat cu succes!',
                'alert-type'    => 'success',
            );

        }else{

            Teacher::create($data);

            $notification = array(
                'message' =>    'Profesorul a fost creat cu succes!',
                'alert-type'    => 'success',
            );

        }

        return redirect()->route('teachers.index')->with($notification);
    }

    public function delete(Teacher $teacher){
        $teacher->delete();
        $notification = array(
            'message' =>    'Profesorul a fost sters cu succes!',
            'alert-type'    => 'success',
        );
        return redirect()->route('teachers.index')->with($notification);
    }
}
