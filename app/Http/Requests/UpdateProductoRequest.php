<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $producto = $this->route('producto');
        return [
            'codigo' => 'required|unique:productos,codigo,'.$producto->id.'|max:50',
            'nombre' => 'required|unique:productos,nombre,'.$producto->id.'|max:80',
            'descripcion' => 'nullable|max:55',
            'fecha_vencimiento' => 'nullable|date',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
            'marca_id' => 'required|integer|exists:marcas,id',
            'presentacione_id' => 'required|integer|exists:presentaciones,id',
            'categorias' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'marca_id' => 'marca',
            'presentacione_id' => 'presentación'
        ];
    }

    public function messages(){
        return [
            'codigo.required' => 'Se necesita un campo código'
        ];
    }
}
