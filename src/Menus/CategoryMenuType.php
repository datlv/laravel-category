<?php namespace Datlv\Category\Menus;

use Datlv\Kit\Support\HasRouteAttribute;
use Datlv\Menu\Types\MenuType;
use Datlv\Category\Category;
use CategoryManager;

/**
 * Class CategoryMenuType
 *
 * @package Datlv\Category\Menus
 */
abstract class CategoryMenuType extends MenuType
{
    use HasRouteAttribute;

    /**
     * @return string
     */
    abstract protected function categoryType();

    /**
     * @return array
     */
    public function formOptions()
    {
        return ['height' => 370] + parent::formOptions();
    }

    /**
     * @return string
     */
    protected function formView()
    {
        return 'category::menu.category_form';
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return CategoryManager::of($this->categoryType())->selectize();
    }

    /**
     * @param \Datlv\Menu\Menu $menu
     *
     * @return Category|null
     */
    protected function getCategory($menu)
    {
        return empty($menu->params['category_id']) ? null : Category::find($menu->params['category_id']);
    }

    /**
     * @param \Datlv\Menu\Menu $menu
     * @return string
     */
    protected function buildUrl($menu)
    {
        $category = $this->getCategory($menu);

        return $category ? $this->getRouteUrl($menu->params['route_show'], ['slug' => $category->slug]) : "#{$menu->params['route_show']}";
    }

    /**
     * @return array
     */
    protected function paramsAttributes()
    {
        return [
            [
                'name' => 'category_id',
                'title' => trans('category::menu.category.category_id'),
                'rule' => 'required|integer',
                'default' => null,
            ],
            [
                'name' => 'route_show',
                'title' => trans('category::menu.category.route_show'),
                'rule' => 'required|max:255',
                'default' => '',
            ],
        ];
    }
}