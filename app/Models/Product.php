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
        'product_name',
        'price',
        'stock',
        'comment',
        'company_id',
        'filename',
    ];

    public function sale(){
        return $this->hasMany(Sale::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    //新規追加処理
    public static function createProduct($data)
    {
        return self::create($data);
    }

    //既存データ編集処理
    public function updateProduct($data)
    {
    return $this->update($data);
    }

    //削除処理
    public static function deleteProduct($id){
        return self::where('id',$id)->delete();
    }

}
