<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentcommissionsmodel extends Model
{
    
    protected $table='Paymentcommissions';
    protected $fillable = ['companyname', 'commissions','status'];





}
