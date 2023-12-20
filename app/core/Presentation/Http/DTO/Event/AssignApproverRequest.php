<?php

namespace Presentation\Http\DTO\Event;

use Presentation\Http\DTO\DtoRequestContract;

class AssignApproverRequest implements DtoRequestContract
{
    public array $approvers;

    public function __construct(array $data)
    {
        $this->approvers = $data['approvers'];
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->approvers)) {
            $errors['approvers'] = 'Approvers are required';
        }

        if (count($this->approvers) <= 0) {
            $errors['approvers'] = "Approvers can't be empty";
        }

        return $errors;
    }

    public function toArray(): array
    {
        return [
            'approvers' => $this->approvers
        ];
    }
}