<?php

namespace Webkul\Shop\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Webkul\Attribute\Models\Attribute;
use Webkul\Product\Models\Product;
use Webkul\Product\Models\ProductAttributeValue;

class PackageQuantity implements ValidationRule
{
    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find(request()->product_id);
        $qtyPerPackage = $product?->getAttribute('qty_per_package');

        if (! $product || ($value % $qtyPerPackage !== 0)) { // Checks if the quantity is divisible by pieces per package
            $fail(trans('shop::app.checkout.cart.inventory-warning'));
        }
    }
}
