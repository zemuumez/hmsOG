@extends('front_settings.index')
@section('title')
    {{ __('messages.front_settings') }}
@endsection
@section('section')
    <div class="card">
        <div class="card-header pb-0">
            <div class="card-title m-0">
                <h3>{{ __('messages.map.title') }}</h3>
            </div>
        </div>
        <div class="card-body pt-3">
            {{ Form::open(['route' => ['front.settings.update'], 'method' => 'post', 'id' => 'addLocationMap']) }}
            {{ Form::hidden('sectionName', $sectionName) }}
            <div class="alert alert-danger d-none hide" id="mapErrorsBox"></div>

            <div class="row">
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('location_map', __('messages.map.label')) }}
                    <span class="required"></span>

                    {{ Form::textarea('location_map', $frontSettings['location_map'] ?? null, ['class' => 'form-control', 'id' => 'locationIframe', 'rows' => 5, 'placeholder' => __('messages.map.placeholder'), 'required']) }}
                    <div class="mt-4">
                        <strong>{{ __('messages.map.how_to_add') }}</strong>
                        <ol class="mb-0 mt-2">
                            <li>{{ __('messages.map.step_1') }} <a href="https://www.google.com/maps"
                                    target="_blank">{{ __('messages.map.google_map') }}</a></li>
                            <li>{{ __('messages.map.step_2') }}</li>
                            <li>{{ __('messages.map.step_3') }} <strong>{{ __('messages.map.share') }}</strong></li>
                            <li>{{ __('messages.map.step_4') }} <strong>{{ __('messages.map.embed') }}</strong></li>
                            <li>{{ __('messages.map.step_5') }}<strong>{{ __('messages.map.copy') }}</strong></li>
                            <li>{{ __('messages.map.step_6') }}</li>
                        </ol>
                    </div>
                </div>
                <!-- Submit -->
                <div class="form-group col-sm-12 mb-5 d-flex justify-content-end">
                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                    {{ Form::reset(__('messages.common.cancel'), ['class' => 'btn btn-secondary']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
