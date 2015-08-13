<?php

namespace schmunk42\giiant\crud\providers;

use yii\db\Schema;

class DateTimeProvider extends \schmunk42\giiant\base\Provider
{
    private $columns;
    private $columnDateFrom;
    private $columnDateTo;

    public function activeField($attribute)
    {
        if (!isset($this->columns)) {
            // first call to this provider. Initialize.
            $this->columns = $this->generator->getTableSchema()->columns;
            $columnNames = array_keys($this->columns);
            $regexFrom = "/{$this->generator->dateFromSuffix}$/i";
            $regexTo = "/{$this->generator->dateToSuffix}$/i";
            $columnFrom = preg_grep($regexFrom, $columnNames);
            $columnTo = preg_grep($regexTo, $columnNames);

            if (!empty($columnFrom) and !empty($columnTo)) {
                $this->columnDateFrom = array_pop($columnFrom);
                $this->columnDateTo = array_pop($columnTo);
            }
        }

        if (!isset($this->columns[$attribute])) {
            return null;
        }

        $column = $this->columns[$attribute];

        switch ($column->type) {
            case Schema::TYPE_DATE:
            case Schema::TYPE_TIME:
            case Schema::TYPE_DATETIME:
            case Schema::TYPE_TIMESTAMP:
                if (isset($this->columnDateFrom, $this->columnDateTo) and $column->name == $this->columnDateFrom) {
                    $msg = 'kartik-v/yii2-date-range';

                    $widget = "\$form->field(\$model, '{$column->name}')->widget(kartik\\daterange\\DateRangePicker::className(), [
    'language' => Yii::\$app->language,
    'hideInput' => true,
    'presetDropdown' => true,
//    'convertFormat' => true,
    'pluginOptions'=>[
//        {$this->getDateFormat($column)}
        'separator'=> '  &rarr;  ',
        'opens'=>'left'
    ]
])";
                } elseif ($column->name != $this->columnDateTo) {
                    $msg = '2amigos/yii2-date-time-picker-widget';

                    $widget = "\$form->field(\$model, '{$column->name}')->widget(dosamigos\\datetimepicker\\DateTimePicker::className(), [
    'options' => ['class' => 'form-control'],
    'pickButtonIcon' => 'glyphicon glyphicon-calendar',
    'clientOptions' => [
        // more options @ http://www.malot.fr/bootstrap-datetimepicker
        'autoclose' => true,
        'todayHighlight' => true,
        'weekStart' => {$this->generator->weekStart},
        {$this->getDateFormat($column)}
    ],
])";
                } else {
                    return null;
                }

                if (!in_array($msg, $this->generator->requires)) {
                    $this->generator->requires[] = $msg;
                }

                return $widget;
            default:
                return null;
        }
    }

    protected function getDateFormat($column)
    {
        if ($column->type == "datetime") {
            return "'format' => '{$this->generator->dateFormat} {$this->generator->timeFormat}', // or 'dd.mm.yyyy' to display only the date";
        } else {
            return "'format' => '{$this->generator->dateFormat}',";
        }
    }
} 
