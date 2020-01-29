<h1>Installation</h1>
<h4>Using composer:</h4>

`...`

<h1>Usage</h1>
<h4>List of possible parameters:</h4>
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

<h4>You can add own parameters in html form.</h4>

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