<?php

namespace Mungurs\AdminLog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Arbory\Base\Admin\Form;
use Arbory\Base\Admin\Grid;
use Arbory\Base\Admin\Traits\Crudify;
use Illuminate\Database\Eloquent\Model;
use Arbory\Base\Admin\Form\Fields\Hidden;
use Mungurs\AdminLog\Models\AdminLog;

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
            $grid->column( 'tokenId' );
            $grid->column( 'status' );
        } )->tools(['search']);
    }
}
