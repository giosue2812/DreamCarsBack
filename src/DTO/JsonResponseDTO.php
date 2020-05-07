<?php


namespace App\DTO;


class JsonResponseDTO
{
    /**
     * @var integer $code
     */
    private int $code;
    /**
     * @var string $status
     */
    private string $status;
    /**
     * @var string $data
     */
    private $data;

    /**
     * JsonResponseDTO constructor.
     * @param $code
     * @param $status
     * @param $data
     */
    public function __construct($code,$status,$data)
    {
        $this->code = $code;
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }
}
