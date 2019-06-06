# PandawanTechnology EmailTransformer
When using the new [symfony/mailer](https://symfony.com/mailer) component, especially when you are migrating from [SwiftMailer](https://swiftmailer.symfony.com/), it might be tedious to reorganize email addresses formatting. This library intends to help developpers with formatting them in the expected way.

## Installation
```bash
$ composer require pandawan-technology/email-transformer
```

## Usage
### Single address
In order to make sure you only have one address, you can use the `transformUnique` method as shown below:
```php
<?php

use PandawanTechnology\EmailTransformer\EmailAddressTransformer;

class MyService 
{
    /**
     * @var EmailAddressTransformer 
     */
    private $emailAddressTransformer;
    
    public function __construct(EmailAddressTransformer $emailAddressTransformer) 
    {
        $this->emailAddressTransformer = $emailAddressTransformer;
    }
    
    public function __invoke($address) 
    {
        $address = $this->emailAddressTransformer->transformUnique($address);
        // Will output an (Named)Address instance depending on the provided input
    }
}
````

### Multiple Address / unknown
In order to format a collection of email addresses (or an unknown quantity), the `transform` method ad shown below:
```php
<?php

use PandawanTechnology\EmailTransformer\EmailAddressTransformer;

class MyService 
{
    /**
     * @var EmailAddressTransformer 
     */
    private $emailAddressTransformer;
    
    public function __construct(EmailAddressTransformer $emailAddressTransformer) 
    {
        $this->emailAddressTransformer = $emailAddressTransformer
    }
    
    public function __invoke($addresses) 
    {
        $addresses = $this->emailAddressTransformer->transform($addresses);
        // Will output an (Named)Address array instance(s) depending on the provided input
    }
}
```

## Supported cases
Those methods accepts strings, array of strings, (Named)Address instances, array of (Named)Address instances and mixed arrays. To get a better overview of supported inputs, you could find them in the `EmailAddressTransformerTest.php` test class.
