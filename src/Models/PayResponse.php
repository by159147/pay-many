<?php

namespace Faed\Pay\Models;

use Illuminate\Database\Eloquent\Model;

class PayResponse extends Model
{
    protected $guarded = [];
    protected $casts=['content'=>'array'];
}
