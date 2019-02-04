<?php
#parse("PHP File Header.php")

declare(strict_types=1);

#if (${NAMESPACE})

namespace ${NAMESPACE};

#end

use App\Components\RestController;

/**
 * Class ${NAME}
 * @package ${NAMESPACE}
 */
class ${NAME} extends RestController {
	/**
	 * Init model class
	 */
	public function init(): void
	{
		${DS}this->modelClass = ${MODEL_FACTORY}::getClass(${MODEL_FACTORY}::${MODEL_NAME});
	}

    /**
     * @apiDefine ObjectNotFoundError
     *
     * @apiError ObjectNotFound The id of the Object was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "ObjectNotFound"
     *     }
     */



    /**
     * @api {post} /${URL_RULE}/ Create ${API_GROUP}
     * @apiVersion ${API_VERSION}
     * @apiName NAME
     * @apiGroup ${API_GROUP}
     *
     * @apiDescription Create new ${API_GROUP}.
     *
     * @apiHeader (${API_GROUP}) {String} Accept-Encoding Accepting formats.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept-Encoding": "Accept-Encoding: gzip, deflate"
     *     }
     *
     * @apiParam {Number} param1 Description of param1.
     * @apiParam {String} param2 Description of param2.
     * @apiParam {String} param3=1 Description of param3 with default value.
     * @apiParam {Object} [param4=null] Description of optional param4 with default value.
     *
     * @apiSuccess {String} param1 Param1 description.
     * @apiSuccess {String} param2 Param2 description.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "param1": "Param1 value",
     *       "param2": "Param2 value"
     *     }
     *
     * @apiUse ObjectNotFoundError
     *
     * @apiPermission admin
     */



    /**
     * @api {get} /${URL_RULE}/ Get ${API_GROUP}s
     * @apiVersion ${API_VERSION}
     * @apiName NAME
     * @apiGroup ${API_GROUP}
     *
     * @apiDescription Get list of ${API_GROUP}s.
     *
     * @apiHeader (${API_GROUP}) {String} Accept-Encoding Accepting formats.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept-Encoding": "Accept-Encoding: gzip, deflate"
     *     }
     *
     * @apiExample Example usage:
     * curl -i http://${HOST}/${URL_RULE}/
     *
     * @apiSuccess {String} param1 Param1 description.
     * @apiSuccess {String} param2 Param2 description.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "param1": "Param1 value",
     *       "param2": "Param2 value"
     *     }
     *
     * @apiUse ObjectNotFoundError
     *
     * @apiPermission none
     */



    /**
     * @api {get} /${URL_RULE}/:id Get ${API_GROUP}
     * @apiVersion ${API_VERSION}
     * @apiName NAME
     * @apiGroup ${API_GROUP}
     *
     * @apiDescription Get certain ${API_GROUP}.
     *
     * @apiHeader (${API_GROUP}) {String} Accept-Encoding Accepting formats.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept-Encoding": "Accept-Encoding: gzip, deflate"
     *     }
     *
     * @apiParam {Number} id Unique record ID.
     *
     * @apiExample Example usage:
     * curl -i http://${HOST}/${URL_RULE}/1
     *
     * @apiSuccess {String} param1 Param1 description.
     * @apiSuccess {String} param2 Param2 description.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "param1": "Param1 value",
     *       "param2": "Param2 value"
     *     }
     *
     * @apiUse ObjectNotFoundError
     *
     * @apiPermission none
     */



    /**
     * @api {put} /${URL_RULE}/:id Update ${API_GROUP}
     * @apiVersion ${API_VERSION}
     * @apiName NAME
     * @apiGroup ${API_GROUP}
     *
     * @apiDescription Update certain ${API_GROUP}.
     *
     * @apiHeader (OBJECT) {String} Accept-Encoding Accepting formats.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept-Encoding": "Accept-Encoding: gzip, deflate"
     *     }
     *
     * @apiParam {String} param1 Description of param1.
     * @apiParam {String} param2 Description of param2.
     *
     * @apiSuccess {String} param1 Param1 description.
     * @apiSuccess {String} param2 Param2 description.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "param1": "Param1 value",
     *       "param2": "Param2 value"
     *     }
     *
     * @apiUse ObjectNotFoundError
     *
     * @apiPermission none
     */



    /**
     * @api {delete} /${URL_RULE}/:id Delete ${API_GROUP}
     * @apiVersion ${API_VERSION}
     * @apiName NAME
     * @apiGroup ${API_GROUP}
     *
     * @apiDescription Delete certain ${API_GROUP}.
     *
     * @apiHeader (${API_GROUP}) {String} Accept-Encoding Accepting formats.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept-Encoding": "Accept-Encoding: gzip, deflate"
     *     }
     *
     * @apiSuccess {String} param1 Param1 description.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "param1": "Param1 value"
     *     }
     *
     * @apiUse ObjectNotFoundError
     *
     * @apiPermission admin
     */
}