<?php


namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\User\MarketSetting;

class UserController  extends AdminController
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
        $grid = new Grid(new User());
        $grid->column('name', __('ФИО'));
        $grid->column('email', __('Почта'));
        $grid->column('phone', __('Телефон'));
        $grid->column('bin', __('БИН'));
        $grid->column('created_at', 'Дата регистрации')->display(function ($created_at) {
            return date('d.m.Y H:i', strtotime($created_at));
        });

        /*$grid->actions(function ($actions) {
            $actions->add(new MarketSetting());
        });*/

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
        $show = new Show(User::findOrFail($id));
        $show->field('name', 'ФИО');
        $show->field('email', 'Почта');
        $show->field('phone', 'Телефон');
        $show->field('bin', 'БИН');
        $show->field('legal_address', 'Юридический адрес');
        $show->field('bik', 'БИК');
        $show->field('bank', 'Банк');
        $show->field('iik', 'ИИК');
        $show->field('full_name_director', 'ФИО директора');
        $show->field('created_at', 'Дата регистрации');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', 'ФИО');
        $form->text('email', 'Почта');
        $form->text('phone', 'Телефон');
        $form->text('bin', 'БИН');
        $form->text('legal_address', 'Юридический адрес');
        $form->text('bik', 'БИК');
        $form->text('bank', 'Банк');
        $form->text('iik', 'ИИК');
        $form->text('full_name_director', 'ФИО директора');

        return $form;
    }
}
