@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Bus List</h2>
            </div>
            <div class="pull-right">
                @can('bus-create')
                <a class="btn btn-success mb-4" href="{{ route('bus.create') }}">  New bus</a>
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
            <th>Reg No</th>
            <th>Seat Capacity</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($buses as $bus)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $bus->name }}</td>
            <td>{{ $bus->reg_no }}</td>
            <td>{{ $bus->seat_capacity }}</td>
	        <td>{{ $bus->detail }}</td>
	        <td>
                <form action="{{ route('bus.destroy',$bus->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('bus.show',$bus->id) }}">Show</a>
                    @can('bus-edit')
                    <a class="btn btn-primary" href="{{ route('bus.edit',$bus->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('bus-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

    {!! $buses->links() !!}

@endsection
