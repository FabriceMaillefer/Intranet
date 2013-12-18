<?php

namespace FMR\CommonBundle\Log;

use Symfony\Component\HttpKernel\Log\LoggerInterface;

class Logger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke($message)
    {
        $this->logger->notice($message);
    }
}
