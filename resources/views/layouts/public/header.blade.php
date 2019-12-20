<?php 
$shopping_cart = session('shopping_cart');
$total_quantity = 0;

if(count($shopping_cart->items) > 0){
    foreach ($shopping_cart->items as $item) {
        $total_quantity += $item->quantity;
    }
}

$parent_categories = App\Category::where('parent_id', null)->where('isDeleted', 0)->where('isHidden', 0)->orderBy('rank', 'asc')->get();

?>


<header class='sticky-top p-0 container-fluid border-bottom'>
    <img id='logo' src="{{asset('images/logo.png')}}" class='fixed-top zindex-tooltip transition-fast d-none d-lg-flex' alt="Logo Bébés Lutins" style='height:12rem;' onclick='load_url("/")'>
    <nav id='top-navbar' class="navbar navbar-expand-lg navbar-dark bg-white sticky-top p-0">
        <a class="navbar-brand text-secondary font-weight-bold ml-3 mr-0 d-flex d-lg-none" href="/" style='font-size:2rem;font-weight:900 !important;'>Bébés Lutins</a>
        <button class="navbar-toggler d-lg-none m-3 bg-secondary" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="0" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class='collapse navbar-collapse' id="collapsibleNavId">
            <ul class="navbar-nav mt-2 mt-lg-0 w-100 d-none d-lg-flex">
                <li class="nav-item desktop transition" style='cursor:pointer;width:18rem;' onclick='load_url("/contact")'>
                    <a class="h5 nav-link text-dark text-center mb-0 pb-1 font-weight-bold" href="/contact">CONTACTEZ-NOUS</a>
                    <div class='row justify-content-center mt-1'>
                        <img src="{{asset('images/icons/call-bw.svg')}}" class='mx-2' alt="Téléphone" style='width:1.6rem;height:1.6rem;'>
                        <img src="{{asset('images/icons/email-bw.svg')}}" class='mx-2' alt="E-mail" style='width:1.6rem;height:1.6rem;'>
                        <img src="{{asset('images/icons/map-bw.svg')}}" class='mx-2' alt="Adresse" style='width:1.6rem;height:1.6rem;'>
                    </div>
                </li>

                <li class="nav-item desktop ml-auto transition" style='cursor:pointer;width:12rem;'>
                    @guest
                        <a class="h5 nav-link text-dark text-center mb-0 pb-1 font-weight-bold" href="/espace-client">MON COMPTE</a>
                        <a class="nav-link text-dark text-center py-0" href="/espace-client/connexion">Se connecter</a>
                        <a class="nav-link text-dark text-center py-0" href="/espace-client/enregistrement">Créer mon compte</a>
                    @else
                        <a class="h5 nav-link text-dark text-center mb-0 pb-1 font-weight-bold" href="/espace-client">{{ Auth::user()->firstname }} {{ substr(Auth::user()->lastname, 0, 1) . "." }}</a>
                        <a class="nav-link text-dark text-center py-0" href="/espace-client/connexion">Mon compte</a>
                        <form method="POST" action="/logout">@csrf<button type='submit' class="nav-link text-dark text-center py-0 mx-auto btn btn-link" href="/espace-client/enregistrement">Se déconnecter</button></form>
                    @endguest
                    
                </li>
                <li class="nav-item desktop transition" style="cursor:pointer;width:12rem" onclick='load_url("/panier")'>
                    <a class="h5 nav-link text-dark text-center mb-0 pb-1 font-weight-bold" href="/panier">MON PANIER</a>
                    <p id='shopping_cart_price' class='text-center py-0 my-0'>{{number_format($shopping_cart->productsPrice, 2)}} €</p>
                    <p class='text-center py-0 my-0'>{{$total_quantity}} articles</p>
                </li>
            </ul>
            
            <ul class="navbar-nav mt-2 px-3 mt-lg-0 d-flex d-lg-none">
                <li class="nav-item transition">
                    <a class="nav-link text-dark" href="/espace-client">
                        @auth
                        Mon compte
                        @endauth 
                        @guest
                        Se connecter
                        @endguest</a>
                </li>
                <li class="nav-item transition">
                    <a class="nav-link text-dark" href="/panier">Mon panier</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="0">Nos produits</a>
                    <div class="dropdown-menu">
                        @if($parent_categories != null)
                        @foreach ($parent_categories as $category)
                            <a class="dropdown-item text-dark px-1 py-2" href="/categories/{{$category->id}}">{{$category->name}}</a>
                        @endforeach
                        @endif
                    </div>
                </li>
                <li class="nav-item transition">
                    <a class="nav-link text-dark" href="/en-savoir-plus/guide-et-conseils">Guides et conseils</a>
                </li>
                <li class="nav-item transition">
                    <a class="nav-link text-dark" href="/en-savoir-plus/qui-sommes-nous">Qui sommes nous ?</a>
                </li>

                @auth
                <div class="dropdown-divider"></div>
                <li class="nav-item transition mb-2">
                    <button type="button" class="btn btn-dark ld-ext-right" onclick='logout($(this))'>
                        Se déconnecter
                        <div class='ld ld-hourglass ld-spin-fast'></div>
                    </button>
                </li> 
                @endauth
            </ul>
        </div>
    </nav>
    <nav id='bottom-navbar' class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-top border-bottom p-0 d-none d-lg-flex">
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mt-2 mt-lg-0 w-100">
                <li class="nav-item hover-green p-2 transition-fast border-right" style='width:8rem;'>
                    <a class="nav-link text-dark text-center py-0" href="/">Accueil</a>
                </li>
                @if(App\Category::where('parent_id', null)->where('isDeleted', 0)->where('isHidden', 0)->orderBy('rank', 'asc')->where('isHidden', 0)->exists())
                <?php 
                
                $parent_categories = App\Category::where('parent_id', null)->where('isDeleted', 0)->where('isHidden', 0)->orderBy('rank', 'asc')->get();
                
                ?>
                <li class="nav-item hover-green p-2 transition-fast" style='width:10rem;'>
                    <a class="nav-link dropdown-toggle text-dark p-0 text-center" href="#" id="dropdown-open" aria-haspopup="true" aria-expanded="0">Nos produits</a>
                    
                    <div id="categories-dropdown" class="bg-white dropdown-menu w-100" style='box-shadow: 0 2px 8px -1px rgb(100,100,100);'>
                        <div class="row m-0">
                            <div class="col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab" role="tablist">

                                    <?php $index = 0; ?>
                                    @foreach ($parent_categories as $category)
                                        <li class="nav-item ">
                                            <a class="nav-link rounded-0 @if($index == 0) {{'active'}} @endif" id="{{$category->id}}-tab" data-toggle="tab" href="#{{$category->id}}" role="tab" aria-controls="{{$category->id}}" aria-selected="true">{{$category->name}}</a>
                                        </li>
                                        <?php $index ++;?>
                                    @endforeach
                                    
                                </ul>
                            </div>
                            <div class="col-md-10 mt-2">
                                <div class="tab-content" id="myTabContent">

                                    <?php $index = 0; ?>
                                    @foreach ($parent_categories as $parent)
                                        <div class="tab-pane fade @if($index == 0) {{'show active'}} @endif" id="{{$parent->id}}" role="tabpanel" aria-labelledby="{{$parent->id}}-tab">
                                            <a href='/categories/{{$parent->id}}' class='text-dark h2'>{{$parent->name}}</a>
                                            <div class='row'>
                                                @foreach (App\Category::where('parent_id', $parent->id)->where('isHidden', 0)->where('isDeleted', 0)->orderBy('rank', 'asc')->get() as $category)
                                                <div class="card m-2" style="width:12rem;cursor:pointer" onclick='load_url("/categories/{{$category->id}}")'>
                                                    <img src="{{asset('images/categories/'. $category->mainImage)}}" class="card-img-top" alt="catégorie">
                                                    <div class="card-body p-3">
                                                        <a class="card-text text-dark" href='/categories/{{$category->id}}'>{{$category->name}}</a>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <?php $index++; ?>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    <!-- /.col-md-8 -->
                    </div>

                </li>
                @endif

                <li class="nav-item hover-green ml-auto p-2 border-right transition-fast" style='width:12rem;'>
                    <a class="nav-link text-dark text-center py-0" href="/en-savoir-plus/qui-sommes-nous">Qui sommes-nous ?</a>
                </li>
                <li class="nav-item hover-green p-2 transition-fast" style='width:12rem'>
                    <a class="nav-link text-dark text-center py-0" href="/en-savoir-plus/guide-et-conseils">Guide et conseils</a>
                </li>
            </ul>
        </div>
    </nav>

    <script>
    $('#dropdown-open').on('click', function (event) {
        $('.dropdown-menu').toggleClass('show')
    });

    $('body').on('click', function (e) {
        if (!$('.dropdown-menu').is(e.target) 
            && $('.dropdown-menu').has(e.target).length === 0 
            && $('#dropdown-open').has(e.target).length === 0
            && !$('#dropdown-open').is(e.target)
        ) {
            console.log (  )
            $('.dropdown-menu').removeClass('show');
        }
    });
    </script>
    
    <script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        
    function refresh_page(){
        location.reload();
    }

    function logout(btn)
    {
        $.ajax({
            url: "/logout",
            type: 'POST',
            success: function(data){
                refresh_page();
            },
            beforeSend: function() {
                btn.addClass('running');
            }
        })   
    }
    </script>
</header>