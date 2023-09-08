<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "company_id",
        "product_name",
        /* "company_name", */
        "price",
        "stock",
        "comment",
        "filename",
    ];

    public function sale(){
        return $this->hasMany(Sale::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
