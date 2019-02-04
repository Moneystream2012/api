<?php
#parse("PHP File Header.php")

#if (${NAMESPACE})

namespace ${NAMESPACE};

#end

use yii\rest\ActiveController;

/**
 * ${NAME} controller
 */
class ${NAME} extends ActiveController {
    public ${DS}modelClass = '${MODEL_CLASS}';
    
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
     * @api {post} /${URL_RULE}/ Create object
     * @apiVersion 0.1.0
     * @apiName CreateObject
     * @apiGroup Object
     *
     * @apiDescription Create new Object.
     *
     * @apiHeader (Object) {String} Accept-Encoding Accepting formats.
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
     * @api {get} /${URL_RULE}/ Get objects
     * @apiVersion 0.1.0
     * @apiName GetObjects
     * @apiGroup Object
     *
     * @apiDescription Get list of objects.
     *
     * @apiHeader (Object) {String} Accept-Encoding Accepting formats.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept-Encoding": "Accept-Encoding: gzip, deflate"
     *     }
     *
     * @apiExample Example usage:
     * curl -i http://localhost/${URL_RULE}/
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
     * @api {get} /${URL_RULE}/:id Get object
     * @apiVersion 0.1.0
     * @apiName GetObject
     * @apiGroup Object
     *
     * @apiDescription Get certain object.
     *
     * @apiHeader (Object) {String} Accept-Encoding Accepting formats.
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Accept-Encoding": "Accept-Encoding: gzip, deflate"
     *     }
     *
     * @apiParam {Number} id Unique record ID.
     *
     * @apiExample Example usage:
     * curl -i http://localhost/${URL_RULE}/1
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
     * @api {put} /${URL_RULE}/:id Update object
     * @apiVersion 0.1.0
     * @apiName UpdateObject
     * @apiGroup Object
     *
     * @apiDescription Update certain object.
     *
     * @apiHeader (Object) {String} Accept-Encoding Accepting formats.
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
     * @api {delete} /${URL_RULE}/:id Delete object
     * @apiVersion 0.1.0
     * @apiName DeleteObject
     * @apiGroup Object
     *
     * @apiDescription Delete certain object.
     *
     * @apiHeader (Object) {String} Accept-Encoding Accepting formats.
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