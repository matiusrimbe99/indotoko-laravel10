<?php

namespace Modules\Shop\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\factories\TagFactory;
use App\Traits\UuidTrait;

class Tag extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'shop_tags';
    protected $fillable = ['slug', 'name'];

    protected static function newFactory(): TagFactory
    {
        return TagFactory::new();
    }

    public function products()
    {
        $this->belongsToMany(Product::class, 'shop_products_tags', 'tag_id', 'product_id');
    }
}
