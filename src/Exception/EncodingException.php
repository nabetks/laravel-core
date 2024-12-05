<?php

namespace Aijoh\Core\Exception;

class EncodingException extends \Exception {
    public function __construct(private string $encodeForm,private $encodeTo, int $code = 0, \Throwable $previous = null)
    {
        $message = "文字列を{$encodeForm}から{$encodeTo}にエンコードできません。";
        parent::__construct($message, $code, $previous);
    }

    public function getEncodeForm(): string
    {
        return $this->encodeForm;
    }


    public function getEncodeTo(): string
    {
        return $this->encodeTo;
    }

}
