<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $likeStr = '%' . $request->get('search') . '%';
        if ($request->get('search')) {
            $countries = Country::where('name', 'like', $likeStr)
                ->paginate(20);
        }

        else
            $countries = Country::paginate(20);
        return view('admin.country.index', compact('countries'));
    }


    public function create(Country $country)
    {
        return view('admin.country.show', compact('country'));
    }


    public function store(CountryRequest $request)
    {
        $country = Country::create($request->toArray());
        return response()->redirectToRoute('admin.countries.edit', $country);
    }


    public function show(Country $country)
    {
        //
    }


    public function edit(Country $country)
    {
        return view('admin.country.show', compact('country'));
    }


    public function update(CountryRequest $request, Country $country)
    {
        $country->update($request->toArray());
        return response()->redirectToRoute('admin.countries.edit', $country);
    }


    public function destroy(Country $country)
    {
        $country->is_active = false;
        $country->save();
        return response()->redirectToRoute('admin.countries.countries');
    }
}
