@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h1>Create new project</h1></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('project.store') }}" class="mt-3">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <input name="title" value=""
                                    type="text" class="form-control" placeholder="Project name" >
                                @error('project')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input name="how_groups" value=""
                                    type="text" class="form-control" placeholder="How groups">
                                @error('how_groups')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input name="max_student_inGroup" value=""
                                    type="text" class="form-control" placeholder="Max student in Group">
                                @error('max_student_inGroup')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <button type="submit" class="btn btn-success">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection