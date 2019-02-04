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
 * Class SettingGroupController
 * @package App\Modules\Setting\Controllers
 */
class SettingGroupController extends RestController
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->modelClass = SettingModelFactory::getClass(SettingModelFactory::SETTING_GROUP);
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
     * @api {post} /setting/group Create settingGroup
     * @apiVersion 1.0.0
     * @apiName CreateSettingGroup
     * @apiGroup SettingGroup
     *
     * @apiDescription Create new settingGroup object.
     *
     * @apiParam {String} name SettingGroup's name.
     * @apiParam {String} shortName SettingGroup's shortName.
     *
     * @apiSuccess {Integer} id SettingGroup's id.
     * @apiSuccess {String} name SettingGroup's name.
     * @apiSuccess {String} shortName SettingGroup's shortName.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Bank settings",
     *          "shortName": "Bank"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} /setting/group Get list of settingGroups
     * @apiVersion 1.0.0
     * @apiName GetSettingGroups
     * @apiGroup SettingGroup
     *
     * @apiDescription Get list of settingGroup's.
     *
     * @apiSuccess {Array} Response List of Object(s).
     * @apiSuccess {Integer} Object.id SettingGroup's id.
     * @apiSuccess {String} Object.name SettingGroup's name.
     * @apiSuccess {String} Object.shortName SettingGroup's shortName.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *          {
     *              "id": 1,
     *              "name": "Bank settings",
     *              "shortName": "Bank"
     *          }
     *     }
     *
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {get} /setting/group/:id Get settingGroup object
     * @apiVersion 1.0.0
     * @apiName GetSettingGroup
     * @apiGroup SettingGroup
     *
     * @apiDescription Get object of SettingGroup.
     *
     * @apiParam {Integer} id Identifier of settingGroup object.
     *
     * @apiSuccess {Integer} id SettingGroup's id.
     * @apiSuccess {String} name SettingGroup's name.
     * @apiSuccess {String} shortName SettingGroup's shortName.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Bank settings",
     *          "shortName": "Bank"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */

    /**
     * @api {put} /setting/group/:id Update SettingGroup object
     * @apiVersion 1.0.0
     * @apiName UpdateSettingGroup
     * @apiGroup SettingGroup
     *
     * @apiDescription Update object of SettingGroup.
     *
     * @apiParam {String} name SettingGroup's name.
     * @apiParam {String} shortName SettingGroup's shortName.
     *
     * @apiSuccess {Integer} id SettingGroup's id.
     * @apiSuccess {String} name SettingGroup's name.
     * @apiSuccess {String} shortName SettingGroup's shortName.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "name": "Bank settings",
     *          "shortName": "Bank"
     *     }
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnvalidatedError
     * @apiUse UnavailableError
     */

    /**
     * @api {delete} /setting/group/:id Delete settingGroup object
     * @apiVersion 1.0.0
     * @apiName DeleteSettingGroup
     * @apiGroup SettingGroup
     *
     * @apiDescription Delete object of settingGroup.
     *
     * @apiParam {Integer} id Identifier of settingGroup object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 204 No content
     *
     * @apiUse NotFoundError
     * @apiUse UnauthorisedError
     * @apiUse UnavailableError
     */
}
