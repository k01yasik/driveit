<?php

namespace App\Exceptions;

use Exception;

class AlbumNotFoundException extends Exception
{
    protected $message = 'Album not found';
}
