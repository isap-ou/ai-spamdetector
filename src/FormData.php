<?php

namespace Isapp\AiSpamdetector;

class FormData
{
    public function __construct(
        readonly public string $message,
        readonly public string $email,
        readonly public ?string $name = null,
        readonly public ?string $firstName = null,
        readonly public ?string $lastName = null,
        readonly public ?string $phoneNumber = null,
        readonly public ?string $userAgent = null,
        readonly public ?string $ip = null,
    ) {
    }


    /**
     * @throws \JsonException
     */
    public function toJson(): string
    {
        return json_encode(array_filter([
            'name' => $this->name,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phoneNumber' => $this->phoneNumber,
            'email' => $this->email,
            'message' => $this->message,
            'userAgent' => $this->userAgent,
            'ip' => $this->ip,
        ], static fn ($value) => ! empty($value)), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}