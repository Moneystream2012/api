<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Support\Models;

use App\{
	Components\BaseModel,
	Modules\Support\Components\SupportModelFactory
};

/**
 * Class SupportMessageAttachment
 * @package App\Modules\Support\Model
 *
 * @property int $id
 * @property int $messageId
 * @property string $type
 * @property string $filename
 * @property string $createdAt
 *
 * @property SupportMessage $message
 */
class SupportMessageAttachment extends BaseModel
{
    public const TYPE_FILE = 'file';
    public const TYPE_IMAGE = 'image';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%support_message_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['messageId', 'type', 'filename'], 'required'],
            [['messageId'], 'integer'],
            [['type'], 'in', 'range' => $this->getFileTypes()],
            [['filename'], 'string', 'min' => 1, 'max' => 200],
            [['createdAt'],'date', 'format' => parent::DB_DATE_TIME_FORMAT],
            [['messageId'], 'exist', 'skipOnError' => true, 'targetClass' => SupportModelFactory::getClass(SupportModelFactory::MESSAGE), 'targetAttribute' => ['messageId' => 'id']],
            [['messageId', 'type', 'filename'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'messageId',
            'type',
            'filename',
            'createdAt',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'messageId' => 'Message ID',
            'type' => 'Type',
            'filename' => 'Filename',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage(): \yii\db\ActiveQuery
    {
        return $this->hasOne(SupportModelFactory::getClass(SupportModelFactory::MESSAGE), ['id' => 'messageId']);
    }

    public function getFileTypes(): array {
        return [
            static::TYPE_FILE,
            static::TYPE_IMAGE,
        ];
    }
}
