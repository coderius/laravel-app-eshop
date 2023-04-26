<?php

namespace App\Models\Deals;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deals\Castomers;

class CastomersOrders extends Model
{
    protected $table = "castomers_orders";

    public function customer()
    {
        return $this->belongsTo(Castomers::class, 'castomer_id', 'id');
    }
}
