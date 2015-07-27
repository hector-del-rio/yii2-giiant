<?php

namespace schmunk42\giiant\crud\providers;

class DateProvider extends \schmunk42\giiant\base\Provider
{
    public function activeField($attribute)
    {
        // TODO: internationalization

        if (!isset($this->generator->getTableSchema()->columns[$attribute])) {
            return null;
        }

	    $column = $this->generator->getTableSchema()->columns[$attribute];

        if ($column->type == "date") {
            $this->generator->requires[] = 'zhuravljov/yii2-datetime-widgets';

            return <<<EOS
\$form->field(\$model, '{$column->name}')->widget(\zhuravljov\widgets\DatePicker::className(), [
    'options' => ['class' => 'form-control'],
    'clientOptions' => [
        'autoclose' => true,
        'todayHighlight' => true,
        'format' => 'yyyy-mm-dd',
    ],
])
EOS;
        }

        return null;
    }
} 
