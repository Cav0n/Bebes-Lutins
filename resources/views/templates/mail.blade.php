<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
<title>@yield('title', 'Bébés Lutins')</title>
</head>
<body style="font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color:#f0f2ea; margin:0; padding:0; color:#333333;">

<table width="100%" bgcolor="#f0f2ea" cellpadding="0" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td style="padding:15px 0;">
                <!-- begin main block -->
                <table cellpadding="0" cellspacing="0" border="0" align="center">
                    <tbody>
                        <tr>
                            <td>
                                <a href="{{ route('homepage') }}" style="display:block; width:150px; height:150px; margin:0 auto;">
                                    <img src="{{ asset('images/logo.png') }}" width="150" height="150" alt="Bébés Lutins" style="display:block; border:0; margin:0;">
                                </a>
                                <p style="margin:0 0 15px; text-align:center; font-size:14px; line-height:20px; text-transform:uppercase; color:#626658;">
                                    Couches lavables écologiques fabriquées en France.
                                </p>
                                <!-- begin wrapper -->
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" style="max-width: 600px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" rowspan="3" bgcolor="#FFFFFF" style="padding:0 0 30px;">
                                                <!-- begin content -->
                                                @if(isset($headerImage) && is_array($headerImage))
                                                <img src="{{ asset($headerImage['url']) }}" width="600" height="400" alt="{{ $headerImage['alt'] }}" style="display:block; border:0; margin:0 0 15px; background:#eeeeee;object-fit:cover;">
                                                @endif
                                                <p style="margin:15px 30px; text-align:center; text-transform:uppercase; font-size:24px; line-height:30px; font-weight:bold; color:#484a42;">
                                                    @yield('mail-title', 'Notification Bébés Lutins')
                                                </p>

                                                @yield('content')

                                                <!-- /end articles -->
                                                <p style="margin:0; border-top:2px solid #e5e5e5; font-size:5px; line-height:5px; margin:0 30px 29px;">&nbsp;</p>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tbody>
                                                        <tr valign="top">
                                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                                            <td>
                                                                <p style="margin:0 0 4px; font-weight:bold; color:#333333; font-size:14px; line-height:22px;">Bébés Lutins</p>
                                                                <p style="margin:0; color:#333333; font-size:11px; line-height:18px;">
                                                                    Rue du 19 Mars 1962, 63300, THIERS<br>
                                                                    Service client : 06 41 56 91 65<br>
                                                                    Site Internet : <a href="{{ route('homepage') }}" style="color:#6d7e44; text-decoration:none; font-weight:bold;">www.bebes-lutins.fr</a>
                                                                </p>
                                                            </td>
                                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                                            <td width="120">
                                                                <a href="https://www.facebook.com/bebes.lutins" style="float:left; width:24px; height:24px; margin:6px 8px 10px 0;">
                                                                    <img src="{{ asset('images/icons/facebook-small.png') }}" width="24" height="24" alt="facebook" style="display:block; margin:0; border:0;">
                                                                </a>
                                                                <a href="https://instagram.com/bebeslutins" style="float:left; width:24px; height:24px; margin:6px 8px 10px 0;;">
                                                                    <img src="{{ asset('images/icons/instagram-small.png') }}" width="24" height="24" alt="tumblr" style="display:block; margin:0; border:0;">
                                                                </a>
                                                                <a href="https://twitter.com/BebesLutins" style="float:left; width:24px; height:24px; margin:6px 8px 10px 0;">
                                                                    <img src="{{ asset('images/icons/twitter-small.png') }}" width="24" height="24" alt="twitter" style="display:block; margin:0; border:0;">
                                                                </a>

                                                            </td>
                                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- end content -->
                                            </td>
                                            <td width="4" height="4" style="background:url(shadow-right-top.png) no-repeat 0 0;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>


                                        <tr>
                                            <td width="4" style="background:url(shadow-left-center.png) repeat-y 100% 0;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" style="background:url(shadow-right-center.png) repeat-y 0 0;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>

                                        <tr>
                                            <td width="4" height="4" style="background:url(shadow-left-bottom.png) repeat-y 100% 100%;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" height="4" style="background:url(shadow-right-bottom.png) repeat-y 0 100%;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>

                                        <tr>
                                            <td width="4" height="4" style="background:url(shadow-bottom-corner-left.png) no-repeat 100% 0;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" height="4" style="background:url(shadow-bottom-left.png) no-repeat 100% 0;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td height="4" style="background:url(shadow-bottom-center.png) repeat-x 0 0;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" height="4" style="background:url(shadow-bottom-right.png) no-repeat 0 0;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" height="4" style="background:url(shadow-bottom-corner-right.png) no-repeat 0 0;"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- end wrapper-->
                                <p style="margin:0; padding:15px 0 0; text-align:center; font-size:11px; line-height:13px; color:#333333;">
                                    Vous ne souhaitez plus revoir d'emails facultatifs de notre part ? Désinscrivez-vous <a href="{{ route('homepage') }}" style="color:#333333; text-decoration:underline;">ici</a>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- end main block -->
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
