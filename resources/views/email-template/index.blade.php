@extends('layouts.app')
@section('title')
    {{ __('messages.email_template.email_template') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <livewire:EmailTemplateTable />
        </div>
    </div>
@endsection
