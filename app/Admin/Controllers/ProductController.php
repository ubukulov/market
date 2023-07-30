<?php


namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController  extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Список клиентов';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());
        $grid->model()->orderBy('id');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Наименование'));
        $grid->column('category_id', __('Категория'))->display(function($categoryId) {
            return Category::find($categoryId)->name;
        })->sortable();
        $grid->column('article', __('Артикуль'));
        $grid->column('price', __('Цена'));
        $grid->column('created_at', 'Дата')->display(function ($created_at) {
            return date('d.m.Y H:i', strtotime($created_at));
        });

        $grid->disableExport();
        $grid->disableColumnSelector();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $product = Product::with('thumb')->whereId($id)->first();
        $show = new Show($product);
        $show->field('name', 'Наименование');
        $show->category_id('Категория')->as(function($categoryId){
            return Category::find($categoryId)->name;
        });
        $show->field('article', 'Артикуль');
        $show->field('price', 'Цена');
        $show->field('quantity', 'Количество');
        if(isset($product->thumb[0])) {
            $product->thumb = $product->thumb[0]->path;
            $show->thumb('Аватар')->image();
        } else {
            $product->thumb = url("/uploads/products/" . $product->images[0]->path);
            $show->thumb('Аватар')->image();
        }
        $show->isnew('Новинка')->as(function($item){
            return ($item == 1) ? "Да" : "Нет";
        });
        $show->ishit('Хиты продаж')->as(function($item){
            return ($item == 1) ? "Да" : "Нет";
        });
        $show->ispromo('Промо')->as(function($item){
            return ($item == 1) ? "Да" : "Нет";
        });
        $show->active('Опубликован')->as(function($item){
            return ($item == 1) ? "Да" : "Нет";
        });
        $show->field('created_at', 'Дата');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->text('name', 'Наименование');
        $form->select('category_id', 'Выберите категория')->options(Category::where('level', '>', 1)->orderBy('id')->pluck('name', 'id'));
        $form->text('article', 'Артикуль');
        $form->text('price1', 'Дилерская цена');
        $form->text('price2', 'Рекомендованная цена');
        $form->text('quantity', 'Количество');
        $form->ckeditor('description', 'Описание');
        $form->radio('isnew', 'Новинка')->options([0 => 'Нет', 1 => 'Да'])->default(0);
        $form->radio('ishit', 'Хиты продаж')->options([0 => 'Нет', 1 => 'Да'])->default(0);
        $form->radio('ispromo', 'Промо')->options([0 => 'Нет', 1 => 'Да'])->default(0);
        $form->radio('active', 'Опубликован')->options([0 => 'Нет', 1 => 'Да'])->default(1);
        $form->multipleFile('images','Картинки')->pathColumn('path')->removable();

        return $form;
    }
}
