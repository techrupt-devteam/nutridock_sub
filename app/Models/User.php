<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table 	   = "users";
    protected $primaryKey  = "id";
    protected $fillable = [
    	"name",
		"email",
		"password",
		"subscriber_id",
		"subscriber_dtl_id",
		"nutritionist_id",
		"mobile",
		"state",
		"city",
		"area",
		"profile_image",
		"remember_token",
		"last_login",
		"roles",
		"created_at",
		"updated_at",
		"email_verified_at"
    ];

    public function vendor_cat()
    {
        return $this->hasOne('App\Models\Vendor_category', 'id', 'vendor_category_id');
    }
}
