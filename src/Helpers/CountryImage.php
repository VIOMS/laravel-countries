<?php

if (!function_exists('asset_country')) {
    /**
     * Give country object or flag parameter to return the asset url of the image
     * @param string|array|\Illuminate\Database\Eloquent\Model $flag
     * @return string
     */
    function asset_country(string|array|\Illuminate\Database\Eloquent\Model $flag): string
    {
        if($flag instanceof \Illuminate\Database\Eloquent\Model) {
            $flag = $flag->toArray();
        }
        if (is_array($flag) && array_key_exists('flag', $flag)) {
            $flag = $flag['flag'];
        }
        return asset('assets/vendor/countries/' . $flag);
    }
}
