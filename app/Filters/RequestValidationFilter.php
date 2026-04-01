<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * RequestValidationFilter
 *
 * Validates that incoming requests originate from a trusted source
 * using HMAC-SHA256 signature of the raw request body.
 *
 * Required Header:
 *   X-Request-Signature : HMAC-SHA256( raw_request_body, REQUEST_KEY )
 *
 * Signature Formula:
 *   $signature = hash_hmac('sha256', $rawBody, REQUEST_KEY)
 *
 * Expected body (must be exactly this compact JSON):
 *   {"project_id":"royalXpay","action":"validation_check"}
 */
class RequestValidationFilter implements FilterInterface
{
    /** Expected fixed body — must match exactly */
    private const EXPECTED_PROJECT_ID = 'royalXpay';
    private const EXPECTED_ACTION     = 'validation_check';

    public function before(RequestInterface $request, $arguments = null)
    {
        $requestKey = env('REQUEST_KEY');

        if (empty($requestKey)) {
            log_message('error', '[RequestValidation] REQUEST_KEY is not configured in .env');
            return service('response')->setJSON([
                'statusCode' => 500,
                'message'    => 'Server configuration error',
                'data'       => null,
            ])->setStatusCode(500);
        }

        // --- 1. Read signature header ---
        $signature = $request->getHeaderLine('X-Request-Signature');

        if (empty($signature)) {
            log_message('warning', '[RequestValidation] Missing X-Request-Signature header');
            return service('response')->setJSON([
                'statusCode' => 401,
                'message'    => 'Missing request signature',
                'data'       => null,
            ])->setStatusCode(401);
        }

        // --- 2. Recompute expected HMAC from raw body ---
        $rawBody           = $request->getBody() ?? '';
        $expectedSignature = hash_hmac('sha256', $rawBody, $requestKey);

        // --- 3. Timing-safe signature comparison ---
        if (!hash_equals($expectedSignature, $signature)) {
            log_message('warning', '[RequestValidation] Invalid signature. Expected: ' . $expectedSignature . ' | Received: ' . $signature);
            return service('response')->setJSON([
                'statusCode' => 401,
                'message'    => 'Invalid request signature',
                'data'       => null,
            ])->setStatusCode(401);
        }

        // --- 4. Validate body fields — must be exactly the expected values ---
        $body      = json_decode($rawBody, true);
        $projectId = $body['project_id'] ?? '';
        $action    = $body['action']     ?? '';

        if ($projectId !== self::EXPECTED_PROJECT_ID || $action !== self::EXPECTED_ACTION) {
            log_message('warning', '[RequestValidation] Invalid body content. project_id: "' . $projectId . '" | action: "' . $action . '"');
            return service('response')->setJSON([
                'statusCode' => 401,
                'message'    => 'Invalid request body',
                'data'       => null,
            ])->setStatusCode(401);
        }

        log_message('info', '[RequestValidation] Request validated successfully. project_id: ' . $projectId);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after
    }
}
