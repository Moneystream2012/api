<?php
/**
 * @author Andrey Tarasenko <atarasenko@minexsystems.com>
 * @date: 13.07.17
 */

declare(strict_types=1);

namespace App\Modules\Setting\Controllers;

use App\{
    Components\RestController,
    Modules\Setting\Components\SettingModelFactory
};
use yii\filters\AccessControl;

/**
 * Class SettingController
 * @package App\Modules\Setting\Controllers
 */
class SettingController extends RestController
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->modelClass = SettingModelFactory::getClass(SettingModelFactory::SETTING);

    }

    /**
     * Behaviors
     *
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access']  = [
            'class' => AccessControl::className(),
            'except' => ['options'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete'],
                    'roles' => ['user'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    protected function verbs()
    {
        return parent::verbs();
    }

    /**
     * @api {post} /setting Create setting
     * @apiVersion 1.0.0
     * @apiName CreateSetting
     * @apiGroup Setting
     *
     * @apiDescription Create new setting object.
     *
     * @apiParam {Integer} groupId Setting's group id.
     * @apiParam {String} name Setting's name.
     * @apiParam {String} shortName Setting's shortName.
     * @apiParam {String} value Setting's value.
     * @apiParam {String} default Setting's default value.
     *
     * @apiSuccess {Integer} id Setting's id.
     * @apiSuccess {Integer} groupId Setting's group id.
     * @apiSuccess {String} name Setting's name.
     * @apiSuccess {String} shortName Setting's shortName.
     * @apiSuccess {String} value Setting's value.
     * @apiSuccess {String} default Setting's default value.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "groupId": "2",
     *          "name": "Auto-login period",
     *          "shortName": "Auto-login",
     *          "value": "5",
     *          "default": "3"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} /setting Get list of settings
     * @apiVersion 1.0.0
     * @apiName GetSettings
     * @apiGroup Setting
     *
     * @apiDescription Get list of settings.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id Setting's id.
     * @apiSuccess {Integer} Object.groupId Setting's group id.
     * @apiSuccess {String} Object.name Setting's name.
     * @apiSuccess {String} Object.shortName Setting's shortName.
     * @apiSuccess {String} Object.value Setting's value.
     * @apiSuccess {String} Object.default Setting's default value.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "groupId": "2",
     *              "name": "Auto-login period",
     *              "shortName": "Auto-login",
     *              "value": "5",
     *              "default": "3"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} /setting/:id Get setting object
     * @apiVersion 1.0.0
     * @apiName GetSetting
     * @apiGroup Setting
     *
     * @apiDescription Get object of setting.
     *
     * @apiParam {Integer} id Identifier of setting object.
     *
     * @apiSuccess {Integer} id Setting's id.
     * @apiSuccess {Integer} groupId Setting's group id.
     * @apiSuccess {String} name Setting's name.
     * @apiSuccess {String} shortName Setting's shortName.
     * @apiSuccess {String} value Setting's value.
     * @apiSuccess {String} default Setting's default value.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "groupId": "2",
     *          "name": "Auto-login period",
     *          "shortName": "Auto-login",
     *          "value": "5",
     *          "default": "3"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} /setting/:id Update setting object
     * @apiVersion 1.0.0
     * @apiName UpdateSetting
     * @apiGroup Setting
     *
     * @apiDescription Update object of setting.
     *
     * @apiParam {Integer} groupId Setting's group id.
     * @apiParam {String} name Setting's name.
     * @apiParam {String} shortName Setting's shortName.
     * @apiParam {String} value Setting's value.
     * @apiParam {String} default Setting's default value.
     *
     * @apiSuccess {Integer} id Setting's id.
     * @apiSuccess {Integer} groupId Setting's group id.
     * @apiSuccess {String} name Setting's name.
     * @apiSuccess {String} shortName Setting's shortName.
     * @apiSuccess {String} value Setting's value.
     * @apiSuccess {String} default Setting's default value.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "groupId": "2",
     *          "name": "Auto-login period",
     *          "shortName": "Auto-login",
     *          "value": "5",
     *          "default": "3"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} /setting/:id Delete setting object
     * @apiVersion 1.0.0
     * @apiName DeleteSetting
     * @apiGroup Setting
     *
     * @apiDescription Delete object of setting.
     *
     * @apiParam {Integer} id Identifier of setting object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
