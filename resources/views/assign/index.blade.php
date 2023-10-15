@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Schedule Bus</h2>
        </div>
        <div class="pull-right">
        @can('assign-create')
            <a class="btn btn-success" href="{{ route('assign.create') }}"> Schedule</a>
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
   <th>Bus</th>
   <th>From Location</th>
   <th>To Location</th>
   <th>Assigned Date</th>
   <th>Assigned by</th>
   <th width="280px">Action</th>
 </tr>
{{$assigns}}

 @foreach ($assigns as $key => $data)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $data->bus_id }}</td>
    <td>{{ $data->location_id_from }}</td>
    <td>{{ $data->location_id_end }}</td>
    <td>
     {{$data->assign_date}}
    </td>
    <td>
     {{$data->assign_by}}
    </td>
    <td>
       <a class="btn btn-info" href="{{ route('assign.show',$data->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('assign.edit',$data->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['assign.destroy', $data->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>

{!! $assigns->render() !!}

@endsection