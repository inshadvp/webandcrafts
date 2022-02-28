@extends('layouts.layout')
   
@section('content')
    <div class="row p-4">
        <div class="col-lg-12 margin-tb row">
            <div class="pull-left col-lg-11">
                <h2>Edit Employee</h2>
            </div>
            <div class="pull-right col-lg-1">
                <a class="btn btn-primary" href="{{ route('employees.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row p-4 m-0">
        <form action="{{ route('employees.update',$employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <input type="hidden" name="id" class="form-control" value="{{ $employee->id }}">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $employee->name }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $employee->email }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Photo:</strong>
                        <input type="file" name="photo" />
                        @if($employee->photo != '')
                        <img src="{{ URL::to('/') }}/photos/{{ $employee->photo }}" class="img-thumbnail" width="100" />
                            <input type="hidden" name="hidden_image" value="{{ $employee->photo }}" />
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Designation:</strong>
                        <select name="designation" id="designation" class="form-control"
                                >
                            <option value="{{old('designation')}}" selected disabled>Select Designation</option>
                            @foreach($designations as $c)
                                <option value="{{$c['id']}}" {{ $employee->designation == $c['id'] ? 'selected' : '' }}>{{$c['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </div>
@endsection