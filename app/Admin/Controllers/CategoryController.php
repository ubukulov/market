<?php


namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Категории';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());
        $grid->model()->where('level', '>', 1);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Название  '));
        $grid->column('margin', __('Маржа (компании)'))->sortable();

        $grid->column('updated_at', __('Дата изменение'))->display(function ($updated_at) {
            return date('d.m.Y H:i', strtotime($updated_at));
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $form->text('name', __('Название'));
        $form->decimal('margin', __('Маржа (компании)'));

        $form->saved(function (Form $form) {
            $margin = $form->model()->margin;
            if(!empty($margin)) {
                $category_id = $form->model()->id;

                DB::update("UPDATE products SET price=price2+ROUND(((price2*$margin)/100)) WHERE category_id=$category_id");
            }
        });

        return $form;
    }
}
