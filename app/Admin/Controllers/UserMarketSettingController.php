<?php


namespace App\Admin\Controllers;


use App\Models\MarketPlace;
use App\Models\User;
use App\Models\UserMarketplaceSetting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserMarketSettingController  extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Настройки маркетплейсов';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserMarketplaceSetting());
        $grid->column('user_id', 'Клиент')->display(function($userId) {
            return User::find($userId)->name;
        });
        $grid->column('marketplace_id', 'Маркелплейс')->display(function($marketPlaceId) {
            return MarketPlace::find($marketPlaceId)->name;
        });
        $grid->column('client_id');
        $grid->column('client_secret');
        $grid->column('api');

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
        $show = new Show(UserMarketplaceSetting::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserMarketplaceSetting());
        $form->select('user_id', 'Выберите Клиент')->options(User::all()->pluck('name', 'id'));
        $form->select('marketplace_id', 'Выберите Маркетплейс')->options(MarketPlace::all()->pluck('name', 'id'));
        $form->text('client_id', __('Username'));
        $form->text('client_secret', __('Password/Secret key'));
        $form->text('api', __('API URL'));
        $form->text('access_token', __('access_token'));
        $form->text('refresh_token', __('refresh_token'));
        $form->text('token_type', __('token_type'));
        $form->text('expires_date', __('expires_date'));
        return $form;
    }
}
