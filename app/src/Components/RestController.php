<?php
/**
 * @author Tarasenko Andrii
 * @date: 12.07.17
 */

declare(strict_types=1);

namespace App\Components;

use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

/**
 * Class RestController
 *
 * @package App\Components
 */
class RestController extends ActiveController
{

    /**
     * Behaviors
     *
     * @return array
     */
    public function behaviors(): array
    {

        $behaviors = parent::behaviors();
        // remove authentication filter
        $auth = $behaviors[ 'authenticator' ];
        unset( $behaviors[ 'authenticator' ] );
        // add CORS filter
        $behaviors[ 'corsFilter' ] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [
                    'X-Pagination-Total-Count',
                    'X-Pagination-Page-Count',
                    'X-Pagination-Current-Page',
                    'X-Pagination-Per-Page',
                    'token-type',
                    'access-token',
                    'userId'
                ],
            ]
        ];
        // re-add authentication filter
        $behaviors[ 'authenticator' ] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors[ 'authenticator' ][ 'except' ] = [ 'options' ];
        $behaviors['authenticator']['authMethods'] = [
            \App\Modules\User\Modules\JWT\JWTBehavior::class,
            \App\Modules\User\Components\NoneAuth::class
        ];

        return $behaviors;
    }


    /**
     * @apiDefine NotFoundError
     *
     * @apiError ObjectNotFound Object of user was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *          "name": "Not Found",
     *          "message": "Object not found: 1",
     *          "code": 0,
     *          "status": 404,
     *          "type": "yii\\web\\NotFoundHttpException"
     *     }
     */

    /**
     * @apiDefine UnauthorisedError
     *
     * @apiError Unauthorised User is unauthorised for action.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Unauthorised
     *     {
     *          "name": "Unauthorised",
     *          "message": "User unauthorised",
     *          "code": 0,
     *          "status": 401,
     *          "type": "yii\\web\\UnauthorisedException"
     *     }
     */

    /**
     * @apiDefine UnvalidatedError
     *
     * @apiError Unvalidated Data validation failed.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 422 Data validation failed
     *     [
     *          {
     *              "field": "name",
     *              "message": "Name \"111\" has already been taken."
     *          }
     *     ]
     */

    /**
     * @apiDefine UnavailableError
     *
     * @apiError Unavailable Internal server error.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *          "name": "Unavailable",
     *          "message": "Unavailable",
     *          "code": 0,
     *          "status": 500,
     *          "type": "yii\\web\\UnavailableException"
     *     }
     */
}
