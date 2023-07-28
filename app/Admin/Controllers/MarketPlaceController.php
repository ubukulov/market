<?php


namespace App\Admin\Controllers;


use App\Models\MarketPlace;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MarketPlaceController  extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Список маркетплейсов';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MarketPlace());
        $grid->column('name', __('Название'));
        $grid->column('logo', __('Логотип'))->image();

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
        $show = new Show(MarketPlace::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MarketPlace());

        $form->text('name', __('Название'));

        $form->image('logo', 'Логотип')->uniqueName();
        return $form;
    }
}
