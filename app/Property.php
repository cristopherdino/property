<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public $table = 'property';

    public $fillable = ['address1', 'address2', 'city', 'postcode'];

    /**
     * @return Property[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getProperties()
    {
        return $this->all()->map(function ($value) {
            // Not suggested. Only for the purpose of the test :)
            $value['geometry'] = $this->getLongLat($value->address1 . '' . $value->address2);
            return $value;
        });

    }

    /**
     * @param $id
     */
    public function getProperty($id)
    {
        $data = $this->find($id);
        $data['geometry'] = $this->getLongLat($data->address1 . ', ' . $data->address2);
        return $data;
    }

    /**
     * @return mixed
     */
    private function getLongLat($address)
    {
        $data = $this->getGoogleMapData($address);
        return $data->geometry->location;
    }

    /**
     * @param $address
     * @return array
     */
    public function parseAddress($address)
    {
        $arr = [];
        $data = $this->getGoogleMapData($address);
        $arr['city'] = $this->extractGoogleMapData($data, 'locality');
        $arr['postal_code'] = $this->extractGoogleMapData($data, 'postal_code');

        return $arr;
    }

    /**
     * @param $address
     */
    private function getGoogleMapData($address)
    {
        $client = new Client();
        if (config('app.google_map_base_uri')) {
            $result = $client->get('http://property.test/api/google_map_mocking' . '?address=' . urlencode($address));
        } else {
            $result = $client->get(config('app.google_map_base_uri') . '?address=' . urlencode($address));
        }
        return json_decode($result->getBody())->result;
    }

    /**
     * @param $json
     * @param $parameter
     * @return mixed
     */
    public function extractGoogleMapData($json, $parameter)
    {
        $data = collect(collect($json)->get('address_components'))->filter(function ($value) use ($parameter) {
            return collect($value->types)->contains($parameter);
        });

        return $data->first()->long_name;;

    }
}
