<?php

namespace App\Admin\Actions\User;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class MarketSetting extends RowAction
{
    public $name = 'Настройки';

    public function href()
    {
        return route('admin.user-marketplace-settings.index', ['id' => $this->getKey()]);
    }
}
