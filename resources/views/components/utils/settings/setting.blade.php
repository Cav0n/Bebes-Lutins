<div class="row mb-3">
    <div class="col-12 col-md-4 col-lg-3">
        @if("checkbox" !== $setting->type)
        <label class="mt-2" for="{{ $setting->key }}">{{ $setting->i18n ? $setting->i18n->title : $setting->key }}</label>
        @endif
    </div>
    <div class="col-12 col-md-8 col-lg-9">
        {!! $setting->input !!}
        {!! $setting->helpInput !!}
    </div>
</div>
