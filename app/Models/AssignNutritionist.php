<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
class  AssignNutritionist extends Model
{
    protected $table 	   = "nutri_mst_subcriber_assign";
    protected $primaryKey  = "subcriber_assign_id";
    protected $fillable    = [
		"subscriber_id",
		"nutritionist_id",
		"is_active",
		"is_deleted"
	];

}
