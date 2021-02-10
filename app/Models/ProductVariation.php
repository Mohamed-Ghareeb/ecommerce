<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Stock;
use App\Models\Product;
use App\Models\ProductVariationType;
use App\Models\Traits\FormattedPrice;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use FormattedPrice;

    public function getPriceAttribute($value)
    {
        if ($value == 0) {
            return $this->product->price;
        }

        return new Money($value);
    }

    public function priceVaries()
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
