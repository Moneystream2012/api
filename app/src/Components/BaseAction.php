<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 26.07.17
 */
declare(strict_types=1);

namespace App\Components;

use yii\base\InvalidConfigException;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class BaseAction
 * @package App\Components
 */
class BaseAction extends \yii\base\Action
{

    /**
     * @var \yii\base\Model
     */
    public $modelClass = null;

    /**
     * @var bool
     */
    public $isValidate = true;

    /**
     * @param array $params
     * @return string|void|\yii\base\Model
     * @throws InvalidConfigException
     */
    public function runWithParams($params) {
        if (!method_exists($this, 'run')) {
            throw new InvalidConfigException(get_class($this) . ' must define a "run()" method.');
        }
        $args = $this->controller->bindActionParams($this, $params);
        Yii::trace('Running action: ' . get_class($this) . '::run()', __METHOD__);
        if (Yii::$app->requestedParams === null) {
            Yii::$app->requestedParams = $args;
        }

        if ($this->modelClass !== null and is_string($this->modelClass) and $this->isValidate) {
            $status = $this->validateData(ArrayHelper::getValue($params, 'formName', ''));

            if ($status !== true) {
                return $this->modelClass;
            }
        }

        $result = $this->beforeRun();
        if ($result !== true) {
            return $this->sendError($result);
        }
        $result = call_user_func_array([
            $this,
            'run'
        ], $args);
        return $this->afterRun($result);
    }


    /**
     * @param $formName
     * @return bool
     */
    public function validateData($formName) {
        $this->modelClass = new $this->modelClass();
        $this->modelClass->load(
            ArrayHelper::merge(
                \Yii::$app->request->getBodyParams(),
                \Yii::$app->request->get()
            ),
            $formName
        );
        return $this->modelClass->validate();
    }

    /**
     * @param null $result
     * @return null
     */
    protected function afterRun($result = null) {
        return $result;
    }
}