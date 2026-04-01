<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

/**
 * RequestValidationController
 *
 * Endpoint: POST /api/v1/validate-request
 *
 * Protected by RequestValidationFilter — if the request reaches here,
 * the HMAC signature has already been verified.
 *
 * -----------------------------------------------
 * How to call this endpoint:
 * -----------------------------------------------
 * 1. Build compact JSON body (no extra spaces):
 *      $body = '{"project_id":"royalXpay","action":"validation_check"}';
 *
 * 2. Generate HMAC signature:
 *      $signature = hash_hmac('sha256', $body, '5b797257-d56d-4c14-942f-8336558bf92c');
 *
 * 3. Send POST request with:
 *      Content-Type: application/json
 *      X-Request-Signature: <signature>
 *      Body: {"project_id":"royalXpay","action":"validation_check"}
 * -----------------------------------------------
 */
class RequestValidationController extends BaseController
{
    use ResponseTrait;

    /**
     * POST /api/v1/validate-request
     *
     * The RequestValidationFilter handles signature verification.
     * If we reach here, the request is authentic.
     */
    public function validateRequest()
    {
        // Filter has already verified: HMAC signature + project_id + action
        return $this->response->setJSON([
            'statusCode' => 200,
            'message'    => 'valid request',
            'data'       => [
                'project_id' => 'royalXpay',
                'action'     => 'validation_check',
            ],
        ])->setStatusCode(200);
    }
}
