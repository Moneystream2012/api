<?php
#parse("PHP File Header.php")

declare(strict_types=1);

#if (${NAMESPACE})

namespace ${NAMESPACE};

#end

use yii\rest;

/**
 * @apiDefine NotFoundError
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "ObjectNotFound"
 *     }
 */

/**
 * @apiDefine InternalServerError
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 500 Internal Server Error
 *     {
 *       "error": "InternalError"
 *     }
 */

/**
 * @apiDefine UnauthorizedError
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "error": "Unauthorized"
 *     }
 */

/**
 * Class ${NAME}
 * @package ${NAMESPACE}
 *
 * @api {get} /${URL_RULE}/ Short action description
 * @apiVersion ${API_VERSION}
 * @apiName NAME
 * @apiGroup ${API_GROUP}
 *
 * @apiParam {Number} id Id of object to get.
 *
 * @apiSuccess {Object} data Returned data object.
 * @apiSuccess {Number} data.id Id of object.
 * @apiSuccess {String} data.name Name of object.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "data":
 *          {
 *              "id": 1,
 *              "name": "Object name"
 *          }
 *     }
 *
 * @apiError ObjectNotFound Object with <code>id</code> was not found.
 * @apiError InternalError Something went wrong.
 * @apiError UnauthorizedAccess User isn't authorized for action.
 *
 * @apiUse NotFoundError
 * @apiUse InternalServerError
 * @apiUse UnauthorizedError
 */
class ${NAME} extends rest\Action
{

}