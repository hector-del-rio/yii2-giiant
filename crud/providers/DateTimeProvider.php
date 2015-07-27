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

        if (stripos($column->type, 'date') !== false) {
            $this->generator->requires[] = 'zhuravljov/yii2-datetime-widgets';

            return "\$form->field(\$model, '{$column->name}')->widget(\\zhuravljov\\widgets\\DateTimePicker::className(), [
    'options' => ['class' => 'form-control'],
    'clientOptions' => [
        'autoclose' => true,
        'todayHighlight' => true,
        " . ($column->type == "datetime" ?
                "'format' => 'dd.mm.yyyy hh.ii', // or 'dd.mm.yyyy' to display only the date" :
                "'format' => 'dd.mm.yyyy',"
            ) . "
    ],
])
";
        }

        if ($column->type == "datetime") {

        }
    return null;
    }
} 
