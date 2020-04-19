@extends('templates.mail')

@section('title', 'Compte créé chez Bébés Lutins')

@section('mail-title', 'Votre compte Bébés Lutins')

@section('content')
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr valign="top">
            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
            <td>
                <p style="margin-top:0;">
                    Vous recevez cet email car vous venez de créer un compte
                    client sur notre site <a href="{{ route('homepage') }}" style="color:#6d7e44; text-decoration:none; font-weight:bold;">bebes-lutins.fr</a>.<br>
                    Si ce n'est pas le cas merci de nous contacter au plus vite à
                    l'adresse <a href="mailto:contact@bebes-lutins.fr" style="color:#6d7e44; text-decoration:none; font-weight:bold;">contact@bebes-lutins.fr</a>.
                </p>
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
