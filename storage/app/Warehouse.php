<?php namespace Intertech\Shop\Models;

use Model;
use Intertech\Shop\Models\FilterAttribute;
use October\Rain\Database\Traits\Validation;

/**
 * Warehouse Model
 */
class Warehouse extends Model
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'intertech_shop_warehouses';

    public $rules = [
        'product_id' => 'required',
        'color_id' => 'required',
        'size_id' => 'required',
        'qty' => 'required',
    ];

    public $customMessages = [
        'product_id' => 'Продукт',
        'color_id' => 'Цвет',
        'size_id' => 'Размер',
        'qty' => 'Количество',
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'product' => 'Intertech\Shop\Models\Product',
        'color' => 'Intertech\Shop\Models\FilterAttribute',
        'size' => 'Intertech\Shop\Models\FilterAttribute',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function filterFields($fields, $context = null)
    {
        $fields->color_id->hidden = true;
        $fields->size_id->hidden = true;
        $fields->qty->hidden = true;

        if (!empty($fields->product->value)) {
            $fields->color_id->hidden = false;
        }

        if (!empty($fields->color_id->value) && !empty($fields->product->value)) {
            $fields->size_id->hidden = false;
        }

        if (!empty($fields->color_id->value) && !empty($fields->product->value) && !empty($fields->size_id->value)) {
            $fields->qty->hidden = false;
        }
    }

    public function productColors()
    {
        $colors = FilterAttribute::whereHas('parent', function($query) {
            $query->where('type', 'color');
        })->has('tint')->with('tint')->enabled()
            ->get()->each(function($color) {
                $color->full_name = "{$color->public_name} ({$color->tint->public_name})";
            })
        ;


        return $colors->lists('full_name', 'id');
    }

    public function productSizes()
    {
        $sizes = FilterAttribute::whereHas('parent', function($query) {
            $query->where('type', 'size');
        })->enabled()
            ->get()->each(function($color) {
                $color->full_name = "{$color->public_name}";
            })
        ;

        return $sizes->lists('full_name', 'id');
    }
}
