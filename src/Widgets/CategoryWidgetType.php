<?php namespace Datlv\Category\Widgets;

use Datlv\Kit\Support\HasRouteAttribute;
use Datlv\Layout\WidgetTypes\WidgetType;
use CategoryManager;
use Datlv\Category\Category;

/**
 * Class CategoryWidget
 *
 * @package Datlv\Category\Widgets
 */
abstract class CategoryWidgetType extends WidgetType
{
    use HasRouteAttribute;

    /**
     * @return string
     */
    abstract protected function categoryType();

    /**
     * @param \Datlv\Layout\Widget|string $widget
     *
     * @return string
     */
    public function titleBackend($widget)
    {
        $category = $this->getCategory($widget);
        $title = $category ? ($category->isRoot() ? '' : $category->title) : $widget;

        return parent::titleBackend($title);
    }

    /**
     * @return array
     */
    public function formOptions()
    {
        return ['width' => null] + parent::formOptions();
    }

    /**
     * @return string
     */
    protected function formView()
    {
        return 'category::widget.category_form';
    }

    /**
     * @param \Datlv\Layout\Widget $widget
     *
     * @return string
     */
    protected function getCategoryTree($widget)
    {
        return ($category = $this->getCategory($widget)) ? $category->present()->tree(null, $widget->data['max_depth']) : '';
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return CategoryManager::of($this->categoryType())->selectize();
    }

    /**
     * @param \Datlv\Layout\Widget $widget
     *
     * @return Category|null
     */
    protected function getCategory($widget)
    {
        return $widget->data['category_id'] ? Category::find($widget->data['category_id']) : CategoryManager::of($this->categoryType())->node();
    }

    /**
     * @param \Datlv\Layout\Widget $widget
     *
     * @return string
     */
    protected function content($widget)
    {
        $category_tree = $this->getCategoryTree($widget);

        return view('category::widget.category_output', compact('widget', 'category_tree'))->render();
    }

    /**
     * @return array
     */
    protected function dataAttributes()
    {
        return [
            [
                'name' => 'category_id',
                'title' => trans('category::widget.category.category_id'),
                'rule' => '',
                'default' => null,
            ],
            [
                'name' => 'route_show',
                'title' => trans('category::widget.category.route_show'),
                'rule' => 'required|max:255',
                'default' => '',
            ],
            [
                'name' => 'max_depth',
                'title' => trans('category::widget.category.max_depth'),
                'rule' => 'required|integer|min:1',
                'default' => 1,
            ],
        ];
    }
}