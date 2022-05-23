@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Studen</div>
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">{{ $message }}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('student.store') }}" class="mt-3">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <input name="full_name" value=""
                                    type="text" class="form-control" placeholder="Full name" >
                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                @error('full_name')
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