@extends('adminlte::page')

@section('content')
    <div class="card card-primary">
        <div class="card-heading  pl-4 pt-2">Create New Message</div>
        <div class="card-body">
            <a href="{{ url('/admin/messages') }}" title="Back"><button class="btn btn-warning btn-md"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
            <br />
            <br />


                {!! Form::open(['url' => '/admin/messages', 'class' => 'form-horizontal', 'files' => true]) !!}

                @include ('admin.messages.form', ['formMode' => 'create'])

                {!! Form::close() !!}


        </div>
    </div>
@endsection
