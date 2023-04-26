<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';


    //status
    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;

    //is first
    const FIRST_IMG = 1;
    const NOT_FIRST_IMG = 0;
    
}
