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
 * @apiDefine BadRequestError
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 400 Bad request
 *     {
 *       "error": "ValidationFailed"
 *     }
 */

/**
 * Class ${NAME}
 * @package ${NAMESPACE}
 *
 * @api {post} /${URL_RULE}/ Short action description
 * @apiVersion ${API_VERSION}
 * @apiName NAME
 * @apiGroup ${API_GROUP}
 *
 * @apiParam {String} name Name of new object.
 * @apiParam {Number} age Age of new object.
 * @apiParam {String} createdAt Time of object creation.
 *
 * @apiSuccess {Object} data Returned data object.
 * @apiSuccess {Number} data.id Id of object.
 * @apiSuccess {String} data.name Name of object.
 * @apiSuccess {Number} data.age Age of object.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "data":
 *          {
 *				"id": 1,
 *              "name": "Object name",
 *              "age": 40
 *          }
 *     }
 *
 * @apiError ObjectNotFound Object with <code>id</code> was not found.
 * @apiError InternalError Something went wrong.
 * @apiError UnauthorizedAccess User isn't authorized for action.
 * @apiError ValidationFailed Validation failed.
 *
 * @apiUse NotFoundError
 * @apiUse InternalServerError
 * @apiUse UnauthorizedError
 * @apiUse BadRequestError
 */
class ${NAME} extends rest\Action
{

}