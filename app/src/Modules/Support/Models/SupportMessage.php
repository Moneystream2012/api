<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Support\Models;

use App\{
	Components\BaseModel, Modules\Support\Components\SupportModelFactory, Modules\Support\Components\SupportQueryFactory
};
use yii\db\ActiveQuery;

/**
 * Class SupportMessage
 * @package App\Modules\Support\Model
 *
 * @property int $id
 * @property int $senderId
 * @property int $receiverId
 * @property string $content
 * @property string $createdAt
 * @property int $seen
 *
 * @property SupportMessageAttachment[] $supportMessageAttachments
 */
class SupportMessage extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%support_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['senderId', 'receiverId', 'content', 'seen'], 'required'],
            [['senderId', 'receiverId'], 'integer'],
            [['seen'], 'boolean'],
            [['content'], 'string'],
            [['createdAt'],'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['senderId', 'receiverId', 'content', 'seen'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'senderId',
            'receiverId',
            'content',
            'createdAt',
            'seen',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'senderId' => 'Sender ID',
            'receiverId' => 'Receiver ID',
            'content' => 'Content',
            'createdAt' => 'Created At',
            'seen' => 'Seen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupportMessageAttachments(): \yii\db\ActiveQuery
    {
        return $this->hasMany(SupportModelFactory::getClass(SupportModelFactory::MESSAGE_ATTACHMENT), ['messageId' => 'id']);
    }

    /**
     * @inheritdoc
	 */
    public static function find(): ActiveQuery
	{
		return SupportQueryFactory::create(SupportQueryFactory::MESSAGE, get_called_class());
	}
}
