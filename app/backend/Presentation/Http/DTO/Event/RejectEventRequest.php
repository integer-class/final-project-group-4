<?php

namespace Presentation\Http\DTO\Event;

use Presentation\Http\DTO\DtoRequestContract;

class RejectEventRequest implements DtoRequestContract
{
    public string $reason;

    public function __construct(array $data)
    {
        $this->reason = $data['reason'];
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->reason)) {
            $errors['reason'] = 'Reason is required';
        }

        return $errors;
    }

    public function toArray(): array
    {
        return [
            'reason' => $this->reason,
        ];
    }
}