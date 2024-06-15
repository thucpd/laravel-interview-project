<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FruitCategory extends Model
{
    use HasFactory;
    protected $table = 'fruit_category';
    protected $primaryKey = 'fruit_category_id';

    protected $fillable = [
        'fruit_category_name',
        'fruit_category_desc',
    ];
}
