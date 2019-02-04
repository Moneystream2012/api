<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Subscribe\Models;

use App\{
	Modules\Subscribe\Components\SubscribeModelFactory
};

/**
 * Class SubscribeMessage
 * @package App\Modules\Subscribe\Model
 */
class SubscribeMessage extends \App\Modules\Database\SubscribeMessage
{

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['title', 'content', 'groupId'], 'required'],
            [['title'], 'string', 'min' => 1, 'max' => 150],
            [['content'], 'string'],
            [['authorId', 'groupId'], 'integer'],
            [['createdAt'], 'date', 'format' => parent::DB_DATE_TIME_FORMAT],
	        [['groupId'], 'exist', 'skipOnError' => true, 'targetClass' => SubscribeModelFactory::getClass(SubscribeModelFactory::SUBSCRIBER_GROUP), 'targetAttribute' => ['groupId' => 'id']],
            [['title', 'content', 'authorId', 'groupId'], 'safe'],
        ];
    }
}
