<?php namespace Sebastian\Forms\Models;

use Model;

/**
 * Application Model
 */
class Application extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'sebastian_forms_applications';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'company_name',
        'country',
        'city',
        'district',
        'locatie',
        'budget',
        'text',
        'url',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
