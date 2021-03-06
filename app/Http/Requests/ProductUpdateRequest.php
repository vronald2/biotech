<?php

namespace App\Http\Requests;


use App\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules(){
        return [
            'publish_start' => 'required',
            'publish_end' => 'required',
            'description_en' => 'required',
            'description_hu' => 'required',
            'name_en' => 'required',
            'name_hu' => 'required',
            'price_en' => 'required|numeric',
            'price_hu' => 'required|numeric'
        ];
    }

    public function save($product)
    {

        if($this->hasFile('file')){
            $path = $this->file('file')->store('product_images');
            $product->image = $path;
        }

        $product->fill($this->all());

        $product->setTranslation('name', 'en', $this->get('name_en'));
        $product->setTranslation('name', 'hu', $this->get('name_hu'));

        $product->setTranslation('description', 'en', $this->get('description_en'));
        $product->setTranslation('description', 'hu', $this->get('description_hu'));

        $product->setTranslation('price', 'en', $this->get('price_en'));
        $product->setTranslation('price', 'hu', $this->get('price_hu'));

        $product->save();

        $product->retag($this->get('tags'));

        return $product;
    }
}
