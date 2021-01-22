<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PhysicalActivity extends Model 
{
    protected $table = 'physical_activity';
    protected $fillable = ['physical_activity_id','physical_activity'];


    public static function getData(){
        $data = PhysicalActivity::select('physical_activity_id','physical_activity')
                ->where('is_active', '1')    
                ->where('is_deleted', '0')                            
                ->get()->toArray();

        return $data;
    }
}

?>