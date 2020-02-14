<div class="row mx-0">
    <div class="border-right px-3 d-flex flex-column" style="width: 18rem;">
        @foreach ($categories as $category)
            <a class="mb-0" href='{{route('category', ['category' => $category->id])}}'>{{$category->name}}</a>
        @endforeach
    </div>
    <div class="col">
        @foreach ($categories as $category)
            <h1 id='h1-{{$category->id}}' @if($category->id !== $categories->first()->id) style='display:none' @endif>
                {{$category->name}}</h1>
        @endforeach
    </div>
</div>
