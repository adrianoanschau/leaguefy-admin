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
        parent::__construct($this->messageMap[$e->getCode()], $this->codeMap[$e->getCode()]);
    }
}
