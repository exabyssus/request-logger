<?php

namespace Mungurs\AdminLog\Admin\Form;

use Arbory\Base\Admin\Form\Fields\Renderer\BaseRenderer;
use Arbory\Base\Html\Elements\Element;
use Arbory\Base\Html\Elements\Inputs\AbstractInputField;
use Arbory\Base\Html\Html;

/**
 * Class InputFieldRenderer
 * @package Arbory\Base\Admin\Form\Fields\Renderer
 */
class SerializationRenderer extends BaseRenderer
{
    /**
     * @return AbstractInputField
     */
    protected function getInput()
    {
        $content = unserialize($this->field->getValue());
        return Html::div()->append('<pre><code>' . print_r($content, true) . '</code></pre>');
    }

    /**
     * @return Element
     */
    public function render()
    {
        $input = $this->getInput();
        $label = Html::label( $this->field->getLabel() );

        return $this->buildField( $label, $input );
    }
}
