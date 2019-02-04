<?php
/**
 * @author Tarasenko Andrii
 * @date: 12.07.17
 */

declare(strict_types=1);

namespace App\Behaviors;

use yii\db\BaseActiveRecord;

/**
 * Class BlameableBehavior
 * @package App\Behaviors
 */
class BlameableBehavior extends \yii\behaviors\BlameableBehavior
{
    public $createdByAttribute = '';
    public $updatedByAttribute = '';

    public function init()
    {
        parent::init();

        if ($this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT][0] == '')
        {
            if ($this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT][1] == '') {
                unset($this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT]);
            } else {
                unset($this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT][0]);
            }
        } else {
            if ($this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT][1] == '') {
                unset($this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT][1]);
            }
        }

        if ($this->attributes[BaseActiveRecord::EVENT_BEFORE_UPDATE] == '') {
            unset($this->attributes[BaseActiveRecord::EVENT_BEFORE_UPDATE]);
        }
    }

    /**
     * @inheritdoc
     *
     * In case, when the [[value]] property is `null`, the value of `Yii::$app->user->id` will be used as the value.
     */
    protected function getValue( $event )
    {

        return 1;
    }

}
