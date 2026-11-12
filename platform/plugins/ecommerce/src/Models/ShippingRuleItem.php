<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Models\BaseModel;
use Botble\Ecommerce\Traits\LocationTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingRuleItem extends BaseModel
{
    use LocationTrait;

    protected $table = 'ec_shipping_rule_items';

    protected $fillable = [
        'shipping_rule_id',
        'country',
        'state',
        'city',
        'adjustment_price',
        'is_enabled',
        'zip_code',
        'zip_code_from',
        'zip_code_to',
    ];

    public function shippingRule(): BelongsTo
    {
        return $this->belongsTo(ShippingRule::class)->withDefault();
    }

    protected function adjustmentPrice(): Attribute
    {
        return Attribute::set(fn (?string $value) => (float) str_replace(',', '', $value));
    }

    protected function nameItem(): Attribute
    {
        return Attribute::get(function () {
            $zipDisplay = $this->zip_code_from;

            if ($this->zip_code_from && $this->zip_code_to && $this->zip_code_from !== $this->zip_code_to) {
                $zipDisplay = $this->zip_code_from . ' - ' . $this->zip_code_to;
            }

            return trim(implode(', ', array_filter([$this->state_name, $this->city_name, $zipDisplay ?: $this->zip_code])));
        });
    }
}
