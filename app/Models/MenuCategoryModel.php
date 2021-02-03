<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MenuCategoryModel extends Model 
{
    protected $table = 'menu_categories';
    protected $primaryKey  = "id";
    protected $fillable = ['name'];
}

