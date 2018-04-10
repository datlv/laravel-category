<?php
namespace Datlv\Category;

use Datlv\Kit\Extensions\Request;

/**
 * Class CategoryRequest
 *
 * @package Datlv\Category
 */
class CategoryRequest extends Request
{
    public $trans_prefix = 'category::common';
    public $rules = [
        'title' => 'required|max:255',
        'slug'  => 'required|max:255',
    ];

    public $translatable = ['title', 'slug'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }

}
