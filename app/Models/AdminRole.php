<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $fillable = [
        'subadmin_id',
        'module',
        'view_access',
        'edit_access',
        'full_access',
    ];
}
