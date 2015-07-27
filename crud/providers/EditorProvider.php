<?php
/**
 * Created by PhpStorm.
 * User: tobias
 * Date: 14.03.14
 * Time: 10:21
 */

namespace schmunk42\giiant\crud\providers;

use yii\db\ColumnSchema;
use yii\db\Schema;

class EditorProvider extends \schmunk42\giiant\base\Provider
{
    public function activeField($attribute)
    {
        if (!isset($this->generator->getTableSchema()->columns[$attribute])) {
            return null;
        }

        $column = $this->generator->getTableSchema()->columns[$attribute];

        switch ($column->type) {
            case Schema::TYPE_TEXT:
                $this->generator->requires[] = '2amigos/yii2-ckeditor-widget';

                return "\$form->field(\$model, '{$attribute}')->widget(
    \\dosamigos\\ckeditor\\CKEditor::className(),
    [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]
)";
            default:
                return null;
        }
    }
} 