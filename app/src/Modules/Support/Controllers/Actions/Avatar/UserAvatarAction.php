<?php
/**
 * Created by PhpStorm.
 * User: vladyslav
 * Date: 27.07.17
 * Time: 13:28
 */
declare(strict_types=1);

namespace App\Modules\Support\Controllers\Actions\Avatar;

use yii\rest;

/**
 * Class UserAvatarAction
 * @package App\Modules\Support\Controllers\Actions\Avatar
 *
 * @api {get} user-avatar/:id Get user avatar in support chat
 * @apiVersion 1.0.0
 * @apiName GetUserAvatar
 * @apiGroup Avatar
 *
 * @apiParam {Integer} id User's <code>id</code>.
 *
 * @apiSuccess {Integer} id Avatar's <code>id</code>.
 * @apiSuccess {String} filename Name of avatar image file.
 *
 * @apiSuccessExample Success-Response:
 *		HTTP/1.1 200 OK
 *		{
 *			"id": 1566,
 *			"filename": "u1566.jpg"
 *		}
 *
 * @apiUse NotFoundError
 * @apiUse UnavailableError
 * @apiUse UnauthorisedError
 */
class UserAvatarAction extends rest\Action
{
    /**
     * @inheritdoc
     */
    public function run($id): array
    {
        return $this->modelClass->find()->select(['id', 'filename'])->ownedBy($id)->asArray()->one();
    }
}