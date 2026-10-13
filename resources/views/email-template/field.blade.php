<div class="card">
    <div class="card-body">
        {{ Form::hidden('id', $template->id, ['id' => 'emailTemplateId']) }}

        <div class="row">
            <div class="col-md-6 mb-4">
                {{ Form::label('template_name', __('messages.email_template.template_name') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
                {{ Form::text('template_name', old('template_name', $template->template_name ?? ''), [
                    'class' => 'form-control',
                    'readonly' => true,
                ]) }}
            </div>

            <div class="col-md-6 mb-4">
                {{ Form::label('email_subject', __('messages.email_template.email_subject') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
                {{ Form::text('email_subject', old('email_subject', $template->email_subject ?? ''), [
                    'class' => 'form-control',
                    'required' => true,
                    'id' => 'emailSubject',
                ]) }}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-8 mb-5">
                {{ Form::label('email_content', __('messages.email_template.email_content') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>

                <div id="emailContentId" style="height: 200px;"></div>

                {{-- Hidden textarea to preserve HTML --}}
                {{ Form::textarea('email_content', old('email_content', $template->email_content ?? ''), [
                    'id' => 'emailData',
                    'class' => 'd-none',
                ]) }}

                {{-- For loading content in Quill --}}
                {{ Form::hidden('email_content_data', old('email_content', $template->email_content ?? ''), [
                    'class' => 'emailContentData',
                ]) }}
            </div>
            <div class="col-md-4 mb-4">
                {{ Form::label('dynamic_variables', __('messages.email_template.available_variable') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}

                <div class="border rounded p-3" id="variableBox">
                    <small class="text-muted d-block mb-2">
                        {{ __('messages.email_template.click_variable') . '.' }}
                    </small>

                    @foreach ($template->dynamic_variables ?? [] as $variable)
                        @php
                            $formattedVariable = '{{ ' . $variable . ' }}';
                        @endphp

                        <div class="border rounded px-2 py-1 mb-2 variable-item"
                            data-variable="{{ $formattedVariable }}" style="cursor: pointer;">
                            {{ $formattedVariable }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            {{ Form::submit(__('messages.common.save'), ['id' => 'editEmailTemplateSave', 'class' => getCurrentLoginUserLanguageName() == 'ar' ? 'btn btn-primary btn-save ms-3' : 'btn btn-primary btn-save me-3']) }}
            <a href="{!! route('email-template.index') !!}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
        </div>

    </div>
</div>
