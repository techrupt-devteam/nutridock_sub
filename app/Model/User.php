<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table 	   = "users";
    protected $primaryKey  = "id";

    protected $fillable = [
		"first_name",
		"last_name",
		"store_name",
		"min_order_value",
		"delivery_fees",
		"store_id",
		"email",
		"password",
		"mobile_no",
		"state",
		"city",
		"area",
		"pincode",
		"gst_no",
		"admin_approval",
		"remember_token",
		"last_login",
		"role",
		"type_id",
		"company_name",
		"company_address",
		"created_at",
		"updated_at",
		"pan_number",
		"upload_pan",
		"kyc_document_type",
		"kyc_document",
		"sales_member",
		
		//"kyc_document",
		"payment_terms",

    ];

    public function vendor_cat()
    {
        return $this->hasOne('App\Model\Vendor_category', 'id', 'vendor_category_id');
    }
}
