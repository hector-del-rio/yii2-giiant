<?php

namespace schmunk42\giiant\crud\providers;

class DateTimeProvider extends \schmunk42\giiant\base\Provider
{
    public function activeField($attribute)
    {
        // TODO: internationalization

        if (!isset($this->generator->getTableSchema()->columns[$attribute])) {
            return null;
        }

        $column = $this->generator->getTableSchema()->columns[$attribute];

        if ($column->type == "datetime") {
            $this->generator->requires[] = 'zhuravljov/yii2-datetime-widgets';

            return <<<EOS
\$form->field(\$model, '{$column->name}')->widget(\zhuravljov\widgets\DateTimePicker::className(), [
    'options' => ['class' => 'form-control'],
    'clientOptions' => [
        'autoclose' => true,
        'todayHighlight' => true,
        // Tip: you can switch comments if you only want to display date
        'format' => 'dd.mm.yyyy hh.ii',
        // 'format' => 'dd.mm.yyyy',
    ],
])
EOS;
        }
    return null;
    }
} 
