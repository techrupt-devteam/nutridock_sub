<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MealType extends Model 
{
    protected $table = 'meal_type';
    protected $fillable = ['meal_type_id','meal_type_name'];


    public static function getData(){
        $data = MealType::select('meal_type_id','meal_type_name')
                ->where('is_active', '1')    
                ->where('is_deleted', '0')                        
                ->get()->toArray();

        return $data;
    }
}

?>