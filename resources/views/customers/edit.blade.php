@extends('dashboard', ['pageTitle' => 'Customers &raquo; Edit'])

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right raw-margin-top-24 raw-margin-left-24">
                {!! Form::open(['route' => 'customers.search']) !!}
                <input class="form-control form-inline pull-right" name="search" placeholder="Search">
                {!! Form::close() !!}
            </div>
            <h1 class="pull-left">Customers: Edit</h1>
            <a class="btn btn-primary pull-right raw-margin-top-24 raw-margin-right-8" href="{!! route('customers.create') !!}">Add New</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($customer, ['route' => ['customers.update', $customer->id], 'method' => 'patch']) !!}

            @form_maker_object($customer, FormMaker::getTableColumns('customers'))

            {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}

            {!! Form::close() !!}

        </div>
    </div>

@stop
