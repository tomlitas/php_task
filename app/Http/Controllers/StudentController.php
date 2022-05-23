<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $project = Project::find($id);

        return view('student.create',compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->project_id);
        $request->validate([
            'full_name' => 'required',
            'project_id' => 'required',
            
        ]);
        $project = Project::find($request->project_id);
        $student = Student::where('full_name', $request->full_name)->first();
        $exist = false;
        if ($student){
            $exist = $student->projects()->where('project_id', $request->project_id)->exists();
        }

        if ($exist) {
            return redirect()->back()->with('error', 'This student exists in the project');
        }

        if ($student){
            $student->projects()->attach($request->project_id);
            return redirect()->route('projects.show', compact('project'));
        }

        $student = new Student;
        $student->full_name = $request->full_name;
        $student->project_id = $request->project_id;
        $student->save();

        $student->projects()->attach($request->project_id);
        return redirect()->route('project.show',  compact('project'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request)
    {
        
        $request->validate([
            'project_id' => 'required',
            'group_num' => 'required',
            'full_name' => 'required',
        ]);
        
        $group = Group::where('project_id', $request->project_id)->where('group_num', $request->group_num)->first();
        $student = Student::where('full_name', $request->full_name)->first();
        
        $projectGroups = Group::where('project_id', $request->project_id)->get();
        foreach ($projectGroups as $projectGroup) {
            if ($projectGroup->students()->where('student_id', $student->id)->exists()){
                return redirect()->back();
            }
        }

        $student->groups()->attach($group->id);
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $student = Student::find($request->student_id);
        
        $ifProjectIs = $student->projects()->where('student_id', $student->id)->exists();
        if ($ifProjectIs){
            $student->delete();
        }
        return redirect()->back();
    }
}
