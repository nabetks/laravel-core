<?php

namespace Aijoh\Core\Exceptions;

class FileException extends \Exception {

    public function __construct(string $filePath, int $code = 0, \Throwable $previous = null){
        parent::__construct($filePath, $code, $previous);
    }
}
