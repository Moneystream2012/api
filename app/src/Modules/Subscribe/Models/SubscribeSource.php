<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Models;

/**
 * Class SubscribeSource
 * @package App\Modules\Subscribe\Model
 */
class SubscribeSource extends \App\Modules\Database\SubscribeSource
{

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'min' => 3, 'max' => 100],
            [['userId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
