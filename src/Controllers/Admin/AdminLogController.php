<?php

namespace Mungurs\AdminLog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Arbory\Base\Admin\Form;
use Arbory\Base\Admin\Grid;
use Arbory\Base\Admin\Traits\Crudify;
use Illuminate\Database\Eloquent\Model;
use Arbory\Base\Admin\Form\Fields\Hidden;
use Mungurs\AdminLog\Models\AdminLog;
use Arbory\Base\Admin\Form\Fields\Text;

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
    protected function form( Model $model )
    {
        $form = $this->module()->form( $model, function( Form $form )
        {
            $form->addField( new Hidden( 'id' ) );
            $form->addField( new Text( 'user_name' ) );
            $form->addField( new Text( 'request_uri' ) );
            $form->addField( new Text( 'ip' ) );
            $form->addField( new Text( 'created_at' ) );
        } );

        return $form;
    }

    /**
     * @return Grid
     */
    public function grid()
    {
        return $this->module()->grid( $this->resource(), function ( Grid $grid )
        {
            $grid->column( 'user_name' );
            $grid->column( 'request_uri' );
            $grid->column( 'ip' );
            $grid->column( 'created_at' );
        } )->tools(['search']);
    }
}
