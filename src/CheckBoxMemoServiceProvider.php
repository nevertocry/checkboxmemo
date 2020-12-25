<?php

namespace Encore\CheckBoxMemo;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;

class CheckBoxMemoServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(CheckBoxMemoExtension $extension)
    {
        if (! CheckBoxMemoExtension::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-checkboxmemo');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/checkboxmemo')],
                'checkboxmemo'
            );
        }

        Admin::booting(function () {
            Form::extend('checkboxMemo', CheckBoxMemo::class);
        });
    }
}
