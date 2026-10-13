@extends('layouts.app')
@section('title')
    {{ __('messages.email_template.email_template') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ url()->previous() }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="container-fluid">

    <div id="emailTemplateErrorsBox"></div>

    <form action="{{ route('email-template.update', $template->id) }}"
          method="POST"
          id="editEmailTemplateForm">
        @csrf
        @method('PUT')

        @include('email-template.field')
    </form>
</div>
@endsection