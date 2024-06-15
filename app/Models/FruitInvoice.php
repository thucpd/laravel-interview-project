<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FruitInvoice extends Model
{
    use HasFactory;
    protected $table = 'fruit_invoice';
    protected $primaryKey = 'fruit_invoice_id';

    public function fruitInvoiceDetail()
    {
        return $this->hasMany(FruitInvoiceDetail::class, 'fruit_invoice_id', 'fruit_invoice_id');
    }
}
