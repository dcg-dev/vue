<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\AdminCountryStore;
use App\Models\Country;
use Illuminate\Http\Request;

trait CountryController
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function all(Request $request)
    {
        return Country::orderBy('name')
            ->paginate($request->get('per_page', 20));
    }

    /**
     * Saves or creates a new country
     *
     * @param \App\Http\Requests\License\LicenseStore $request
     * @return \App\Models\License
     */
    public function store(AdminCountryStore $request)
    {
        $data = $request->only(['name', 'vat']);
        $country = new Country();
        if ($request->get('id')) {
            $country = Country::where('id', $request->get('id'))->firstOrFail();
        }
        $country->fill($data);
        $country->saveOrFail();
        return $country;
    }


    /**
     * @param \App\Models\License $license
     * @return array
     */
    public function delete(Country $country)
    {
        return [
            'status' => $country->delete()
        ];
    }
}
