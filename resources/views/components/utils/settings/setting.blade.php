<div class="row mb-3">
    <div class="col-12 col-md-4 col-lg-3">
        <label class="mt-2" for="{{ $setting->key }}">{{ $setting->i18n ? $setting->i18n->title : $setting->key }}</label>
    </div>
    <div class="col-12 col-md-8 col-lg-9">
        {!! $setting->input !!}
        {!! $setting->helpInput !!}
    </div>
</div>
