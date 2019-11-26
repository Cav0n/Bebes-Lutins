@extends('templates.email')

@section('title', "Merci pour votre commande !")

@section('content')
<!-- big image section -->

<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color" style='border-bottom:1px solid gray'>

    <tr>
        <td align="center">
            <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                <tr>
                    <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                        class="main-header">
                        <!-- section text ======-->

                        <div style="line-height: 35px">

                            Réinitialisation de votre mot de passe

                        </div>
                    </td>
                </tr>

                <tr>
                    <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                </tr>

                <tr>
                    <td align="center">
                        <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                            <tr>
                                <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                </tr>

                <tr>
                    <td align="left">
                        <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                            <tr>
                                <td align="left" style="color: #888888; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;">
                                    <!-- section text ======-->

                                    <p style="line-height: 24px; margin-bottom:15px;">

                                            Bonjour <b>{{$user->firstname}} {{$user->lastname}}</b>, vous avez récemment
                                            demandé la réinitialisation de votre mot de passe.<BR>
                                            <BR>
                                            Voici le code de réinitialisation vous permettant de changer votre mot de passe :<BR>
                                            <H1 style='color:#9ce849;font-weight:800'>{{$user->resetCode}}</H1><BR>
                                            Si vous pensez qu'il s'agit d'une erreur nous vous
                                            invitons à nous contacter au plus vite à l'adresse
                                            <b><a href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a></b>.

                                    </p>
                                    
                                    <p style="line-height: 24px">
                                        Belle journée,<BR>
                                        - L'équipe Bébés Lutins 💚
                                    </p>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>





            </table>

        </td>
    </tr>

    <tr>
        <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
    </tr>

</table>

<!-- end section -->
@endsection
