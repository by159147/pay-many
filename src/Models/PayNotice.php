<?php

namespace Faed\Pay\Models;

use Illuminate\Database\Eloquent\Model;

class PayNotice extends Model
{
    protected $guarded= [];


    public function paySubNotice()
    {
        return $this->hasOne(PayInfoNotice::class,'pay_notice_id','id');

    }
}
