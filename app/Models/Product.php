<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','barcode','cost','price','stock','alerts','image','category_id'];

    public function sale(){
        return $this->hasMany(SaleDetails::class);
    }

    
    public function getImagenAttribute()
    {
        if(file_exists('storage/categorias/' . $this->image))
            return $this->image;
        else
            return 'noimg.jpg';
    }
}
