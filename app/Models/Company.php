<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_id",
        "company_name",
        "street_address",
        "representative_name",
    ];

    public function product() {
        return $this->hasMany(Product::class);
    }
}
