@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Location List</h2>
            </div>
            <div class="pull-right">
                @can('location-create')
                <a class="btn btn-success" href="{{ route('location.create') }}"> Create New location</a>
                @endcan
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Platforn Data</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($locations as $location)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $location->name }}</td>
	        <td>{{ $location->platform_no }}</td>
	        <td>
                <form action="{{ route('location.destroy',$location->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('location.show',$location->id) }}">Show</a>
                    @can('location-edit')
                    <a class="btn btn-primary" href="{{ route('location.edit',$location->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('location-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

    {!! $locations->links() !!}
@endsection
