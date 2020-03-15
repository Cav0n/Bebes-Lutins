{{-- Customer identity --}}
<p class="mb-0">{{ $address->identity }}</p>

{{-- Company --}}
@if ($address->company)
<p class="mb-0">{{ $address->company }}</p>
@endif

{{-- Street --}}
<p class="mb-0">
    {{ $address->street }}
    @if($address->complements)
    , {{ $address->complements }}
    @endif
</p>

{{-- City --}}
<p class="mb-0">{{ $address->zipCode }}, {{ mb_strtoupper($address->city) }}</p>
