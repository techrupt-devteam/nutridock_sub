<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Referal extends Model 
{
    protected $table = 'nutri_mst_referal';
    protected $primaryKey  = "id";
    protected $fillable = [
    	'discount_per_to_refree',
    	'discount_per_to_affiliate',
    	'discount_type',
    	'min',
    	'max',
    	'is_active'];
}

