<div class="row mx-0">
    <div class="border-right px-3 d-flex flex-column" style="width: 18rem;">
        @foreach ($categories as $category)
            @if (null == $category->parentId && !$category->isHidden)
                <a class="mb-0 category-selector btn btn-outline-primary mt-2" href='#' id="{{ $category->id }}">{{ $category->name }}</a>
            @endif
        @endforeach
    </div>
    <div class="col">
        @foreach ($categories as $category)
            <div id='cc-{{ $category->id }}' class="category-container">
                <a id='h1-{{$category->id}}' class="h1" href="{{ route('category', ['category' => $category->id]) }}">
                    {{$category->name}}</a>

                <div class="sub-categories row m-0">
                    @foreach ($category->childs()->where('isDeleted', 0)->where('isHidden', 0)->get() as $child)
                    <div class="col-xl-3">
                        <div class="card sub-category">
                            <img src="{{ asset($child->images()->exists() ? $child->images()->first()->url : null) }}" alt="" class="card-img-top">
                            <div class="card-body">
                                <a href="{{ route('category', ['category' => $child->id]) }}" class="card-text">{{$child->name}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
        categoryContainer = $('.category-container');
        categorySelector = $('.category-selector');

        $(document).ready(function(){
            categoryContainer.hide();
            categoryContainer.first().show();
            categorySelector.first().addClass('active');

            $('.category-selector').click(function(){
                categoryContainer.hide();
                categorySelector.removeClass('active');
                $(this).addClass('active');

                $('#cc-' + this.id).show();
            });
        });

</script>
