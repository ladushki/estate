<?php declare(strict_types = 1);

namespace App\Http\Requests;

use Laraplus\Form\Helpers\FormBuilder;
use Illuminate\Foundation\Http\FormRequest;

class Property extends FormRequest
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
     * @param $route
     * @return \Laraplus\Form\Form
     */
    public function form($route): \Laraplus\Form\Form
    {
        $form = $this->getFormBuilder();

        $form->open('create')
            ->id('property')
            ->method('POST')
            ->action($route)->multipart();
        $form->hidden('uuid');
        $form->hidden('id');
        $form->text('country')->label('Country');
        $form->text('county')->label('County');
        $form->text('town')->label('Town');
        $form->text('postcode')->label('Postcode');
        $form->textArea('description')->label('Description');
        $form->text('address')->label('Address');
        $form->text('price')->label('Price');
        $form->select('property_type_id')->label('Type');
        $form->select('num_bedrooms')->label('Bedrooms');
        $form->select('num_bathrooms')->label('Bathrooms');
        $form->checklist('type')->label('For Sale / For Rent')->setClass('')->addGroupClass('text-left');
        $form->file('image_full')->label('Image');
        $form->submit('submit')->addClass('btn-primary')->text('Save');
        $form->close();

        return $form;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country' => 'required|string',
            'county' => 'required|string',
            'town' => 'required|string',
            'postcode' => 'required|string',
            'uuid' => 'required',
            'address' => 'required|string|min:3',
            'property_type_id' => 'required|integer',
            'description' => 'required',
            'num_bedrooms' => 'required',
            'num_bathrooms' => 'required',
            'price' => 'required',
            'type' => 'required',
            'image_full' => 'nullable|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100|max:2048',
        ];
    }
}
