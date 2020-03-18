<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Admin extends Model
{
    public static function check()
    {
        return Session::has('admin') && \App\Admin::where('uuid', session('admin')->uuid)->exists();
    }
}
