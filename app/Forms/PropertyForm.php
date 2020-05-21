<?php

namespace App\Forms;

use Laraform\Laraform;
use App\Repositories\PropertyTypeRepository;

class PropertyForm extends Laraform
{
    public $primaryKey = 'uuid';

    public $component = "property-form";

    public $class = "property-form";

    public function schema()
    {
        $typeRepo = app(PropertyTypeRepository::class);
        $range = range(1, 20);
        $options = array_combine($range, $range);

        return [
            'stype' => [
                'type' => 'radiogroup',
                'rules' => 'required',
                'items' => ['sale' => 'sale', 'rent' => 'rent'],
            ],
            'address' => [
                'type' => 'text',
                'floating' => 'Address',
                'placeholder' => 'Address',
                'rules' => 'required',
                'columns' => 6,
            ],
            'town' => [
                'type' => 'text',
                'floating' => 'City',
                'placeholder' => 'City',
                'rules' => 'required',
                'columns' => 6,
            ],
            'country' => [
                'type' => 'text',
                'floating' => 'Country',
                'placeholder' => 'Country',
                'rules' => 'required',
                'columns' => 6,
            ],
            'county' => [
                'type' => 'text',
                'floating' => 'County',
                'placeholder' => 'County',
                'rules' => 'required',
                'columns' => 4,
            ],
            'postcode' => [
                'type' => 'text',
                'floating' => 'PostCode',
                'placeholder' => 'PostCode',
                'rules' => 'required',
                'columns' => 2,
            ],
            'description' => [
                'type' => 'textarea',
                'floating' => 'Description',
                'placeholder' => 'Description',
                'rules' => 'required',
            ],
            'property_type_id' => [
                'type' => 'select',
                'floating' => 'Property Type',
                'placeholder' => 'Property Type',
                'rules' => 'required',
                'items' => $typeRepo->getList(),
                'columns' => 6,
            ],
            'num_bedrooms' => [
                'type' => 'select',
                'floating' => 'Bedrooms',
                'placeholder' => 'Bedrooms',
                'rules' => 'required',
                'items' => $options,
                'columns' => 3,
            ],
            'num_bathrooms' => [
                'type' => 'select',
                'floating' => 'Bathrooms',
                'placeholder' => 'Bathrooms',
                'rules' => 'required',
                'items' => $options,
                'columns' => 3,
            ],
            'price' => [
                'type' => 'text',
                'floating' => 'price',
                'placeholder' => 'price',
                'rules' => 'required|numeric',
                'columns' => 3,
            ],
        ];
    }

    public function buttons()
    {
        return [
            [
                "label" => "Save",
                "class" => "btn-primary w-20",

            ],
        ];
    }

    public function after()
    {
        return response([
            'status' => 'success',
            'messages' => ['Success'],
            'payload' => [
                'redirect' => route('listing', ['product'=>'sales'])
            ]
        ]);
    }

}
