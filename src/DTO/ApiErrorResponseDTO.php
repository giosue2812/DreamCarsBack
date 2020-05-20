<?php


namespace App\DTO;


use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Api Error Response model",
 *     type="object",
 *     title="ApiErrorReponse Model"
 * )
 * Class ApiErrorResponseDTO
 * @package App\DTO
 */
class ApiErrorResponseDTO
{
    /**
     * @OA\Property(
     *     property="statusCode",
     *     type="integer",
     *     description="Status Error code"
     * )
     * @var integer $statusCode
     */
    private $statusCode;
    /**
     * @OA\Property(
     *     property="message",
     *     type="string",
     *     description="Error message"
     * )
     * @var string $message
     */
    private $message;

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return ApiErrorResponseDTO
     */
    public function setStatusCode(int $statusCode): ApiErrorResponseDTO
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ApiErrorResponseDTO
     */
    public function setMessage(string $message): ApiErrorResponseDTO
    {
        $this->message = $message;
        return $this;
    }


}
