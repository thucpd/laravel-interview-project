<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FruitItem extends Model
{
    use HasFactory;
    protected $table = 'fruit_item';
    protected $primaryKey = 'fruit_item_id';

    protected $fillable = [
        'fruit_item_name',
        'unit_id',
        'fruit_category_id',
        'price',
    ];
}
