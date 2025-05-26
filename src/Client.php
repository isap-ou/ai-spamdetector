<?php

namespace Isapp\AiSpamdetector;

use OpenAI;

class Client
{
    public function __construct(
        protected string $apiKey,
        protected ?string $organization = null,
        protected ?string $project = null,
        protected string $baseUri = 'api.openai.com/v1',
        protected string $model = 'gpt-4',
    ) {}

    public function setApiKey(string $apiKey): static
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setOrganization(?string $organization = null): static
    {
        $this->organization = $organization;

        return $this;
    }

    public function setProject(?string $project = null): static
    {
        $this->project = $project;

        return $this;
    }

    public function setBaseUri(string $baseUri): static
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    public function make(): \OpenAI\Client
    {
        $factory = OpenAI::factory()
            ->withApiKey($this->apiKey)
            ->withHttpClient(new \GuzzleHttp\Client([]));

        if (! empty($this->organization)) {
            $factory->withOrganization($this->organization);
        }
        if (! empty($this->project)) {
            $factory->withProject($this->project);
        }
        if (! empty($this->baseUri)) {
            $factory->withBaseUri($this->baseUri);
        }

        return $factory->make();
    }
}
