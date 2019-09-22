<img id='logo' src="{{asset('images/logo.png')}}" class='fixed-top zindex-tooltip transition-fast' alt="Logo Bébés Lutins" style='height:12rem;'>
<nav id='top-navbar' class="navbar navbar-expand-lg navbar-dark bg-white sticky-top p-0">
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mt-2 mt-lg-0 w-100">
            <li class="nav-item px-2 transition" style='cursor:pointer'>
                <a class="h4 nav-link text-dark text-center mb-0" href="/contact">Contactez-nous</a>
                <div class='row justify-content-center mt-1'>
                    <img src="{{asset('images/icons/call-bw.svg')}}" class='mx-2' alt="Téléphone" style='width:1.6rem;'>
                    <img src="{{asset('images/icons/email-bw.svg')}}" class='mx-2' alt="E-mail" style='width:1.6rem;'>
                    <img src="{{asset('images/icons/map-bw.svg')}}" class='mx-2' alt="Adresse" style='width:1.6rem;'>
                </div>
            </li>

            <li class="nav-item ml-auto px-3 transition" style='cursor:pointer;width:12rem;'>
                <a class="h4 nav-link text-dark text-center mb-0" href="/espace-client">Mon compte</a>
                <a class="nav-link text-dark text-center py-0" href="/espace-client/connexion">Se connecter</a>
                <a class="nav-link text-dark text-center py-0" href="/espace-client/enregistrement">Créer mon compte</a>
            </li>
            <li class="nav-item px-4 transition" style="cursor:pointer;width:12rem">
                <a class="h4 nav-link text-dark text-center mb-0" href="/panier">Mon panier</a>
                <p class='text-center py-0 my-0'>0,00€</p>
                <p class='text-center py-0 my-0'>0 articles</p>
            </li>
        </ul>
    </div>
</nav>
<nav id='bottom-navbar' class="navbar navbar-expand-lg navbar-dark bg-white sticky-top border-top border-bottom p-0">
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mt-2 mt-lg-0 w-100">
            
            <li class="nav-item p-2 transition-fast">
                <a class="nav-link text-dark text-center py-0" href="/">Accueil</a>
            </li>
            <li class="nav-item dropdown p-2 transition-fast">
                <a class="nav-link dropdown-toggle text-dark p-0" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Nos produits</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="#">Catégorie 1</a>
                    <a class="dropdown-item" href="#">Catégorie 2</a>
                </div>
            </li>

            <li class="nav-item ml-auto p-2 border-right transition-fast" style='width:12rem;'>
                <a class="nav-link text-dark text-center py-0" href="/qui-sommes-nous">Qui sommes-nous ?</a>
            </li>
            <li class="nav-item p-2 transition-fast" style='width:12rem'>
                <a class="nav-link text-dark text-center py-0" href="/guide-et-conseils">Guide et conseils</a>
            </li>
        </ul>
    </div>
</nav>

{{-- OLD HEADER --}}

{{-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <a class="navbar-brand" href="/">Bébés Lutins</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mt-2 mt-lg-0 ml-auto mr-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon compte</a>
                    @if (Auth::check())
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="/home">Mon espace client</a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="dropdown-item" type="submit">Déconnexion</a>
                        </form>
                    </div>
                    @else
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="/login">Se connecter</a>
                        <a class="dropdown-item" href="/register">Créer mon compte</a>
                    </div>
                    @endif
                    
                </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Qui sommes nous ?</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="#">Action 1</a>
                    <a class="dropdown-item" href="#">Action 2</a>
                    <a class="dropdown-item" href="#">Action 3</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/contact">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Actualités</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Presse</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="#">Action 1</a>
                    <a class="dropdown-item" href="#">Action 2</a>
                </div>
            </li>
        </ul>
    </div>
</nav> --}}