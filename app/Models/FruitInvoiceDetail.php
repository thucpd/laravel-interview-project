<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FruitInvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'fruit_invoice_detail';
    protected $primaryKey = 'fruit_invoice_detail_id';
}
