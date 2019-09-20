<?php

namespace App\Exceptions;

use App\Support\ApiResponseFormatter;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Models\Error as ErrorModel;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use ApiResponseFormatter;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    protected $customRender = [
        UserCourseException::class,
        BookMarkException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $hasCustomRenderer = in_array(get_class($exception), $this->customRender);
        if ($hasCustomRenderer) {
            return $this->renderCustomException($request, $exception);
        }

        if ($this->shouldReport($exception))
        {
            $this->_logError($request, $exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * Handle exceptions for API request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    protected function renderCustomException($request, $exception)
    {
        $handler = 'render'.class_basename($exception);

        if (!method_exists($this, $handler)) {
            return null;
        }

        return $this->$handler($request, $exception);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\Access\AuthorizationException $exception
     * @return \Illuminate\Http\JsonResponse|null
     */
    protected function renderUserCourseException($request, $exception){

        return $this->prepareErrorResponse($request, $exception, 400);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\Access\AuthorizationException $exception
     * @return \Illuminate\Http\JsonResponse|null
     */
    protected function renderOnthiezException($request, $exception){

        return $this->prepareErrorResponse($request, $exception, 400);
    }

    /**
     * Convert a given exception to the appropriate response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $exception
     * @param  integer $status
     * @param  mixed  $data
     * @param  string|null  $message
     * @param  array   $headers
     * @return mixed
     */
    protected function prepareErrorResponse($request, $exception, $status = 400, $message = null, $data = null, $headers = [])
    {
        if (is_null($message) && method_exists($exception, 'getMessage')) {
            $message = $exception->getMessage();
        }

        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() !== null) {
            $status = $exception->getStatusCode();
        }

        return $this->respondError(
            $data,
            __($message),
            $status,
            $headers
        );
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        $mess =  $exception ->getMessage();
        if ($exception instanceof UnauthorizedHttpException)
        {
            // 401 code

            return redirect()->action(
                'ExceptionController@index', ['error' => 401, 'mess' => $mess]
            );

            //return response()->view('errors.404', ['message', $exception->getMessage()]);
        }
        //dd($exception);
        if ($exception instanceof NotFoundHttpException)
        {
             //404 code

                return redirect()->action(
                    'ExceptionController@index', ['error' => 404, 'mess' => $mess]
                );

            return response()->view('errors.404', ['message', $exception->getMessage()]);
        }
        if ($exception instanceof AccessDeniedHttpException)
        {
            // 403 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 403, 'mess' => $mess]
            );
        }
        if ($exception instanceof MethodNotAllowedHttpException)
        {
            // 405 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 405, 'mess' => $mess]
            );
        }
        if ($exception instanceof NotAcceptableHttpException)
        {
            // 406 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 406, 'mess' => $mess]
            );
        }
        if ($exception instanceof BadRequestHttpException)
        {
            // 400 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 400, 'mess' => $mess]
            );
        }
        if ($exception instanceof ConflictHttpException)
        {
            // 409 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 409, 'mess' => $mess]
            );
        }
        if ($exception instanceof GoneHttpException)
        {
            // 410 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 410, 'mess' => $mess]
            );
        }
        if ($exception instanceof LengthRequiredHttpException)
        {
            // 411 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 411, 'mess' => $mess]
            );
        }
        if ($exception instanceof PreconditionFailedHttpException)
        {
            // 412 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 412, 'mess' => $mess]
            );
        }
        if ($exception instanceof UnsupportedMediaTypeHttpException)
        {
            // 415 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 415, 'mess' => $mess]
            );
        }
        if ($exception instanceof PreconditionRequiredHttpException)
        {
            // 428 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 428, 'mess' => $mess]
            );
        }
        if ($exception instanceof ServiceUnavailableHttpException)
        {
            // 503 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 503, 'mess' => $mess]
            );
        }
        if ($exception instanceof UnprocessableEntityHttpException)
        {
            // 422 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 422, 'mess' => $mess]
            );
        }
        if ($exception instanceof TooManyRequestsHttpException)
        {
            // 429 code
            return redirect()->action(
                'ExceptionController@index', ['error' => 429, 'mess' => $mess]
            );
        }
        if ($exception instanceof TokenMismatchException)
        {
            // 400 code
            return redirect($request->fullUrl())->with('csrf_error',"Opps! Seems you couldn't submit form for a longtime. Please try again");
        }
        return redirect()->guest(route('login'));
    }
    protected function _logError($request, $exception)
    {

        $error = new ErrorModel();
        $error->request_uri = $request->getRequestUri();
        $error->method = $request->getMethod();
        $error->parameters = $request->getQueryString();
        $error->message = $exception->getMessage();
        $error->code = $exception->getCode();
        $error->file = $exception->getFile();
        $error->line = $exception->getLine();
        $error->trace = serialize($exception->getTraceAsString());
        $error->is_read = 0;
        $error->create_date = time();

        $error->save();

    }

    /**
     * Render an error exception.
     *
     * @param  mixed $data
     * @param  string|null $message
     * @param  integer $status
     * @param  array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondError($data = null, $message = null, $status = 400, $headers = [])
    {
        $data = $this->formatDataForApiResponse($data, $message, $status, true);

        return response()->json($data, 200, $headers);
    }

    /**
     * {@inheritdoc}
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        $data = $this->formatDataForApiResponse($exception->errors(), null, $exception->status, true);

        return response()->json($data, 200);
    }
}
