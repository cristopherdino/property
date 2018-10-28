<?php

namespace App\Http\Controllers;

use App\Property;
use Illuminate\Http\Request;

class propertyController extends Controller
{
    /**
     * @param Property $property
     * @return \Illuminate\Http\JsonResponse
     */
    function index(Property $property)
    {
        return response()->json($property->getProperties(), 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    function show($id, Property $property)
    {
        $data = $property->getProperty($id);
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @param Property $property
     */
    function store(Request $request, Property $property)
    {
        $mapData = $property->parseAddress($request->get('address1') . ', ' . $request->get('address2'));

        Property::create([
            'address1' => $request->get('address1'),
            'address2' => $request->get('address2'),
            'city' => $mapData['city'],
            'postcode' => $mapData['postal_code'],
        ]);
    }
}
