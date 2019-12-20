<ul id='nav-delivery' class="nav nav-tabs card-header-tabs justify-content-center">
    @if($has_addresses)
    <li class="nav-item mx-2">
        <a class="delivery-tab nav-link mb-0 noselect 
        @if(session('delivery-type') == 'saved-addresses' || ($has_addresses && session('delivery-type') == null) ) active @endif" onclick='select_nav_item($(this), $(".savedAddresses"))'>
            Vos adresses</a>
    </li>
    @endif
    <li class="nav-item mx-2">
        <a class="delivery-tab nav-link mb-0 noselect 
        @if(session('delivery-type') == 'new-address' || (!$has_addresses && session('delivery-type') == null) ) active @endif" onclick='select_nav_item($(this), $(".newAddress"))'>
            Nouvelle adresse</a>
    </li>
    <li class="nav-item mx-2">
        <a class="delivery-tab nav-link mb-0 noselect @if(session('delivery-type') == 'withdrawal-shop') active @endif " onclick='select_nav_item($(this), $(".withdrawalShop"))'>
            Retrait à l'atelier</a>
    </li>
</ul>

{{-- prepare page --}}
<script>
    base_shipping_price = {{$shoppingCart->shippingPrice}};

    $(document).ready(function(){
        total_price = $('#total-price-save').val();
        var options1 = { style: 'currency', currency: 'EUR' };
        var numberFormat1 = new Intl.NumberFormat('fr-FR', options1);
        selected_delivery_type = $('.delivery-tab.active').text().trim();

        switch(selected_delivery_type){
            case 'Vos adresses':
                $('#submit-button').attr('form', 'saved-addresses-form');
                $('#shipping-price').text(base_shipping_price + ' €');
                $('#total-price').text(base_shipping_price + ' €');
                $('#total-price').text(numberFormat1.format(total_price));

                break;
            case 'Nouvelle adresse':
                $('#submit-button').attr('form', 'new-address-form');
                $('#shipping-price').text(base_shipping_price + ' €');
                $('#total-price').text(numberFormat1.format(total_price));

                break;
            case "Retrait à l'atelier":
                $('#submit-button').attr('form', 'withdrawal-shop-form');
                $('#shipping-price').text(base_shipping_price + ' €')
                $('#total-price').text(numberFormat1.format(total_price - base_shipping_price));
                break;
        }
    });
</script>

{{-- Tabs selection changed --}}
<script>
    function select_nav_item(item, contentToShow){
        $('#nav-delivery').children('li').children('a').removeClass('active');
        item.addClass('active');
        $('.delivery-choice').addClass('d-none');
        contentToShow.removeClass('d-none');
        total_price = $('#total-price-save').val();
        var options1 = { style: 'currency', currency: 'EUR' };
        var numberFormat1 = new Intl.NumberFormat('fr-FR', options1);

        delivery_type = item.text().trim();
        switch(delivery_type){
            case 'Vos adresses':
                $('#submit-button').attr('form', 'saved-addresses-form');
                $('#shipping-price').text(base_shipping_price + ' €');
                $('#total-price').text(base_shipping_price + ' €');
                $('#total-price').text(numberFormat1.format(total_price));

                break;
            case 'Nouvelle adresse':
                $('#submit-button').attr('form', 'new-address-form');
                $('#shipping-price').text(base_shipping_price + ' €');
                $('#total-price').text(numberFormat1.format(total_price));

                break;
            case "Retrait à l'atelier":
                $('#submit-button').attr('form', 'withdrawal-shop-form');
                $('#shipping-price').text('0.00 €')
                $('#total-price').text(numberFormat1.format(total_price - base_shipping_price));
                break;
        }
        
    }
</script>