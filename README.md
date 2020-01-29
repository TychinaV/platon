#Installation
###Using composer:

`composer require wearesho-team/platon`

#Usage
####List of possible parameters:<br>
[<br>
     'payment'     => 'CC',<br>
     'order'       => 'ORDER-123',                    // optional<br>
     'amount'      => 1.05,<br>
     'currency'    => 'UAH',<br>
     'description' => 'Describe of purchase',<br>
     'url'         => '<http://merchant.com/success>',<br>
     'error_url'   => '<http://merchant.com/error>',    // optional<br>
     'recurring'   => true,                           // optional<br>
     'ext1'        => 'something',                    // optional<br>
     ....<br>
     'ext10'       => 'something',                    // optional<br>
     'lang'        => 'en',                           // optional<br>
     'formid'      => 'UIYY2H2',                      // optional<br>
     'first_name'  => 'John',                         // optional<br>
     'last_name'   => 'Doe',                          // optional<br>
     'address'     => 'Some location',                // optional<br>
     'zip'         => '132456',                       // optional<br>
     'city'        => 'Big city',                     // optional<br>
     'country'     => 'UA',                           // optional<br>
     'phone'       => '0669998877',                   // optional<br>
     'email'       => 'example@mail.com',             // optional<br>
]

####You can add own parameters in html form.

Example:
```
<?php

require_once 'vendor/autoload.php';

use Platon\Platon;

$pay = new Platon('TEST000001', 'P@$$vv0r|)');

echo $pay->getHtmlForm([
    'payment'     => 'CC',
    'amount'      => '1.99',
    'currency'    => 'UAH',
    'description' => 'Test description',
    'url'         => 'http://exmple.com',
]);
```