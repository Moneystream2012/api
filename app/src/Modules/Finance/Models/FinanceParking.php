<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 14.08.17
 */

declare(strict_types=1);

namespace App\Modules\Finance\Models;

use App\Components\BaseModel;
use App\Modules\Finance\Components\FinanceModelFactory;
use App\Modules\Finance\Models\ParkingStatistic\FinanceCountStatistic;
use App\Modules\Finance\Models\ParkingStatistic\FinanceDebtsStatistic;
use App\Modules\Finance\Models\ParkingStatistic\FinanceSumStatistic;
use App\Modules\Finance\Models\ParkingStatistic\FinanceUserStatistic;
use App\Modules\User\Components\UserModelFactory;
use App\Modules\User\Models\UserAuthAccess;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class FinanceParking
 * @package App\Modules\Finance\Model
 */
class FinanceParking extends \App\Modules\Database\FinanceParking
{
    public const TYPE_PENDING = 'pending';
    public const TYPE_ACTIVE = 'active';
    public const TYPE_CANCELED = 'canceled';
    public const TYPE_COMPLETED = 'completed';

    /**
     * @inheritdoc
     */
    public function rules() : array {
        return [
            [['typeId', 'amount'], 'required'],
            [['userId', 'typeId'], 'integer'],
            [['amount', 'rate'], 'number'],
            [['status'], 'default', 'value' => static::TYPE_ACTIVE],
            [['status'], 'string'],
            [['typeId'], 'exist',
                'skipOnError' => true,
                'targetClass' => FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE),
                'targetAttribute' => ['typeId' => 'id']
            ],
            [['status'], 'in' , 'range' => static::getStatusRange()],
            [['userId', 'typeId', 'amount', 'rate', 'status'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors[ 'timestamp' ] = [
            'class' => TimestampBehavior::class,
            'value' => function () {

                return Yii::$app->formatter->asDatetime( time(), BaseModel::DB_DATE_TIME_FORMAT );
            },
            'attributes' => [
                BaseActiveRecord::EVENT_BEFORE_INSERT => 'createdAt',
                BaseActiveRecord::EVENT_BEFORE_UPDATE => false,
            ]
        ];

        $behaviors['blameable'] = [
            'class' => BlameableBehavior::class,
            'createdByAttribute' => 'userId',
            'updatedByAttribute' => false,
        ];

        return $behaviors;
    }

    public function beforeSave($insert): bool
    {

        if ($insert == true) {
            $this->rate = $this->type->rate;
            $this->returnedAmount = $this->amount * $this->type->rate / 100;

        }

        $this->endDate = $this->getEndDate();
        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */
    public function isExpired(): bool {

        $now = time();

        return ($now > (int)Yii::$app->formatter->asTimestamp($this->endDate))
            && $this->status === static::TYPE_ACTIVE;
    }

    private function getEndDate(): string
    {
        $endDate = empty($this->createdAt)
            ? new \DateTime()
            : new \DateTime($this->createdAt);

        $endDate->add(new \DateInterval('PT' . $this->type->period . 'S'));

        $timestamp = $endDate->getTimestamp();
        return Yii::$app->formatter->asDatetime($timestamp, parent::DB_DATE_TIME_FORMAT);
    }

    /**
     * @inheritdoc
     */
	public function fields(): array {
        return [
            'id',
            'userId',
            'typeId',
            'amount',
            'rate',
            'status',
            'createdAt',
            'type'
        ];
	}

	public static function getStatusRange(): array {
        return [
            self::TYPE_PENDING,
            self::TYPE_ACTIVE,
            self::TYPE_CANCELED,
            self::TYPE_COMPLETED,
        ];
	}

	/**
	 * @return Query\FinanceParking
	 */
	public static function find(): Query\FinanceParking {
		return new Query\FinanceParking(get_called_class());
	}

    /**
     * Get parking list ownedBy userId(s).
     *
     * @param array $userIds
     * @param string|array $status
     *
     * @return ActiveQuery
     */
	public static function getListByUserIdsNewestFirst(array $userIds, $status = self::TYPE_ACTIVE): ActiveQuery {
        return self::find()
            ->ownedBy($userIds)
            ->whereStatus($status)
            ->orderBy(['createdAt' => SORT_DESC]);
	}

    /**
     * Get parking list for make payouts.
     *
     * @param int $limit
     * @param string|array $status
     *
     * @return array
     */
	public static function getListByStatus($limit = 1, $status = self::TYPE_ACTIVE): array {
        return self::find()
            ->selectDistinctUserId()
            ->joinWith('type')
            ->whereStatus($status)
            ->whereOrderedElapsed()
            ->limit($limit)
            ->asArray()
            ->all();
	}

    /**
     * @return array
     */
	public function findExpiredParkings(int $max = 0): array {
	    $types = FinanceModelFactory::getClass(FinanceModelFactory::PARKING_TYPE)::find()
            ->select(['id', 'period'])
            ->asArray()
            ->all();

	    $search = [];
	    foreach ($types as $type) {
	        if (empty($type['period'])) {
	            continue;
            }
            $search[] = [
                'typeId' => $type['id'],
                'date' => Yii::$app->formatter->asDatetime((time() - $type['period']), static::DB_DATE_TIME_FORMAT)
            ];
        }

	    $result = static::find()
            ->selectDistinctUserId()
            ->filterStatus([static::TYPE_ACTIVE])
            ->search($search)
            ->asArray()
            ->limit(empty($max) ? null : $max)
            ->all();

	    Yii::info($result);

	    return $result;
    }

    /**
     * @param array $parkings
     * @return array
     */
    public function getUserAddresses(array $parkings): array {

        //TODO: request to RabbitMQ
        $userIds = ArrayHelper::getColumn($parkings, 'userId');

        $users = UserAuthAccess::find()
            ->select(['userId', 'address'])
            ->where(['userId' => array_unique($userIds)])
            ->asArray()
            ->all();

        return ArrayHelper::map($users, 'userId', 'address');
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function completeParkings(array $ids): bool {
	    $result = true;

	    $parkings = static::find()->where(['id' => $ids])->all();

	    foreach ($parkings as $parking) {
	        $parking->status = static::TYPE_COMPLETED;

	        if (!$parking->save()) {
	            Yii::info('Parking #' . $parking->id . ' not saved');
	            Yii::info($parking->errors);
	            break;
            }

            Yii::info('Parking #' . $parking->id . ' saved');
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function getFinanceCountStatistic(): array
    {
        $model = new FinanceCountStatistic();
        return $model->getStatistic();
    }

    /**
     * @return array
     */
    public static function getFinanceSumStatistic(): array
    {
        $model = new FinanceSumStatistic();
        return $model->getStatistic();
    }

    /**
     * @return array
     */
    public static function getFinanceUserStatistic(): array
    {
        $model = new FinanceUserStatistic();
        return $model->getStatistic();
    }

    /**
     * @return array
     */
    public static function getFinanceDebsStatistic(): array
    {
        $model = new FinanceDebtsStatistic();
        return $model->getStatistic();
    }


    /**
     * @param array $ids
     * @return bool
     */
    public function cancelParkings(array $ids): bool {
        $result = true;

        $parkings = static::find()->where(['id' => $ids])->all();

        foreach ($parkings as $parking) {
            $parking->status = static::TYPE_CANCELED;

            if (!$parking->save()) {
                Yii::info('Parking #' . $parking->id . ' not saved');
                Yii::info($parking->errors);

                $result = false;
                break;
            }
        }

        return $result;
    }

    /**
     * @param array $addresses
     * @return array
     */
    public function getParkingsByAddresses(array $addresses): array {

        Yii::info('Search active parkings for addressess:');
        Yii::info($addresses);

        $result = [];

        if(empty($addresses)) {
            return $result;
        }

        $users = UserModelFactory::getClass(UserModelFactory::USER_AUTH_ACCESS)::find()
            ->select(['userId', 'address'])
            ->where(['address' => $addresses])
            ->asArray()
            ->all();

        Yii::info($users);

        if(empty($users)) {
            return $result;
        }

        $userIds = array_unique(ArrayHelper::getColumn($users, 'userId'));
        $usersAddressesByIds = ArrayHelper::map($users, 'userId', 'address');

        Yii::info('User ids and ids by address');
        Yii::info($userIds);
        Yii::info($usersAddressesByIds);

        $parkings = static::find()
            ->where(['userId' => $userIds])
            ->filterStatus([static::TYPE_ACTIVE, static::TYPE_PENDING])
            ->orderBy(['createdAt' => SORT_DESC])
            ->asArray()
            ->all();

        Yii::info('Found parkings:');
        Yii::info($parkings);

        foreach ($parkings as $parking) {
            $address = $usersAddressesByIds[$parking['userId']];

            if (empty($result[$address])) {
                $result[$address] = [];
            }

            $result[$address][] = $parking;
        }

        return $result;
    }
}
