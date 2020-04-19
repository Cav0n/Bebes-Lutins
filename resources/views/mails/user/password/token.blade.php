@extends('templates.mail')

@section('title', 'Modification de votre mot de passe Bébés Lutins')

@section('mail-title', 'Modification de mot de passe')

@section('content')
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr valign="top">
            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
            <td>
                <p style="margin-top:0;">
                    Vous venez de demander la réinitialisation de votre mot de passe sur notre site
                    <a href="{{ route('homepage') }}" style="color:#6d7e44; text-decoration:none; font-weight:bold;">bebes-lutins.fr</a>.<br>
                    Si ce n'est pas le cas merci de nous contacter au plus vite à
                    l'adresse <a href="mailto:contact@bebes-lutins.fr" style="color:#6d7e44; text-decoration:none; font-weight:bold;">contact@bebes-lutins.fr</a>.
                </p>
                <p>Voici le code permettant de modifier votre mot de passe : </p>
                <h1 style="text-align: center;">{{ $token }}</h1>
                <p>
                    En vous souhaitant une agréable journée,
                </p>
                <p>
                    L'équipe Bébés Lutins. 💚
                </p>
            </td>
            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
        </tr>
    </tbody>
</table>
@endsection
