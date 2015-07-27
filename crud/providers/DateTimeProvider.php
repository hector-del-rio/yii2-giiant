<?php

namespace schmunk42\giiant\crud\providers;

use yii\db\Schema;

class DateTimeProvider extends \schmunk42\giiant\base\Provider
{
    public function activeField($attribute)
    {
        // TODO: internationalization

        if (!isset($this->generator->getTableSchema()->columns[$attribute])) {
            return null;
        }

        $column = $this->generator->getTableSchema()->columns[$attribute];

        switch ($column->type) {
            case Schema::TYPE_DATE:
            case Schema::TYPE_TIME:
            case Schema::TYPE_DATETIME:
            case Schema::TYPE_TIMESTAMP:
                $this->generator->requires[] = '2amigos/yii2-date-time-picker-widget';

                return "\$form->field(\$model, '{$column->name}')->widget(dosamigos\\datetimepicker\\DateTimePicker::className(), [
    'options' => ['class' => 'form-control'],
    'pickButtonIcon' => 'glyphicon glyphicon-calendar',
    'clientOptions' => [
        // more options @ http://bootstrap-datepicker.readthedocs.org/en/release/options.html
        'autoclose' => true,
        'todayHighlight' => true,
        'weekStart' => 1,
        " . ($column->type == "datetime" ?
                "'format' => 'dd.mm.yyyy hh.ii', // or 'dd.mm.yyyy' to display only the date" :
                "'format' => 'dd.mm.yyyy',"
            ) . "
    ],
])
";
            default:
                return null;
        }
    }
} 
