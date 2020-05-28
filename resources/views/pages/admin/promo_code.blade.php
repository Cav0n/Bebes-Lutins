@extends('templates.admin')

@section('content')

<div class="row justify-content-between mx-0">
    <a class="btn btn-dark mb-3" href="{{ route('admin.promoCodes') }}" role="button">
        < Code promos</a>
</div>

@if(session('successMessage'))
    <div class="alert alert-success" role="alert">
        {{ session('successMessage') }}
    </div>
@endif

@if(!empty($errors->any()))
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
        <p class="mb-0">{{ ucfirst($error) }}</p>
        @endforeach
    </div>
@endif

<div class="card rounded-0 border shadow-sm">
    <div class="card-header">
        <h2 class="h4 mb-0">{{ isset($promoCode) ? $promoCode->code : "Nouveau code promo" }}</h2>
    </div>
    <form class="card-body" action="{{ isset($promoCode) ? route('admin.promoCode.update', ['promoCode' => $promoCode]) : route('admin.promoCode.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="form-group col-8">
                <label for="code">Code</label>
                <input type="text" class="form-control" name="code" id="code" aria-describedby="helpCode" value="{{ old('code', isset($promoCode) ? $promoCode->code : null) }}">
                <small id="helpCode" class="form-text text-muted">Le code que devra taper le client.</small>
            </div>

            <div class="form-group col-4">
                <label for="discountValue">Remise</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="discountValue" id="discountValue" min="0.01" step="0.01" value="{{ old('discountValue', isset($promoCode) ? $promoCode->discountValue : null) }}">
                    <select class="custom-select" id="discountType" name="discountType">
                        @foreach (\App\PromoCode::DISCOUNT_TYPE as $type => $min)
                            <option value="{{ $type }}" @if(old('discountType', isset($promoCode) ? $promoCode->discountType : null) === $type) selected @endif>
                                {{ $min }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group col-3">
                <label for="maxUsage">Utilisation max par client</label>
                <input type="number" min="0" step="1" class="form-control" name="maxUsage" id="maxUsage" aria-describedby="helpMaxUsage" value="{{ old('maxUsage', isset($promoCode) ? $promoCode->maxUsage : null) }}">
                <small id="helpMaxUsage" class="form-text text-muted">Le nombre maximum d'utilisation par client.</small>
            </div>

            <div class="form-group col-3">
                <label for="minCartPrice">Prix minimum du panier</label>
                <div class="input-group">
                    <input type="number" min="0" step="0.01" class="form-control" name="minCartPrice" id="minCartPrice" aria-describedby="helpMinCartPrice" value="{{ old('minCartPrice', isset($promoCode) ? $promoCode->minCartPrice : null) }}">
                    <div class="input-group-append">
                        <span class="input-group-text" id="my-addon">€</span>
                    </div>
                </div>
                <small id="helpMinCartPrice" class="form-text text-muted">Un client pourra utiliser ce code uniquement si la valeur de son panier est égal ou dépasse ce montant.</small>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-4">
                <label for="minValidDate">Début de validité</label>
                <input type="datetime-local" class="form-control" name="minValidDate" id="minValidDate" aria-describedby="helpMinValidDate" value="{{ old('minValidDate', isset($promoCode) ? $promoCode->minValidDate->format('Y-m-d\TH:i') : null) }}">
                <small id="helpMinValidDate" class="form-text text-muted">Le code promo sera valide à partir de cette date.</small>
            </div>

            <div class="form-group col-4">
                <label for="maxValidDate">Fin de validité</label>
                <input type="datetime-local" class="form-control" name="maxValidDate" id="maxValidDate" aria-describedby="helpMaxValidDate" value="{{ old('maxValidDate', isset($promoCode) ? $promoCode->maxValidDate->format('Y-m-d\TH:i') : null) }}">
                <small id="helpMaxValidDate" class="form-text text-muted">Le code promo sera périmé à partir de cette date.</small>
            </div>
        </div>

        <div class="row m-0">
            <div class="form-check form-check-inline col-12">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="isActive" id="isActive" value="isActive" @if(old('isActive', isset($promoCode) && $promoCode->isActive)) checked="checked" @endif> Le code promo est actif ?
                </label>
            </div>
        </div>

        <div class="row m-0 mt-2">
            <button type="submit" class="btn btn-success">{{ isset($promoCode) ? 'Modifier' : 'Enregistrer' }}</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
    <script>
        $('#discountType').on('change', function () {
            if ("FREE_SHIPPING_COSTS" === $(this).val()) {
                $('#discountValue').attr('disabled', 'disabled');
                $('#discountValue').val('');
            } else {
                $('#discountValue').removeAttr('disabled');
            }
        });
    </script>
@endsection
