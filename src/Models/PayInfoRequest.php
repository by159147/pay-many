<?php

namespace Faed\Pay\Models;

use Illuminate\Database\Eloquent\Model;

class PayInfoRequest extends Model
{
    protected $guarded = [];

    protected $casts=['content'=>'array'];
}
