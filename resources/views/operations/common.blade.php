@extends('layouts.layout')

@section('content')
{{-- <h1 class="text-center" style="margin-top: 10rem;">Welcome to opertions</h1> --}}

<div class="card-body pad table-responsive">
    
    <table class="table table-bordered text-center">

      <tr>
        <td>
          <button type="button" class="btn btn-block btn-default" id="fetchCountries">Fetch Countries</button>
        </td>
        <td>
            <button type="button" class="btn btn-block btn-primary" id="listEmployeeData">Employee List</button>
        </td>
        <td>
            <button type="button" class="btn btn-block btn-secondary"><a href="/user-company-details">Company details</a></button>
        </td>
        <td>
            <button type="button" class="btn btn-block btn-success">Success</button>
        </td>
        <td>
            <button type="button" class="btn btn-block btn-info">Info</button>
        </td>
        <td>
            <button type="button" class="btn btn-block btn-danger">Danger</button>
        </td>
        <td>
            <button type="button" class="btn btn-block btn-warning">Warning</button>
          </td>
    </tr>


    </table>
  </div>



@endsection


@push('scripts')
<script>
    
    $(document).ready( function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#fetchCountries').click(function () {
            $.ajax({
                type:'GET',
                url:"{{ route('operations.fetch-countries') }}",
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        $('#listEmployeeData').click(function () {
            $.ajax({
                type:'GET',
                url:"{{ route('operations.employee-listing') }}",
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

    });

</script>
@endpush