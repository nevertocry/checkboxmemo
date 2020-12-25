<?php

namespace Encore\CheckBoxMemo;

use Encore\Admin\Form\Field;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class CheckBoxMemo extends Field\Select
{
    protected $canCheckAll = false;

    protected $view = 'laravel-admin-checkboxmemo::checkboxmemo';

    protected static $css = [
        '/vendor/laravel-admin/AdminLTE/plugins/iCheck/all.css',
    ];

    protected static $js = [
        '/vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js',
    ];

    protected $memos = [];

    public function fill($data)
    {
        $relations = Arr::get($data, $this->column);
        if (is_null($relations)) {
            $this->value = null;
        } else {
            $this->value = array_column($relations, 'id');
            $this->memos = collect($relations)->pluck('memo', 'id');
        }
    }


    /**
     * Set options.
     *
     * @param array|callable|string $options
     *
     * @return $this|mixed
     */
    public function options($options = [])
    {
        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        if (is_callable($options)) {
            $this->options = $options;
        } else {
            $this->options = (array)$options;
        }
        return $this;
    }

    /**
     * Add a checkbox above this component, so you can select all checkboxes by click on it.
     *
     * @return $this
     */
    public function canCheckAll()
    {
        $this->canCheckAll = true;

        return $this;
    }

    public function getPlaceholder()
    {
        return $this->placeholder ?: trans('admin.input') . ' ' . $this->label . trans('admin.memo');
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->script = "$('{$this->getElementClassSelector()}').iCheck({checkboxClass:'icheckbox_minimal-blue'});";

        $this->addVariables([
            'memos' => $this->memos,
            'canCheckAll' => $this->canCheckAll,
        ]);

        if ($this->canCheckAll) {
            $checkAllClass = uniqid('check-all-');

            $this->script .= <<<SCRIPT
$('.{$checkAllClass}').iCheck({checkboxClass:'icheckbox_minimal-blue'}).on('ifChanged', function () {
    if (this.checked) {
        $('{$this->getElementClassSelector()}').iCheck('check');
    } else {
        $('{$this->getElementClassSelector()}').iCheck('uncheck');
    }
})
SCRIPT;
            $this->addVariables(['checkAllClass' => $checkAllClass]);
        }

        return parent::render();
    }

    public function prepare($values)
    {
        $arr = [];
        foreach ($values as $k => $v) {
            if (isset($v['id'])) {
                $arr[] = ['id' => $k, 'memo' => $v['memo']];
            }
        }
        return $arr;
    }
}
