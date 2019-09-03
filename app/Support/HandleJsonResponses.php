<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HandleJsonResponses
{
    use ApiResponseFormatter;

    /**
     * The response status code.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * The response message.
     *
     * @var string
     */
    protected $message;

    /**
     * The latest response returned.
     *
     * @var \Illuminate\Http\JsonResponse
     */
    public $response;

    /**
     * The addition data
     *
     * @var object
     */
    public $meta;

    /**
     * Response OK (200).
     *
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_OK)->withoutErrors($data, $headers);
    }

    /**
     * Response Created (201)
     *
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_CREATED)->withoutErrors($data, $headers);
    }

    /**
     * Response Bad Request (400).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondBadRequest($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_BAD_REQUEST)->withErrors($data, $headers);
    }

    /**
     * Response Unauthorized (401).
     *
     * @param  array $data
     * @param  array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUnauthorized($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_UNAUTHORIZED)->withErrors($data, $headers);
    }

    /**
     * Response forbidden (403).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondForbidden($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_FORBIDDEN)->withErrors($data, $headers);
    }

    /**
     * Response Not Found (404).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_NOT_FOUND)->withErrors($data, $headers);
    }

    /**
     * Response Unprocessable Entity (422).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUnprocessableEntity($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->withErrors($data, $headers);
    }

    /**
     * Response Method Not Allowed (405).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondMethodNotAllowed($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_METHOD_NOT_ALLOWED)->withErrors($data, $headers);
    }

    /**
     * Response Internal Server Error (500).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalServerError($data = [], $headers = [])
    {
        return $this->statusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->withErrors($data, $headers);
    }

    /**
     * Generic JSON response.
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data = [], $headers = [])
    {
        $this->response = new JsonResponse($data, $this->statusCode, $headers);

        return $this->response;
    }

    /**
     * Generic error response.
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withErrors($data = [], $headers = [])
    {
        return $this->respond($this->formatResponse($data, true), $headers);
    }

    /**
     * Generic success response.
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withoutErrors($data = [], $headers = [])
    {
        return $this->respond($this->formatResponse($data, false), $headers);
    }

    /**
     * Format the data for the response.
     *
     * @param  array $data
     * @param  boolean $error
     *
     * @return array
     */
    public function formatResponse($data = [], $error = false)
    {
        return $this->formatDataForApiResponse($data, $this->message, $this->statusCode, $error, $this->meta);
    }

    /**
     * Set the message for the response.
     *
     * @param string $message
     *
     * @return $this
     */
    public function message($message = '')
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param null $meta
     * @return $this
     */
    public function meta($meta = null)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Set the custom response status code.
     *
     * @param int $code
     *
     * @return $this
     */
    public function statusCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }
}
