<?php

namespace App\Http\DTO;

class MessageDTO
{
    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function validationData()
    {
        return (new MessageDTO($this->message))->toArray();
    }


    public function toArray(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
