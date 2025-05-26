<?php

use Dotenv\Dotenv;
use Isapp\AiSpamdetector\Client;
use Isapp\AiSpamdetector\FormData;
use Isapp\AiSpamdetector\SpamDetector;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SpamDetectorTest extends TestCase
{
    private SpamDetector $detector;

    #[Test]
    public function analyze_spam(): void
    {
        $formData = new FormData(
            message: 'Congratulations! You are selected for a limited offer!!! Click here 👉 http://bit.ly/xyz',
            name: 'James Bond',
            email: 'freecashnow@xyz.biz',
            userAgent: 'python-requests/2.31',
            ip: '123.123.123.123'
        );

        $result = $this->detector->analyze($formData);
        $this->assertFalse($result);
    }

    #[Test]
    public function analyze_valid_message(): void
    {
        $formData = new FormData(
            message: 'Hi, I would like more information about your services.',
            firstName: 'John',
            lastName: 'Doe',
            email: 'johndoe@example.com',
            userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            ip: '123.123.123.123',
        );

        $result = $this->detector->analyze($formData);
        $this->assertTrue($result);
    }

    #[Test]
    public function analyze_empty_data(): void
    {
        $formData = new FormData(
            message: '',
            email: '',
            name: '',
            userAgent: '',
            ip: '',
        );

        $result = $this->detector->analyze($formData);
        $this->assertFalse($result);
    }

    protected function setUp(): void
    {
        if (file_exists(__DIR__.'/../.env')) {
            (Dotenv::createImmutable(__DIR__.'/../'))->load();
        }
        $apiKey = $_ENV['OPENAI_API_KEY'] ?? getenv('OPENAI_API_KEY');
        $organization = $_ENV['OPENAI_ORGANIZATION'] ?? getenv('OPENAI_ORGANIZATION');
        $this->detector = new SpamDetector(new Client($apiKey, $organization));
    }
}
