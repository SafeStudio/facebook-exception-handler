<?php

namespace Facebook;

use GuzzleHttp\Exception\RequestException;

trait FacebookExceptionHandlerTrait
{
    private function handle(RequestException $e)
    {
        if ($e->hasResponse()) {
            $error = $e->getResponse()->getBody(true)->getContents();
            $this->logger->info("Exception response: ".$error);

            $message = json_decode($error)->error->message;
            throw new RequestException($message, $e->getRequest(), $e->getResponse(), $e, $e->getHandlerContext());
        }
        throw $e;
    }
}
