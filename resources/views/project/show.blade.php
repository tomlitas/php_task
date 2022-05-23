@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header">Info</div>
                    <div class="card-body">
                        @foreach ($projects as $project)
                            <p>Project: <strong> {{ $project->title }}</strong></p>
                            <p>Number of groups: <strong> {{ $project->how_groups }}</strong></p>
                            <p>Students per group: <strong> {{ $project->max_student_inGroup }}</strong></p>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container py-4">
        <div class="row justify-content-center">
            <tbody>
                @for ($i = 1; $i <= $project->how_groups; $i++)
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-header"> Group #{{ $i }} </div>
                            <div class="card-body">
                                @php
                                    
                                    $groups = $project->groups()->get();
                                    $group = $groups->where('group_num', $i)->first();
                                    $students = $project->students()->get();
                                    $studentsArr = [];
                                    foreach ($students as $student) {
                                        array_push($studentsArr, $student->full_name);
                                    }
                                @endphp
                                @for ($j = 1; $j <= $project->max_student_inGroup; $j++)
                                    @if ($group->students()->count() > $j)
                                        <tr>
                                            <td>{{ $studentsArr[$j] }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>
                                                <form action="{{ route('student.assign') }}" onchange="submit();"
                                                    method="POST">
                                                    @csrf
                                                    <select name="full_name" class="form-select"
                                                        aria-label="Default select example">
                                                        <option>Assigin Student</option>
                                                        @foreach ($project->students as $student)
                                                            <option value="{{ $student->full_name }}">
                                                                {{ $student->full_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                    <input type="hidden" name="group_num" value="{{ $i }}">
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                @endfor
            </tbody>
        </div>
    </div>

    <div class="container py-4">
        @if ($project->students->isEmpty())
            <h3>There are no students</h3>
        @else
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Studens</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Student</th>
                                        <th>Group</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->students as $student)
                                        <tr>
                                            <td>{{ ++$g }}</td>
                                            <td>{{ $student->full_name }}</td>
                                            <td>
                                                @php
                                                    $groups = $student
                                                        ->groups()
                                                        ->where('student_id', $student->id)
                                                        ->get();
                                                    $group = $groups->where('project_id', $project->id)->first();
                                                @endphp
                                                @if ($group)
                                                    Group#{{ $group->group_num }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('destroy', $student->id) }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="group_id"
                                                        value="@if ($group) {{ $group->id }} @endif">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            @endif
                            <a class="btn btn-primary" href="{{ route('student.index', $project->id) }}">Add new student</a>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>

@endsection
