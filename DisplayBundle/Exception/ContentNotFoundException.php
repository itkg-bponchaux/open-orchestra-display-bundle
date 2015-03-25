<?php

namespace OpenOrchestra\DisplayBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ContentNotFoundException
 */
class ContentNotFoundException extends HttpException
{
    /**
     * @param string $message
     */
    public function __construct($message = "")
    {
        parent::__construct(404, 'Content Not Found : ' . $message);
    }
}
