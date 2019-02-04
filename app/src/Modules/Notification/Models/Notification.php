<?php
/**
 * @author Vladyslav Zaichuk <vzaichuk@minexsystems.com>
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Notification\Models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\BaseActiveRecord;
use App\Behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Notification
 * @package App\Modules\Notification\Model
 *
 * @property int $_id
 * @property string $title
 * @property string $content
 * @property string $type
 * @property array $postedFor
 * @property array $seenBy
 * @property int $authorId
 * @property int $moderatorId
 * @property string $createdAt
 * @property string $updatedAt
 */
class Notification extends \yii\mongodb\ActiveRecord
{
    public const TYPE_INFO = 'info';
    public const TYPE_WARN = 'warn';
    public const TYPE_ERROR = 'error';

    /**
     * @inheritdoc
     */
    public function attributes(): array
    {
        return [
            '_id',
            'title',
            'content',
            'type',
            'postedFor',
            'seenBy',
            'authorId',
            'moderatorId',
            'createdAt',
            'updatedAt',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['title', 'content'], 'required'],
            [['type'], 'default', 'value' => static::TYPE_INFO],
            ['title', 'string', 'min' => 3, 'max' => 255],
            ['content', 'string', 'min' => 1, 'max' => 65535],
            ['type', 'in' , 'range' => $this->getTypeRange()],
            [['postedFor','seenBy'], 'each', 'rule' => ['integer']],
            [['authorId', 'moderatorId'], 'integer'],
            [['createdAt', 'updatedAt'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['title', 'content', 'type', 'postedFor', 'authorId', 'moderatorId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            '_id',
            'title',
            'content',
            'type',
            'postedFor',
            'authorId',
            'moderatorId',
            'createdAt',
            'updatedAt',
            'seenBy',
            'seen'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            '_id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'type' => 'Type',
            'postedFor' => 'Posted For',
            'seenBy' => 'Seen By',
            'authorId' => 'Author ID',
            'moderatorId' => 'Moderator ID',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    const DB_DATE_TIME_FORMAT = 'yyyy-MM-dd HH:mm:ss';

    const CREATE = 'createdAt';

    const LAST_UPDATE = 'updatedAt';

    const CREATED_BY = 'authorId';

    const UPDATED_BY = 'moderatorId';

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $timestampAttributes = [
            'createdAtAttribute' => static::CREATE,
            'updatedAtAttribute' => static::LAST_UPDATE,
        ];

        $behaviors[ 'timestamp' ] = [
            'class' => TimestampBehavior::class,
            'value' => function () {
                return Yii::$app->formatter->asDatetime( time(), self::DB_DATE_TIME_FORMAT );
            },
            'attributes' => [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $timestampAttributes,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $timestampAttributes[ 'updatedAtAttribute' ],
            ]
        ];

        $behaviors['blameable'] = [
            //TODO: when auth will work change to original behavior
            'class' => BlameableBehavior::class,
            'createdByAttribute' => static::CREATED_BY,
            'updatedByAttribute' => static::UPDATED_BY,
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    public function getTypeRange(): array
    {
        return [
            self::TYPE_INFO,
            self::TYPE_WARN,
            self::TYPE_ERROR,
        ];
    }

    public function getSeen(): bool {
        return in_array(self::getUserId(), $this->seenBy);
    }

    public static function find(): Query\Notification {

        return new Query\Notification(get_called_class());
	}

    /**
     * @inheritdoc
     */
    public function beforeSave($insert): bool {

        if (!isset($this->seenBy) || !is_array($this->seenBy)) {
            $this->seenBy = [];
        }

        if (!isset($this->postedFor) || !is_array($this->postedFor)) {
            $this->postedFor = [];
        }

        return parent::beforeSave($insert);
    }

    public static function updateSeen($ids): void {

        $result = static::updateAll(
            [
                '$push'  => ['seenBy' => self::getUserId()]
            ],
            [
                '_id'    => ['$in' => $ids],
                'seenBy' => ['$nin' => [self::getUserId()]],
            ]

        );
    }

    /**
     * @return int
     */
    public static function getUserId(): int {

        return Yii::$app->user->id;
    }
}
