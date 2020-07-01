<?php

namespace Faed\Pay\Models;

use Illuminate\Database\Eloquent\Model;

class PayInfoNotice extends Model
{
    protected $guarded= [];
    protected $casts=['content'=>'array'];

}
