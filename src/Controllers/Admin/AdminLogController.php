<?php

namespace Mungurs\AdminLog\Controllers\Admin;

use Mungurs\AdminLog\Admin\Form\Serialization;
use App\Http\Controllers\Controller;
use Arbory\Base\Admin\Form;
use Arbory\Base\Admin\Grid;
use Arbory\Base\Admin\Traits\Crudify;
use Illuminate\Database\Eloquent\Model;
use Arbory\Base\Admin\Form\Fields\Hidden;
use Mungurs\AdminLog\Models\AdminLog;
use Arbory\Base\Admin\Form\Fields\Text;
use Arbory\Base\Admin\Form\Fields\Textarea;

class AdminLogController extends Controller
{
    use Crudify;

    /**
     * @var string
     */
    protected $resource = AdminLog::class;

    /**
     * @param Model $model
     * @return Form
     */
    protected function form(Model $model)
    {
        $form = $this->module()->form($model, function (Form $form) {
            $form->addField(new Hidden('id'));
            $form->addField(new Text('created_at'));
            $form->addField(new Text('user_name'));
            $form->addField(new Text('user_agent'));
            $form->addField(new Text('ip'));
            $form->addField(new Text('ips'));
            $form->addField(new Text('request_method'));
            $form->addField(new Text('request_uri'));
            $form->addField(new Text('http_content_type'));
            $form->addField(new Text('http_referer'));
            $form->addField(new Serialization('session'));
            $form->addField(new Serialization('content'));
            $form->addField(new Serialization('http_cookie'));

        });

        return $form;
    }

    /**
     * @return Grid
     */
    public function grid()
    {
        return $this->module()->grid($this->resource(), function (Grid $grid) {
            $grid->column('created_at');
            $grid->column('user_name');
            $grid->column('request_uri');
            $grid->column('ip');
            $grid->column('created_at');
        })->tools(['search']);
    }
}
