<div class='ratings mt-3'>
    @if(!empty($errors->any()))
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
        <p class="mb-0">{{ ucfirst($error) }}</p>
        @endforeach
    </div>
    @endif

    @if(session()->has('ratingSuccessMessage'))
    <div class="alert alert-success" role="alert">
        <p class="mb-0">{{ session()->get('ratingSuccessMessage') }}</p>
    </div>
    @endif

    @auth
        @if(!\App\Review::where('product_id', $product->id)->where('user_id', Auth::user()->id)->exists())
        <form id='new-rating' class="bg-white p-3 shadow-sm w-100" method="POST" action="{{ route('product.reviews.add', ['product' => $product]) }}">
            @csrf
            <h2 class="h4">Apposez un commentaire</h2>

            <label class="mb-0" for="rating">Note</label>
            <div class="rating mb-2"></div>
            <input id="mark" type="hidden" name="mark" value="{{ old('mark', 5) }}">

            <div class="form-group">
                <label for="title">Titre du commentaire</label>
                <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" id="title" aria-describedby="helpTitle" value="{{ old('title') }}">
                {!! $errors->has('title') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('title')) . "</div>" : '' !!}
                <small id="helpTitle" class="form-text text-muted">Le titre de votre commentaire</small>
            </div>
            <div class="form-group">
                <label for="text">Votre commentaire</label>
                <textarea class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}" name="text" id="text" aria-describedby="helpText" rows="5">{{ old('text') }}</textarea>
                {!! $errors->has('text') ? "<div class='invalid-feedback'>" . ucfirst($errors->first('text')) . "</div>" : '' !!}
                <small id="helpText" class="form-text text-muted">Le texte de votre commentaire</small>
            </div>
            <button type="submit" class="btn btn-outline-dark">Envoyer</button>
        </form>
        @endif
    @endauth

    @guest
    <div class="bg-white shadow-sm p-3 text-center">
        <p class='m-0'>Vous devez être <a href='{{ route('login') }}'>connecté</a> pour poster un commentaire.</p>
    </div>
    @endguest

    @foreach($product->reviews as $review)
    <div class="review bg-white p-3 shadow-sm w-100 mt-2">
        <p class="mb-0"><b>{{ $review->title }}</b></p>
        <div class="mark-container d-flex">
            <span class="fixed-rating" data-mark='{{ $review->mark }}'></span>
            <p class="mb-0 ml-2">{{ $review->mark }} / 5</p>
        </div>
        <p class="mb-0">{{ $review->text }}</p>
        <small>Posté le {{ $review->created_at->format('d/m/Y') }}</small>
    </div>
    @endforeach
</div>

<script>
    var options = {
        max_value: 5,
        step_size: 0.5,
        initial_value: $('#mark').val(),
        selected_symbol_type: 'utf8_star', // Must be a key from symbols
        cursor: 'default',
        readonly: false
    }

    $(".rating").rate(options);

    $(".rating").on("change", function(ev, data){
        $('#mark').val(data.to);
    });
</script>
