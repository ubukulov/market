<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected static $left = 0;
    protected static $right = 0;
    protected static $id = 0;

    protected $fillable = [
        'foreign_id', 'name', 'left', 'right', 'level'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public static function getTree()
    {
        $categories = Category::all();
        $arrTrees = [];
        foreach($categories as $category) {
            if($category->level == 1) {
                $arrTrees[$category->id] = [
                    'name' => $category->name
                ];
                self::$left = $category->left;
                self::$right = $category->right;
                self::$id = $category->id;
            } else {
                $arrTrees[self::$id]['items'][] = [
                    'name' => $category->name,
                    'id' => $category->id,
                ];
            }
        }

        return $arrTrees;
    }

    public function getItems()
    {
        return Category::whereRaw("categories.left > " . $this->left . " AND categories.right < " . $this->right . ' AND categories.level=' . $this->level . ' +1')->get();
    }
}
