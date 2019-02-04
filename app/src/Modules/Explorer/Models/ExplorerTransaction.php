<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 17.08.17
 */

declare(strict_types=1);

namespace App\Modules\Explorer\Models;

use yii\Helpers\ArrayHelper;

class ExplorerTransaction extends \App\Modules\Database\ExplorerTransaction
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['hash', 'block'], 'string', 'min' => 64],
        ];

        return ArrayHelper::merge(parent::rules(), $rules);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputs()
    {
        return $this->hasMany(ExplorerInput::className(), ['transactionId' => 'hash']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutputs()
    {
        return $this->hasMany(ExplorerOutput::className(), ['transactionId' => 'hash']);
    }
}
