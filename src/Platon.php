<?php

namespace Platon;

use InvalidArgumentException;
use Platon\Method;

class Platon
{

    private $actionUrl = 'https://secure.platononline.com/payment/auth';

    private $key;

    private $password;

    private $method;

    public function __construct($key, $password)
    {
        $this->key = $key;
        $this->password = $password;
    }

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

    protected function setMethod($params)
    {
        if (empty($params['payment'])) {
            throw new InvalidArgumentException("Empty parameter: payment");
        }

        $this->method = new Method\Ordinary($params);
    }

    public function setActionUrl($url)
    {
        $this->actionUrl = $url;
    }
}
