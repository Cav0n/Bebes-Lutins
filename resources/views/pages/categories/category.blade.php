@extends('templates.template')

@section('content')

<main id='category-main' class='container-fluid my-4' style='min-height:90vh;'>
    <div class="row">
        <div class="col-12">
            <h1 class='w-75'>{{$category->name}}</h1>
        </div>
        <div class="col-12">
            <p class='w-50'>{{$category->description}}</p>
        </div>
    </div>
    
    <div class='row'>
        @foreach (App\Category::where('parent_id', $category->id)->get() as $child)
        <div class="card m-2" style="width:12rem;cursor:pointer">
            <img src="{{asset('images/utils/question-mark.png')}}" class="card-img-top" alt="catégorie">
            <div class="card-body p-3">
                <p class="card-text">{{$child->name}}</p>
            </div>
        </div>
        @endforeach
    </div>

    
</main>

@endsection