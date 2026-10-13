<form class="contact-form" method="POST" id="enquiryCreateForm">
    @csrf
    @method('POST')
    {{-- @include('flash::message') --}}
    <div class="ajax-message"></div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <div class="contact-form__input-block">
                <input name="full_name" id="full_name" type="text" class="form-control"
                    data-error="Please enter your name"
                    placeholder="{{ __('messages.web_contact.enter_your_name') }}">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="contact-form__input-block">
                <input name="email" id="email" type="email" class="form-control"
                    placeholder="{{ __('messages.web_contact.enter_your_email') }}"
                    data-error="{{ __('messages.web_contact.enter_your_email') }}">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="contact-form__input-block">
                {{ Form::tel('contact_no',null, ['class' => 'form-control phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                {{ Form::hidden('prefix_code', null, ['class' => 'prefix_code']) }}
                <span class="text-success valid-msg d-none fw-400 fs-small mt-2">✓ &nbsp;
                    {{ __('messages.valid') }}</span>
                <span class="text-danger error-msg d-none fw-400 fs-small mt-2"></span>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="contact-form__input-block">
                {{--                                            {{ Form::select('type', \App\Models\Enquiry::ENQUIRY_ARR, null, ['class' => 'general', 'id' => 'general']) }} --}}
                <select name="type" class="contactUsGeneral" id="contactUsGeneral">
                    {{--                                                <option value="">{{ __('messages.web_home.select_doctor') }}</option> --}}
                    <option value="1">{{ \App\Models\Enquiry::TYPE_GENERAL }}</option>
                    <option value="2">{{ \App\Models\Enquiry::TYPE_FEEDBACK }}</option>
                    <option value="3">{{ \App\Models\Enquiry::TYPE_RESIDENTIAL }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="contact-form__input-block">
                <textarea name="message" rows="4" class="form-control"
                    placeholder="{{ __('messages.web_contact.type_your_message') }}" required
                    data-error="{{ __('messages.web_contact.write_your_message') }}"></textarea>
                {{--                                            <div class="help-block with-errors"></div> --}}
            </div>
        </div>
        <input type="hidden" value="{{ config('app.recaptcha.sitekey') }}"
            id="adminRecaptcha">
        @if (config('app.recaptcha.sitekey'))
            <div class="form-group mb-1 captcha-customize">
                <div class="g-recaptcha" id="g-recaptcha"
                    data-sitekey="{{ config('app.recaptcha.sitekey') }}">
                </div>
            </div>
        @endif
        <div class="col-lg-12 text-center mt-3 mb-3">
            <button type="submit" id="btnContact"
                class="btn btn-primary">{{ __('messages.web_contact.send_message') }}
            </button>
            <div id="msgSubmit" class="h3 text-center hidden"></div>
            <div class="clearfix"></div>
            {{ Form::hidden('front_inquiry_url', route('send.enquiry'), ['class' => 'front-inquiry-url', 'id' => 'frontInquiryUrl']) }}
        </div>
    </div>
</form>