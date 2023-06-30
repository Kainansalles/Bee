<?php

namespace App\Services\Consumer\Contracts;

interface ConsumerServiceContract
{
    public function createMessage(array $data);
}
