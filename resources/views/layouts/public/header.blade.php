<header class='sticky-top p-0 container-fluid'>
    <img id='logo' src="{{asset('images/logo.png')}}" class='fixed-top zindex-tooltip transition-fast' alt="Logo Bébés Lutins" style='height:12rem;'>
    <nav id='top-navbar' class="navbar navbar-expand-lg navbar-dark bg-white sticky-top p-0">
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mt-2 mt-lg-0 w-100">
                <li class="nav-item px-2 transition" style='cursor:pointer;width:18rem;'>
                    <a class="h4 nav-link text-dark text-center mb-0 pb-1 font-weight-bold" href="/contact">Contactez-nous</a>
                    <div class='row justify-content-center mt-1'>
                        <img src="{{asset('images/icons/call-bw.svg')}}" class='mx-2' alt="Téléphone" style='width:1.6rem;'>
                        <img src="{{asset('images/icons/email-bw.svg')}}" class='mx-2' alt="E-mail" style='width:1.6rem;'>
                        <img src="{{asset('images/icons/map-bw.svg')}}" class='mx-2' alt="Adresse" style='width:1.6rem;'>
                    </div>
                </li>

                <li class="nav-item ml-auto px-3 transition" style='cursor:pointer;width:12rem;'>
                    <a class="h4 nav-link text-dark text-center mb-0 pb-1 font-weight-bold" href="/espace-client">Mon compte</a>
                    <a class="nav-link text-dark text-center py-0" href="/espace-client/connexion">Se connecter</a>
                    <a class="nav-link text-dark text-center py-0" href="/espace-client/enregistrement">Créer mon compte</a>
                </li>
                <li class="nav-item px-4 transition" style="cursor:pointer;width:12rem">
                    <a class="h4 nav-link text-dark text-center mb-0 pb-1 font-weight-bold" href="/panier">Mon panier</a>
                    <p class='text-center py-0 my-0'>0,00€</p>
                    <p class='text-center py-0 my-0'>0 articles</p>
                </li>
            </ul>
        </div>
    </nav>
    <nav id='bottom-navbar' class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-top border-bottom p-0">
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mt-2 mt-lg-0 w-100">
                <li class="nav-item hover-green p-2 transition-fast border-right" style='width:8rem;'>
                    <a class="nav-link text-dark text-center py-0" href="/">Accueil</a>
                </li>
                <li class="nav-item hover-green p-2 transition-fast" style='width:10rem;'>
                    <a class="nav-link dropdown-toggle text-dark p-0 text-center" href="#" id="dropdown-open" aria-haspopup="true" aria-expanded="false">Nos produits</a>
                    
                    <div class="bg-white p-3 dropdown-menu w-100">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                                    <li class="nav-item ">
                                        <a class="nav-link active" id="category1-tab" data-toggle="tab" href="#category1" role="tab" aria-controls="category1" aria-selected="true">Catégorie 1</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" id="category2-tab" data-toggle="tab" href="#category2" role="tab" aria-controls="category2" aria-selected="false">Catégorie 2</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" id="category3-tab" data-toggle="tab" href="#category3" role="tab" aria-controls="category3" aria-selected="false">Catégorie 3</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-10">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="category1" role="tabpanel" aria-labelledby="category1-tab">
                                        <h2>Catégorie 1</h2>
                                        <div class="card" style="width: 11rem;">
                                            <img src="{{asset('images/utils/question-mark.png')}}" class="card-img-top" alt="catégorie">
                                            <div class="card-body p-3">
                                                <p class="card-text">Une belle catégorie</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="category2" role="tabpanel" aria-labelledby="category2-tab">
                                        <h2>Catégorie 2</h2>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                    </div>
                                    <div class="tab-pane fade" id="category3" role="tabpanel" aria-labelledby="category3-tab">
                                        <h2>Catégorie 3</h2>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- /.col-md-8 -->
                    </div>

                </li>

                <li class="nav-item hover-green ml-auto p-2 border-right transition-fast" style='width:12rem;'>
                    <a class="nav-link text-dark text-center py-0" href="/qui-sommes-nous">Qui sommes-nous ?</a>
                </li>
                <li class="nav-item hover-green p-2 transition-fast" style='width:12rem'>
                    <a class="nav-link text-dark text-center py-0" href="/guide-et-conseils">Guide et conseils</a>
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
</header>