<?php
/**
 * @author Andru Cherny <acherny@minexsystems.com>
 * @date: 26.07.17
 */
declare(strict_types=1);


namespace App\Components\ErrorHandler;

use yii\base\UserException;
use yii\web\ErrorHandler;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class Handler
 * @package App\Components\ErrorHandler
 */
class Handler extends ErrorHandler
{
    /**
     * @var bool
     */
    public $overwriteActive;

    /**
     * @var bool
     */
    public $displayStacktrace;

    /**
     * @inheridoc
     *
     * @param \Exception $exception
     */
    protected function renderException($exception)
    {
        if ($this->overwriteActive == false) {
            parent::renderException($exception);
            return;
        }
        if ($exception instanceof HttpException) {
            $response = $this->catchHttpException($exception);
        } elseif ($exception instanceof UserException) {
            $response = $this->catchUserException($exception);
        } else {
            $response = $this->catchErrorException($exception);
        }
        if ($this->displayStacktrace == true) {
            $response->data['file'] = $exception->getFile();
            $response->data['line'] = $exception->getLine();
            $response->data['stack-trace'] = explode("\n", $exception->getTraceAsString());
        }
        $response->send();
    }

    /**
     * @param $exception
     */
    private function catchHttpException(HttpException $exception)
    {
        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->setStatusCode($exception->statusCode);
        $response->data = [
            'name'    => \Yii::t('system\\exception', $exception->getName()),
            'message' => $exception->getMessage(),
        ];
        return $response;
    }

    /**
     * @param $exception
     */
    private function catchUserException(UserException $exception)
    {

        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->setStatusCode(400);
        $response->data = [
            'name'    => \Yii::t('system\\exception', $exception->getName()),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];
        return $response;
    }

    /**
     * @param $exception
     * @return \yii\console\Response|Response
     */
    private function catchErrorException($exception)
    {
        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->setStatusCode(500);
        $response->data = [
            'name'    => \Yii::t('system\\exception', $exception->getName()),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];
        return $response;
    }

}