<?php

function getCategoryValue($category) {
    switch($category) {
        case 'main field':
            return 3;
        case 'juniors':
            return 6;
        case 'historics':
            return 4;
        case 'international':
           return 1;
        case 'national':
            return 2;
        case 'modified':
            return 5;
        default:
            return 6;
    }
}

class CategoryComparisionObj {
    var $category;
    function CategoryComparisionObj($category)
    {
        $this->name = $category;
    }

    /* This is the static comparing function: */
    static function CustomCategoryComparision($a, $b)
    {
        $al = getCategoryValue(strtolower($a->name));
        $bl = getCategoryValue(strtolower($b->name));
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }
}

function sortCategories($categoryArray){
    usort($categories, array("CategoryComparisionObj", "CustomCategoryComparision"));
}

?>