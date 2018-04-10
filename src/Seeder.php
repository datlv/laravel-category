<?php
namespace Datlv\Category;

use Datlv\Kit\Support\VnString;
use DB;

/**
 * Class Seeder
 *
 * @package Datlv\Category
 */
class Seeder
{
    /**
     * @param string $title
     *
     * @return \Datlv\Category\Category
     */
    protected function seedCategoryItem($title)
    {
        return Category::create(['title' => $title, 'slug' => VnString::to_slug($title)]);
    }

    /**
     * @param \Datlv\Category\Category $root
     * @param array $items
     */
    protected function seedCategory($root, $items)
    {
        foreach ($items as $key => $item) {
            if (is_string($item)) {
                $child = $this->seedCategoryItem($item);
                $child->makeChildOf($root);
            } else {
                $child = $this->seedCategoryItem($key);
                $child->makeChildOf($root);
                $this->seedCategory($child, $item);
            }
        }
    }

    /**
     * @param array $data
     */
    public function seed($data)
    {
        DB::table('categories')->truncate();
        
        foreach ($data as $type => $items) {
            $this->seedCategory($this->seedCategoryItem($type), $items);
        }
    }
}