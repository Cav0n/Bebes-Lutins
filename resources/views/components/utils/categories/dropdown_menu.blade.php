<div class="row mx-0">
    <div class="border-right px-3" style="width: 18rem;">
        @foreach ($categories as $category)
            <p class="mb-0">{{$category->name}}</p>
        @endforeach
    </div>
    <div class="col">
        <h1>Le titre de la catégorie</h1>
    </div>
</div>