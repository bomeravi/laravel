@extends('adminlte::page')
@extends('adminlte::page')

@section('content')
    <div class="card card-primary">
        <div class="card-heading">
            <h3 class="card-title pl-4 pt-2">Messages</h3>
        </div>
        <div class="card-body">
            <a href="{{ url('/admin/messages/create') }}" class="btn btn-success btn-md" title="Add New Message">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New
            </a

            {!! Form::open(['method' => 'GET', 'url' => '/admin/messages', 'class' => 'form-inline my-2 my-lg-0 pull-right', 'role' => 'search'])  !!}
            <div class="" style="float:right;">
                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                <span class="input-group-append" style="display:none;">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
            </div>
            {!! Form::close() !!}

            <br/>

            @if(Session::has('flash_message'))
                <div class="mt-2">

                <p class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('flash_message') }}</p>
                </div>
            @endif

            <br/>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Email</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $item)
                        <tr>
                            <td>{{ $loop->iteration or $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->email }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $messages->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>

        </div>
    </div>
@endsection
