<?php

namespace Modules\Shop\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\factories\ProductFactory;
use App\Traits\UuidTrait;

class Product extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'parent_id',
        'user_id',
        'sku',
        'type',
        'name',
        'slug',
        'price',
        'featured_image',
        'sale_price',
        'status',
        'stock_status',
        'manage_stock',
        'publish_date',
        'excerpt',
        'body',
        'metas',
    ];

    protected $table = 'shop_products';

    public const DRAFT = 'DRAFT';
    public const ACTIVE = 'ACTIVE';
    public const INACTIVE = 'INACTIVE';

    public const STATUSES = [
        self::DRAFT => 'Draf',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];

    public const STATUS_IN_STOCK = 'IN_STOCK';
    public const STATUS_OUT_OF_STOCK = 'OUT_OF_STOCK';

    public const STOCK_STATUSES = [
        self::STATUS_IN_STOCK => 'In Stock',
        self::STATUS_OUT_OF_STOCK => 'Out of Stock',
    ];

    public const SIMPLE = 'SIMPLE';
    public const CONFIGURABLE = 'CONFIGURABLE';
    public const TYPES = [
        self::SIMPLE => 'Simple',
        self::CONFIGURABLE => 'Configurable',
    ];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventory()
    {
        return $this->hasOne(ProductInventory::class);
    }

    public function variants()
    {
        return $this->hasMany(Product::class, 'parent_id')->orderBy('price', 'ASC');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'shop_categories_products', 'product_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'shop_products_tags', 'product_id', 'tag_id');
    }

    public function attributes()
    {
        return $this->hasMany('Modules\Shop\App\Models\ProductAttribute', 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function getPriceLabelAttribute()
    {
        return number_format($this->price);
    }
}
