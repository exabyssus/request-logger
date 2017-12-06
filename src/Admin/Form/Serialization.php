<?php

namespace Mungurs\AdminLog\Admin\Form;

use Arbory\Base\Admin\Form\Fields\AbstractField;
use Arbory\Base\Html\Elements\Element;
use Arbory\Base\Html\Html;
use Illuminate\Http\Request;


/**
 * Class Text
 * @package Arbory\Base\Admin\Form\Fields
 */
class Serialization extends AbstractField
{
    /**
     * @return Element
     */
    public function render()
    {
        return ( new SerializationRenderer( $this ) )->render();
    }
}
