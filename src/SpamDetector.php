<?php

namespace Isapp\AiSpamdetector;

use function str_contains;

class SpamDetector
{
    protected ?string $prompt = null;

    public function __construct(
        readonly protected Client $client,
    ) {}

    public function analyze(FormData $dto): bool
    {
        if (empty($dto->message)) {
            return false;
        }
        $response = $this->client->make()->chat()->create([
            'model' => $this->client->getModel(),
            'temperature' => 0,
            'messages' => [
                ['role' => 'system', 'content' => $this->getPrompt()],
                ['role' => 'user', 'content' => $dto->toJson()],
            ],
        ]);

        return $this->isSpam($response);
    }

    public function getPrompt(): ?string
    {
        return $this->prompt ?? $this->getDefaultPrompt();
    }

    public function setPrompt(string $prompt): static
    {
        $this->prompt = $prompt;

        return $this;
    }

    protected function getDefaultPrompt(): string
    {
        return <<<'PROMPT'
You are an AI spam detection engine. Analyze the input JSON.
Return exactly "SPAM" or "OK". No explanation.

Criteria:
- Suspicious words or links in message
- Strange email addresses or names
- User-Agent indicating a bot or script
PROMPT;
    }

    protected function isSpam(\OpenAI\Responses\Chat\CreateResponse $response): bool
    {
        return ! str_contains($response->choices[0]->message->content, 'SPAM');
    }
}
