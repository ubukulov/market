<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'categories';
    protected static $left = 0;
    protected static $right = 0;
    protected static $id = 0;

    protected $fillable = [
        'foreign_id', 'name', 'slug', 'margin', 'left', 'right', 'level'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

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
        return Category::whereRaw("categories.left > " . $this->left . " AND categories.right < " . $this->right . ' AND categories.level=' . $this->level . ' +1')
            ->orderBy('id')
            ->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
