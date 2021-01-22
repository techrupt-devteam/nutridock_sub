<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FoodAvoid extends Model 
{
    protected $table = 'food_avoid';
    protected $fillable = ['food_avoid_id','food_avoid_name'];


    public static function getData(){
        $data = FoodAvoid::select('food_avoid_id','food_avoid_name')
                ->where('is_active', '1')    
                ->where('is_deleted', '0')  
                ->OrderBy('food_avoid_name','ASC')                          
                ->get()->toArray();

        return $data;
    }
}

?>