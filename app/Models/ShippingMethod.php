<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductOwner;

class ShippingMethod extends Model
{
    protected $table = 'shipping_methods';

    //status
    const STATUS_ACTIVE = 1;
    const STATUS_DESIBLED = 0;

    public function productOwner()
    {
        return $this->belongsTo(ProductOwner::class, 'owner_id', 'id');
    }
}
