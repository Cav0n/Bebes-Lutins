<div id='search-container'>
    <h2 id='result-title' class='h4'>Résultats</h2>
    <table class="table">
        <thead>
            <tr class='d-flex'>
                <th class='border-top-0 col-2 d-none d-md-table-cell text-center'>Date</th>
                <th class='border-top-0 col-4'>Client</th>
                <th class='border-top-0 col-4 col-md-2 text-center'>Prix</th>
                <th class='border-top-0 col-4 text-center'>Statut</th>
            </tr>
        </thead>
        <tbody id='search-table-body'>

        </tbody>
    </table>

    <h2 class='h4'>Autre résultats</h2>
    <table class="table">
        <thead>
            <tr class='d-flex'>
                <th class='border-top-0 col-2 d-none d-md-table-cell text-center'>Date</th>
                <th class='border-top-0 col-4'>Client</th>
                <th class='border-top-0 col-4 col-md-2 text-center'>Prix</th>
                <th class='border-top-0 col-4 text-center'>Statut</th>
            </tr>
        </thead>
        <tbody id='search-possible-table-body'>

        </tbody>
    </table>
</div>
{{-- PREPARE AJAX --}}
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

{{-- SEARCH PRODUCT AJAX --}}
<script>

$("#orders-container").show();
$("#search-container").hide();

$("#search-bar").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#search-button").click();
    }
});
            
function search(){
    search_words = $("#search-bar").val();
    button = $("#search-button");

    if(search_words != ""){
        $.ajax({
            url : '/dashboard/commandes/recherche', // on appelle le script JSON
            type: "POST",
            dataType : 'json', // on spécifie bien que le type de données est en JSON
            data : {
                search: search_words
            },
            beforeSend: function(){
                button.addClass('running');
            },
            success : function(data){
                $("#orders-container").hide();
                $("#search-container").show();
                $("#search-table-body").empty();
                $("#search-possible-table-body").empty();

                $.each(data.valid_orders, function(index, order){
                    order_html = `
                    <tr class='d-flex' style='color:!color'>
                        <td class='col-2 small text-center mb-0' scope="row" onclick='load_in_new_tab("/dashboard/commandes/fiche/`+order.id+`")'>`+order.created_at+`</td>
                        
                        <td class='col-4' onclick='load_in_new_tab("/dashboard/commandes/fiche/`+order.id+`")'>
                            <p class='font-weight-bold mb-0'>`+order.user.firstname+` `+order.user.lastname+`</p>
                        </td>
                        
                        <td class='col-2 text-center' onclick='load_in_new_tab("/dashboard/commandes/fiche/`+order.id+`")'>
                            <p class='mb-0'>`+order.productsPrice+` €</p> 
                            !shipping_price
                        </td>

                        <td class='col-4'>
                            <div class="form-group mb-0 ld-over">
                                <select class='custom-select status-selector'>
                                    <option value='0' !selected_0 >En attente de paiement</option>
                                    <option value='1' !selected_1 >En cours de traitement</option>
                                    <option value='2' !selected_2 >En cours de livraison</option>

                                    <option value="22" !selected_22 >A retirer à l'atelier</option>
                                    <option value="33" !selected_33 >Participation enregistrée</option>
                                    <option value="3" !selected_3 >Livrée</option>
                                    <option value="-1" !selected_-1 >Annulée</option>

                                    <option value='-3' !selected_-3 >Paiement refusé</option>
                                </select>
                                <div class="ld ld-ring ld-spin"></div>
                            </div>
                        </td>
                    </tr>
                    `;

                    if(order.shippingPrice != 0) order_html = order_html.replace("!shipping_price", "<p class='small mb-0'>(+"+ order.shippingPrice +"€)</p>");
                    else order_html = order_html.replace("!shipping_price", "");

                    order_html = order_html.replace("!selected_" + order.status, " selected ");
                    order_html = order_html.replace(/[!]selected_[-]?\d+?/g, "");
                    order_html = order_html.replace('!color', order.color);

                    $('#result-title').text("Résultats ("+data.valid_results_nb+" commandes)");

                    $("#search-table-body").append(order_html);
                });

                $.each(data.possible_orders, function(index, order){
                    order_html = `
                    <tr class='d-flex' style='color:!color'>
                        <td class='col-2 small text-center mb-0' scope="row" onclick='load_in_new_tab("/dashboard/commandes/fiche/`+order.id+`")'>`+order.created_at+`</td>
                        
                        <td class='col-4' onclick='load_in_new_tab("/dashboard/commandes/fiche/`+order.id+`")'>
                            <p class='font-weight-bold mb-0'>`+order.user.firstname+` `+order.user.lastname+`</p>
                        </td>
                        
                        <td class='col-2 text-center' onclick='load_in_new_tab("/dashboard/commandes/fiche/`+order.id+`")'>
                            <p class='mb-0'>`+order.productsPrice+` €</p> 
                            !shipping_price
                        </td>

                        <td class='col-4'>
                            <div class="form-group mb-0 ld-over">
                                <select class='custom-select status-selector'>
                                    <option value='0' !selected_0 >En attente de paiement</option>
                                    <option value='1' !selected_1 >En cours de traitement</option>
                                    <option value='2' !selected_2 >En cours de livraison</option>

                                    <option value="22" !selected_22 >A retirer à l'atelier</option>
                                    <option value="33" !selected_33 >Participation enregistrée</option>
                                    <option value="3" !selected_3 >Livrée</option>
                                    <option value="-1" !selected_-1 >Annulée</option>

                                    <option value='-3' !selected_-3 >Paiement refusé</option>
                                </select>
                                <div class="ld ld-ring ld-spin"></div>
                            </div>
                        </td>
                    </tr>
                    `;

                    if(order.shippingPrice != 0) order_html = order_html.replace("!shipping_price", "<p class='small mb-0'>(+"+ order.shippingPrice +"€)</p>");
                    else order_html = order_html.replace("!shipping_price", "");

                    order_html = order_html.replace("!selected_" + order.status, " selected ");
                    order_html = order_html.replace(/[!]selected_[-]?\d+/g, "");
                    order_html = order_html.replace('!color', order.color);

                    $("#search-possible-table-body").append(order_html);
                });

                button.removeClass('running');
            }
        });
    } else {
        $("#orders-container").show();
        $("#search-container").hide();
    }
}
</script>