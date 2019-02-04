<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Models;

class SubscriberGroup extends \App\Modules\Database\SubscriberGroup
{

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'min' => 3, 'max' => 100],
            [['id'], 'unique'],
        ];
    }
}
