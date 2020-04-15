<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class Admin extends Model
{
    public static function check()
    {
        return Session::has('admin') && \App\Admin::where('uuid', session('admin')->uuid)->exists();
    }
}
