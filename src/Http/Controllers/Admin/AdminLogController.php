<?php

namespace Arbory\AdminLog\Http\Controllers\Admin;

use Arbory\AdminLog\Admin\Form\Serialization;
use App\Http\Controllers\Controller;
use Arbory\Base\Admin\Form;
use Arbory\Base\Admin\Grid;
use Arbory\Base\Admin\Traits\Crudify;
use Illuminate\Database\Eloquent\Model;
use Arbory\AdminLog\Models\AdminLog;
use Arbory\Base\Admin\Form\Fields\Text;
use Illuminate\Http\Request;

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

            $form->addField(new Text('created_at'))
                ->setLabel(trans('admin-log::common.created_at'));

            $form->addField(new Text('user_name'))
                ->setLabel(trans('admin-log::common.user_name'));

            $form->addField(new Text('user_agent'))
                ->setLabel(trans('admin-log::common.user_agent'));

            $form->addField(new Text('ip'))
                ->setLabel(trans('admin-log::common.ip_address'));

            $form->addField(new Text('ips'))
                ->setLabel(trans('admin-log::common.ip_addresses'));

            $form->addField(new Text('request_method'))
                ->setLabel(trans('admin-log::common.request_method'));

            $form->addField(new Text('request_uri'))
                ->setLabel(trans('admin-log::common.request_uri'));

            $form->addField(new Text('http_content_type'))
                ->setLabel(trans('admin-log::common.http_content_type'));

            $form->addField(new Text('http_referer'))
                ->setLabel(trans('admin-log::common.http_referer'));

            $form->addField(new Serialization('content'))
                ->setLabel(trans('admin-log::common.content'));

            $form->addField(new Serialization('session'))
                ->setLabel(trans('admin-log::common.session'));

            $form->addField(new Serialization('http_cookie'))
                ->setLabel(trans('admin-log::common.http_cookie'));
        });

        return $form;
    }

    /**
     * @return Grid
     */
    public function grid()
    {
        $grid = $this->module()->grid($this->resource(), function (Grid $grid) {

            $grid->column('user_name', trans('admin-log::common.user_name'))
                ->sortable();

            $grid->column('request_method', trans('admin-log::common.request_method'))
                ->sortable();

            $grid->column('request_uri', trans('admin-log::common.request_uri'))
                ->sortable();

            $grid->column('ip', trans('admin-log::common.ip_address'))
                ->sortable();

            $grid->column('created_at', trans('admin-log::common.created_at'))
                ->sortable();

        });

        $grid->filter(function (Grid\Filter $filter) {
            $filter->setPerPage(30);
            if (!request()->has('_order_by')) {
                $filter->getQuery()->orderBy('created_at', 'desc');
            }
        });

        return $grid;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['ok']);
        }

        return $this->getAfterEditResponse($request);
    }
}
