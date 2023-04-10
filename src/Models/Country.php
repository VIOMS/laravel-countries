<?php

namespace Vioms\Countries\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read $flag_image
 * @property-read $flagImage
 */
class Country extends Model
{
    /**
     * Will load all countries from json file
     */
    const LOAD_FILE = 1;
    /**
     * Will load all countries from cache
     */
    const LOAD_CACHE = 2;
    /**
     * Will load all countries from database
     */
    const LOAD_DB = 3;

    protected $countries = [];

    protected $table;

    protected $casts = [
        'languages' => 'json',
        'neighbour_codes' => 'json',
        'neighbour_ids' => 'json',
        'eea' => 'boolean',
    ];

    protected $fillable = [
        'id',
        'capital',
        'citizenship',
        'country-code',
        'currency',
        'currency_code',
        'currency_sub_unit',
        'full_name',
        'iso_3166_2',
        'iso_3166_3',
        'name',
        'region-code',
        'sub-region-code',
        'eea',
        'calling_code',
        'currency_symbol',
        'currency_decimals',
        'flag',
        'area_in_km',
        'population',
        'continent',
        'tld',
        'postal_code_format',
        'postal_code_regex',
        'languages',
        'neighbour_codes',
        'neighbour_codes_ids',
    ];

    public function __construct()
    {
        $this->table = config('countries.table', 'countries');
        parent::__construct();
    }

    public function getFlagImageAttribute()
    {
        return asset_country($this->flag);
    }


    public function getOne(int $id): array
    {
        return $this->fetchCountries()[$id];
    }

    /**
     * Returns a list of countries
     *
     * @param string sort
     *
     * @return array
     */
    public function getList($sort = null): array
    {
        //Get the countries list
        $countries = $this->fetchCountries();

        //Sorting
        $validSorts = [
            'capital',
            'citizenship',
            'country-code',
            'currency',
            'currency_code',
            'currency_sub_unit',
            'full_name',
            'iso_3166_2',
            'iso_3166_3',
            'name',
            'region-code',
            'sub-region-code',
            'eea',
            'calling_code',
            'currency_symbol',
            'flag',
        ];

        if (!is_null($sort) && in_array($sort, $validSorts)) {
            uasort($countries, function ($a, $b) use ($sort) {
                if ($a instanceof Model) {
                    $a = $a->toArray();
                }
                if ($b instanceof Model) {
                    $b = $b->toArray();
                }
                if (!isset($a[$sort]) && !isset($b[$sort])) {
                    return 0;
                } elseif (!isset($a[$sort])) {
                    return -1;
                } elseif (!isset($b[$sort])) {
                    return 1;
                } else {
                    return strcasecmp($a[$sort], $b[$sort]);
                }
            });
        }

        //Return the countries
        return $countries;
    }


    /**
     * Returns a list of countries suitable to use with a select element in LaravelCollective\html
     * Will show the value and sort by the column specified in the display attribute
     * @param string $display key to display in select default: name
     *
     * @return array
     */
    public function getListForSelect($display = 'name'): array
    {
        $countries = [];
        foreach ($this->getList($display) as $key => $value) {
            $countries[$key] = $value[$display];
        }
        return $countries;
    }

    /**
     * Get all countries
     * @return array|mixed
     */
    protected function fetchCountries()
    {
        if (!empty($this->countries)) {
            return $this->countries;
        }

        $type = config('countries.cache', self::LOAD_FILE);
        if ($type === self::LOAD_CACHE && \Cache::has(__FUNCTION__)) {
            return $this->countries = \Cache::get(__FUNCTION__);
        } elseif ($type === self::LOAD_DB) {
            return $this->countries = $this->get()->pluck(null, 'id')->toArray();
        }

        $this->countries = json_decode(file_get_contents(implode(DIRECTORY_SEPARATOR, [__DIR__, '../../resources/countries.json'])), true);
        if ($type === self::LOAD_CACHE) {
            \Cache::put(__FUNCTION__, $this->countries);
        }
        return $this->countries;
    }
}
