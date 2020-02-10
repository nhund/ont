<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Spatie\Fractal\Fractal as BaseFractal;

/**
 * Here we extend the base Fractal class to adjust some methods
 * provided by the package. For example, we're going to override
 * the `respond` method to make the response format consistent
 * across the application.
 */
class Fractal extends BaseFractal
{
    use ApiResponseFormatter;

    /**
     * The response message.
     *
     * @var string
     */
    protected $message;

    /**
     * Set the message for the response.
     *
     * @param string $message
     * @return $this
     */
    public function addMessage($message = null)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function respond($statusCode = 200, $headers = [], $options = 0)
    {
        $response = parent::respond($statusCode, $headers, $options);
        $contents = $response->getData(true);

        $data = Arr::pull($contents, 'data', []);
        $data = $this->formatDataForApiResponse($data, $this->message, $response->getStatusCode());

        $response->setData(array_merge($data, $contents));

        return $response;
    }
}
