<?php

namespace Platon;

use InvalidArgumentException;
use Platon\Method;

/**
 * Class Platon
 * @package Platon
 */
class Platon
{
    /**
     * @var string
     */
    private $actionUrl = 'https://secure.platononline.com/payment/auth';

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Method\Method
     */
    private $method;

    /**
     * Platon constructor.
     * @param string $key Key of merchant
     * @param string $password Password of merchant
     */
    public function __construct($key, $password)
    {
        $this->key = $key;
        $this->password = $password;
    }

    /**
     * @param array $params
     * @param array $extend Possible keys: form_id, submit_id, submit_text
     * @param bool $showSubmitBtn
     * @return string
     *
     * Example: [
     * 'payment'     => 'CC',
     * 'order'       => 'ORDER-123',                    // optional
     * 'amount'      => 1.05,
     * 'currency'    => 'UAH',
     * 'description' => 'Describe of purchase',
     * 'url'         => 'http://merchant.site/success',
     * 'error_url'   => 'http://merchant.site/error',    // optional
     * 'recurring'   => true,                           // optional
     * 'ext1'        => 'something',                    // optional
     * ....
     * 'ext10'       => 'something',                    // optional
     * 'lang'        => 'en',                           // optional
     * 'formid'      => 'UIYY2H2',                      // optional
     * 'first_name'  => 'John',                         // optional
     * 'last_name'   => 'Doe',                          // optional
     * 'address'     => 'Some location',                // optional
     * 'zip'         => '132456',                       // optional
     * 'city'        => 'Big city',                     // optional
     * 'country'     => 'UA',                           // optional
     * 'phone'       => '0669998877',                   // optional
     * 'email'       => 'example@mail.com',             // optional
     * ]
     */
    public function getHtmlForm($params, $extend = [], $showSubmitBtn = true)
    {
        $this->setMethod($params);

        $inputs = [
            sprintf('<input type="hidden" name="%s" value="%s" />', 'key', $this->key),
        ];

        foreach ($this->method->getInputParams() as $k => $v) {
            $inputs[] = sprintf('<input type="hidden" name="%s" value="%s" />', $k, $v);
        }

        $inputs[] = sprintf(
            '<input type="hidden" name="sign" value="%s" />',
            $this->method->getSign($this->key, $this->password)
        );

        if ($showSubmitBtn) {
            $inputs[] = sprintf(
                '<input type="submit" value="%s" %s />',
                isset($extend['submit_text']) ? $extend['submit_text'] : 'Pay',
                isset($extend['submit_id']) ? sprintf('id="%s"', $extend['submit_id']) : ''
            );
        }

        return sprintf(
            "<form method=\"POST\" action=\"%s\" %s >\n%s\n</form>",
            $this->actionUrl,
            isset($extend['form_id']) ? sprintf('id="%s"', $extend['form_id']) : '',
            implode("\n", $inputs)
        );
    }

    /**
     * @param array $params
     * @throws InvalidArgumentException
     */
    protected function setMethod($params)
    {
        if (empty($params['payment'])) {
            throw new InvalidArgumentException("Empty parameter: payment");
        }

        $this->method = new Method\Ordinary($params);
    }

    /**
     * @param string $url
     */
    public function setActionUrl($url)
    {
        $this->actionUrl = $url;
    }


}
