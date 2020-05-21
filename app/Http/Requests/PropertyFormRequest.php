<?php declare(strict_types = 1);

namespace App\Http\Requests;

use Laraplus\Form\Helpers\FormBuilder;
use Illuminate\Foundation\Http\FormRequest;

class PropertyFormRequest extends FormRequest
{
    use FormBuilder;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.country' => 'required|string',
            'data.county' => 'required|string',
            'data.town' => 'required|string',
            'data.postcode' => 'required|string',
            'data.address' => 'required|string|min:3',
            'data.property_type_id' => 'required|integer',
            'data.description' => 'required',
            'data.num_bedrooms' => 'required',
            'data.num_bathrooms' => 'required',
            'data.price' => 'required',
            'data.stype' => 'required',
        ];
    }
}
