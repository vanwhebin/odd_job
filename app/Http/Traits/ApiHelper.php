<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;

trait ApiHelper
{
    /**
     * @var int
     */
    protected $statusCode = Response::HTTP_OK;
    protected $err_code = 0;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode, $httpCode = null)
    {
        $httpCode = $httpCode ?? $statusCode;
        $this->statusCode = $httpCode;
        return $this;
    }

    /**
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        return response()->json($data, $this->statusCode)->withHeaders($header);
    }

    /**
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status, array $data, $code = null)
    {

        if ($code) {
            $this->setStatusCode($code);
        }
        try {
            \Symfony\Component\HttpFoundation\Response::$statusTexts[$this->statusCode];
        } catch (\Exception $exception) {
            $this->err_code = $this->statusCode;
            $this->setStatusCode(Response::HTTP_FORBIDDEN);
        }
        $status = [
            'status' => $status,
            'code' => $this->statusCode,
            'err_code' => $this->err_code,
        ];
        $data = array_merge($status, $data);
        return $this->respond($data);

    }

    /**
     * @param $message
     * @param string $status
     * @return mixed
     */
    public function message($message, $status = "success")
    {

        return $this->status($status, [
            'message' => $message
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!")
    {
        //500
        return $this->failed($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    /**
     * @param $message
     * @param int $code
     * @param string $status
     * @return mixed
     */
    /*
     * 格式
     * data:
     *  code:422
     *  message:xxx
     *  status:'error'
     */
    public function failed($message, $code = Response::HTTP_UNPROCESSABLE_ENTITY, $status = 'error')
    {
        return $this->setStatusCode($code)->message($message, $status);
    }

    /**
     * @param $data
     * @param string $status
     * @return mixed
     */
    public function success($data = [], $status = "success")
    {
        //200
        return $this->status($status, compact('data'));
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function created($message = "created")
    {
        //201
        return $this->setStatusCode(Response::HTTP_CREATED)
            ->message($message);

    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        //404
        return $this->failed($message, Response::HTTP_NOT_FOUND);
    }
}
