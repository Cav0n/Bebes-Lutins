<ul id='nav-delivery' class="nav nav-tabs card-header-tabs justify-content-center">
    @if($has_addresses)
    <li class="nav-item mx-2">
        <a class="nav-link mb-0 noselect 
        @if(session('delivery-type') == 'saved-addresses' || ($has_addresses && session('delivery-type') == null) ) active @endif" onclick='select_nav_item($(this), $(".savedAddresses"))'>
            Vos adresses</a>
    </li>
    @endif
    <li class="nav-item mx-2">
        <a class="nav-link mb-0 noselect 
        @if(session('delivery-type') == 'new-address' || (!$has_addresses && session('delivery-type') == null) ) active @endif" onclick='select_nav_item($(this), $(".newAddress"))'>
            Nouvelle adresse</a>
    </li>
    <li class="nav-item mx-2">
        <a class="nav-link mb-0 noselect @if(session('delivery-type') == 'withdrawal-shop') active @endif " onclick='select_nav_item($(this), $(".withdrawalShop"))'>
            Retrait à l'atelier</a>
    </li>
</ul>

{{-- Tabs selection changed --}}
<script>
    function select_nav_item(item, contentToShow){
        $('#nav-delivery').children('li').children('a').removeClass('active');
        item.addClass('active');
        $('.delivery-choice').addClass('d-none');
        contentToShow.removeClass('d-none');

        delivery_type = item.text().trim();
        switch(delivery_type){
            case 'Vos adresses':
                $('#submit-button').attr('form', 'saved-addresses-form');
                break;
            case 'Nouvelle adresse':
                $('#submit-button').attr('form', 'new-address-form');
                break;
            case "Retrait à l'atelier":
                $('#submit-button').attr('form', 'withdrawal-shop-form');
                break;
        }
        
    }
</script>