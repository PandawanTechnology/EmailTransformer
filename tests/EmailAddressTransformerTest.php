<?php

declare(strict_types=1);

namespace App\PandawanTechnology\EmailTransformer\tests;

use PandawanTechnology\EmailTransformer\EmailAddressTransformer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\NamedAddress;

class EmailAddressTransformerTest extends TestCase
{
    /**
     * @var EmailAddressTransformer
     */
    protected $emailAddressTransformer;

    protected function setUp()
    {
        $this->emailAddressTransformer = new EmailAddressTransformer();
    }

    /**
     * @dataProvider dataProviderTransformUnique
     *
     * @param mixed $input
     * @param Address $expected
     */
    public function testTransformUnique($input, Address $expected)
    {
        $this->assertEquals($expected, $this->emailAddressTransformer->transformUnique($input));
    }

    public function dataProviderTransformUnique(): array
    {
        return [
            // 0. Only one instance of Address
            [
                new Address('test@test.com'),
                new Address('test@test.com')
            ],
            // 1. Only one inherited instance of Address
            [
                new NamedAddress('test@test.com', 'John Doe'),
                new NamedAddress('test@test.com', 'John Doe')
            ],
            // 2. Only a string
            [
                'test@test.com',
                new Address('test@test.com')
            ],
            // 3. An à-la swiftmailer array with one entry
            [
                ['Testing is great' => 'test@test.com'],
                new NamedAddress('test@test.com', 'Testing is great')
            ],
            // 4. An array of strings
            [
                ['test@test.com', 'not-so-fancy@test.com'],
                new Address('test@test.com')
            ],
            // 4. An array containing an Address object as first value **SHOULD BE** overwritten.
            [
                [
                    'Passing Master' => new Address('fake@test.com'),
                    'ignored@test.com'
                ],
                new NamedAddress('fake@test.com', 'Passing Master')
            ],
            // 5. An array containing a NamedAddress object as first value **SHOULD NOT BE** overwritten.
            [
                [
                    'Ignored Senor' => new NamedAddress('fake@test.com', 'Toto'),
                    'ignored-again@test.com'
                ],
                new NamedAddress('fake@test.com', 'Toto')
            ],
        ];
    }

}

