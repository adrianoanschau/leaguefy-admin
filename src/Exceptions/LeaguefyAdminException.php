<?php

namespace Leaguefy\LeaguefyAdmin\Exceptions;

use Exception;
use Throwable;

class LeaguefyAdminException extends Exception
{
    private $codeMap = [
        '23503' => 409, //QueryException: Foreign key violation
    ];

    private $messageMap = [
        '23503' => 'Conflict',
    ];

    public function __construct(Throwable $e)
    {
        $message = $this->messageMap[$e->getCode()] ?? 'Internal Server Error';
        $code = $this->codeMap[$e->getCode()] ?? 500;

        parent::__construct($message, $code);
    }
}
