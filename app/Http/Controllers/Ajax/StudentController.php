<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    use JsonResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = DB::table('students')->get();
        return view('site.students.index', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|min:3',
            'email'     => 'required|email|unique:students,email',
        ]);

        if($validator->fails()) {
            return $this->jsonResponse(false, 'Validation Errors', $validator->errors());
        } else {
            $student = Student::create($request->except(['_token']));
            return $this->jsonResponse(true, 'Student Added Successfully', $student);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|min:3',
            'email'     => 'required|email|unique:students,email,' . $id,
        ]);

        $student = Student::find($id);

        if(!$student) return $this->jsonResponse(false, "This Student Doesn't Exist!", null);

        if($validator->fails()) {
            return $this->jsonResponse(false, "Validation Errors", $validator->errors());
        } else {
            $student->update($request->except(['_token', '_method']));
            return $this->jsonResponse(true, "Student Updated Successfully!", $student);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if($student) {
            $student->delete();
            return $this->jsonResponse(true, 'Student Deleted Successfully!', null);
        } else {
            return $this->jsonResponse(false, 'This Student Doesn\'t Exist!', null);
        }
    }
}
