<?php
/**
 * @author Tarasenko Andrii
 * @date: 12.07.17
 */

declare(strict_types=1);

namespace App\Components;

use Yii;
use App\Behaviors\BlameableBehavior;
use App\Interfaces\AppModel;
use yii\behaviors\TimestampBehavior;
use yii\db\{ActiveRecord,BaseActiveRecord};
use yii\helpers\ArrayHelper;

/**
 * Class BaseModel
 * @package App\Components
 */
class BaseModel extends ActiveRecord implements AppModel
{

    const DB_DATE_TIME_FORMAT = 'yyyy-MM-dd HH:mm:ss';

    const CREATE = 'createdAt';

    const LAST_UPDATE = 'updatedAt';

    const CREATED_BY = 'authorId';

    const UPDATED_BY = 'moderatorId';

    /**
     * @var array
     */
    protected $datetimeAttributes = [];

    /**
     * @return array
     */
    public function behaviors(): array
    {

        $behaviors = [];
        $replaceBehaviors = $this->replaceBehaviors();
        $timestampAttributes = $this->getTimestampBehaviorAttributes();
        $authorAttributes = $this->getAuthorAttributes();
        if ( !empty( $replaceBehaviors ) ) {
            $behaviors = $replaceBehaviors;

        }
        else {
            if ( !empty( $timestampAttributes ) ) {
                $behaviors[ 'timestamp' ] = [
                    'class' => TimestampBehavior::class,
                    'value' => function () {

                        return Yii::$app->formatter->asDatetime( time(), self::DB_DATE_TIME_FORMAT );
                    },
                ];
                if ( count( $timestampAttributes ) === 2 ) {
                    $behaviors[ 'timestamp' ][ 'attributes' ] = [
                        BaseActiveRecord::EVENT_BEFORE_INSERT => $timestampAttributes,
                        BaseActiveRecord::EVENT_BEFORE_UPDATE => $timestampAttributes[ 'updatedAtAttribute' ],
                    ];
                }
                else {
                    $behaviors[ 'timestamp' ][ 'attributes' ] = [
                        BaseActiveRecord::EVENT_BEFORE_INSERT => $timestampAttributes,
                    ];
                }
            }

            if (!empty( $authorAttributes)) {
                $behaviors['blameable'] = [
                    //TODO: when auth will work change to original behavior
                    'class' => BlameableBehavior::class,
                ];

                if (!empty( $authorAttributes['createdByAttribute'])) {
                    $behaviors['blameable']['createdByAttribute'] = $authorAttributes['createdByAttribute'];
                }
                if (!empty( $authorAttributes['updatedByAttribute'])) {
                    $behaviors['blameable']['updatedByAttribute'] = $authorAttributes['updatedByAttribute'];
                }
            }

            $behaviors = ArrayHelper::merge( $behaviors, $this->appendBehaviors() );

        }

        return $behaviors;
    }

    /**
     * Replace all behaviors of model by set here behaviors
     * @return array
     */
    protected function replaceBehaviors(): array
    {

        return [];
    }

    /**
     * Append behaviors with set in this method behaviors
     * Here we can overwrite existing behaviors
     * @return array
     */
    protected function appendBehaviors(): array
    {

        return [];
    }

    /**
     * Here we can set attributes, which will be updated automatically by behavior
     * @return array
     */
    protected function getTimestampBehaviorAttributes(): array
    {

        $result = [];
        $attributes = $this->attributes();
        if ( in_array( static::CREATE, $attributes ) ) {
            $result[ 'createdAtAttribute' ] = static::CREATE;
        }
        if ( in_array( static::LAST_UPDATE, $attributes ) ) {
            $result[ 'updatedAtAttribute' ] = static::LAST_UPDATE;
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getAuthorAttributes(): array
    {

        $result = [];
        $attributes = $this->attributes();
        if ( in_array( static::CREATED_BY, $attributes ) ) {
            $result[ 'createdByAttribute' ] = static::CREATED_BY;
        }
        if ( in_array( static::UPDATED_BY, $attributes ) ) {
            $result[ 'updatedByAttribute' ] = static::UPDATED_BY;
        }

        return $result;
    }

    /**
     * Populates the model with input data.
     *
     * This method provides a convenient shortcut for:
     *
     * ```php
     * if (isset($_POST['FormName'])) {
     *     $model->attributes = $_POST['FormName'];
     *     if ($model->save()) {
     *         // handle success
     *     }
     * }
     * ```
     *
     * which, with `load()` can be written as:
     *
     * ```php
     * if ($model->load($_POST) && $model->save()) {
     *     // handle success
     * }
     * ```
     *
     * `load()` gets the `'FormName'` from the model's [[formName()]] method (which you may override), unless the
     * `$formName` parameter is given. If the form name is empty, `load()` populates the model with the whole of
     * `$data`, instead of `$data['FormName']`.
     *
     * Note, that the data being populated is subject to the safety check by [[setAttributes()]].
     *
     * @param array $data the data array to load, typically `$_POST` or `$_GET`.
     * @param string $formName the form name to use to load the data into the model.
     * If not set, [[formName()]] is used.
     *
     * @return boolean whether `load()` found the expected form in `$data`.
     */
    public function load( $data, $formName = null ): bool
    {

        $this->formatData( $data );

        return parent::load( $data, $formName );
    }

    /**
     * @param $data
     */
    public function formatData( &$data )
    {

        $fields = $this->fields();
        if ( !empty( $fields ) ) {
            $formattedData = [];
            foreach ( $data as $key => $value ) {
                if ( !empty( $fields[ $key ] ) ) {
                    $formattedData[ $fields[ $key ] ] = $value;

                }
                else {
                    $formattedData[ $key ] = $value;
                }
            }
            $data = $formattedData;
        }
    }

    /**
     * Returns the first error of every attribute in the model.
     * @return array the first errors. The array keys are the attribute names, and the array
     * values are the corresponding error messages. An empty array will be returned if there is no error.
     * @see getErrors()
     * @see getFirstError()
     */
    public function getFirstErrors(): array
    {

        $fields = array_flip( $this->fields() );
        $errors = parent::getFirstErrors();
        $formattedErrors = [];
        foreach ( $errors as $name => $message ) {
            if ( !empty( $fields[ $name ] ) && is_string( $fields[ $name ] ) ) {
                $formattedErrors[ $fields[ $name ] ] = $message;
            }
            else {
                $formattedErrors[ $name ] = $message;
            }
        }

        return $formattedErrors;
    }
}
