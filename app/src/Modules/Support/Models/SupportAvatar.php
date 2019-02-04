<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Support\Models;

use App\{
	Components\BaseModel,
	Modules\Support\Components\SupportQueryFactory
};
use yii\db\ActiveQuery;

/**
 * Class SupportAvatar
 * @package App\Modules\Support\Model
 *
 * @property int $id
 * @property int $userId
 * @property string $filename
 */
class SupportAvatar extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%support_avatar}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['userId', 'filename'], 'required'],
            [['userId'], 'integer'],
            [['filename'], 'string', 'min' => 1, 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'userId',
            'filename',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'filename' => 'Filename',
        ];
    }

    /**
     * @inheritdoc
	 */
	public static function find(): ActiveQuery
	{
		return SupportQueryFactory::create(SupportQueryFactory::AVATAR, get_called_class());
	}
}
