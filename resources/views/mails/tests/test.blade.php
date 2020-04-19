@extends('templates.mail')

@section('title', 'Test d\'email')

@section('mail-title', 'Test d\'email')

@section('content')
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr valign="top">
            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
            <td>
                <a style="display:block; margin:0 0 14px;" href="{{ route('homepage') }}"><img src="{{ asset('images/utils/emails/exemple-1.jpg') }}" width="255" height="150" alt="More" style="display:block; margin:0; border:0; background:#eeeeee;object-fit:cover;"></a>
                <p style="font-size:14px; line-height:22px; font-weight:bold; color:#333333; margin:0 0 5px;"><a href="{{ route('homepage') }}" style="color:#6c7e44; text-decoration:none;">Un petit titre sympa</a></p>
                <p style="margin:0 0 35px; font-size:12px; line-height:18px; color:#333333;">Fusce amet ligula ornare tempus vulputate ipsum semper. Praesent non lorem odio. Fusce sed dui massa, eu viverra erat.</p>
            </td>
            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
            <td>
                <a style="display:block; margin:0 0 14px;" href="{{ route('homepage') }}"><img src="{{ asset('images/utils/emails/exemple-2.jpg') }}" width="255" height="150" alt="More" style="display:block; margin:0; border:0; background:#eeeeee;object-fit:cover;"></a>
                <p style="font-size:14px; line-height:22px; font-weight:bold; color:#333333; margin:0 0 5px;"><a href="{{ route('homepage') }}" style="color:#6c7e44; text-decoration:none;">Encore un superbe titre !</a></p>
                <p style="margin:0 0 35px; font-size:12px; line-height:18px; color:#333333;">Fusce amet ligula ornare tempus vulputate ipsum semper. Praesent non lorem odio. Fusce sed dui massa, eu viverra erat.</p>
            </td>
            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
        </tr>
        <tr valign="top">
            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
            <td colspan="3">
                <a style="display:block; margin:0 0 14px;" href="{{ route('homepage') }}"><img src="{{ asset('images/utils/emails/exemple-3.jpg') }}" width="540" height="220" alt="More" style="display:block; margin:0; border:0; background:#eeeeee;object-fit:cover;"></a>
                <p style="font-size:14px; line-height:22px; font-weight:bold; color:#333333; margin:0 0 5px;"><a href="{{ route('homepage') }}" style="color:#6c7e44; text-decoration:none;">Et enfin un dernier titre aguicheur :) !</a></p>
                <p style="margin:0 0 35px; font-size:12px; line-height:18px; color:#333333;">Fusce amet ligula ornare tempus vulputate ipsum semper. Praesent non lorem odio. Fusce sed dui massa, eu viverra erat.</p>
            </td>
            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
        </tr>
    </tbody>
</table>
@endsection
