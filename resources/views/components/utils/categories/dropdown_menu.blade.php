<div class="row mx-0">
    <div class="border-right px-3 d-flex flex-column" style="width: 18rem;">
        @foreach ($categories as $category)
            <a class="mb-0" href='{{route('category', ['category' => $category->id])}}'>{{$category->name}}</a>
        @endforeach
    </div>
    <div class="col">
        <h1>{{$categories->first()->name}}</h1>
    </div>
</div>
