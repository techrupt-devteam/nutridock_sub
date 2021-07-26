<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class StoryType extends Model
{
    protected $table 	   = "nutri_mst_story_type";
    protected $primaryKey  = "story_id";
    protected $fillable = [
		"story_name",
		"is_active",
		"is_deleted"
	];
}
