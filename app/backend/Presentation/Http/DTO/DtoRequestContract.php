<?php

namespace Presentation\Http\DTO;

interface DtoRequestContract
{
    public function validate(): array;
    public function toArray(): array;
}