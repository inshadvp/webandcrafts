@extends('employees.layout')
 
@section('content')
    <div class="row p-4">
        <div class="col-lg-12 margin-tb row">
            <div class="pull-left col-lg-9">
                <h2>Employees List</h2>
            </div>
            <div class="pull-right col-lg-3">
                <a class="btn btn-success" href="{{ route('employees.create') }}"> Create New Employee</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <div class="row p-4">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="table_id" class="table table-bordered table-striped mb-2">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Photo</th>
                <th>Designation</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td class="text-center">
                    <img height="50px" width="50px" src="{{ ($employee->photo != '') ? URL::asset("photos/".$employee->photo) : URL::asset("photos/no_image.png") }}" alt=""></td>
                <td>{{ $employee->designation_name }}</td>
                <td>
                    <form action="{{ route('employees.destroy',$employee->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('employees.edit',$employee->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
            </table>
            {!! $employees->links() !!}
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@push('scripts')
<script>
  $(document).ready( function () {
    $('#table_id').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
} );
</script>

@endpush