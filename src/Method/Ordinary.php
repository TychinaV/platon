<?php

namespace Platon\Method;

use InvalidArgumentException;


/**
 * Class Ordinary
 * @package Platon\Method
 */
class Ordinary extends Method
{

    /**
     * @var string
     */
    protected $data;

    /**
     * @return array
     */
    public function getInputParams()
    {
        $result = [];

        $this->verify();
        $this->setEncData();

        $result['data'] = $this->data;

        foreach ($this->params as $k => $v) {
            if (in_array($k, ['amount', 'currency', 'description', 'recurring'])) {
                continue;
            }
            $result[$k] = $v;
        }

        return $result;
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function verify()
    {
        foreach (['payment', 'amount', 'currency', 'description', 'url'] as $k) {
            if (!isset($this->params[$k]) || empty($this->params[$k])) {
                throw new InvalidArgumentException("Empty parameter: $k");
            }
        }

        if (!preg_match('/^\d{1,6}\.\d{2}$/', $this->params['amount'])) {
            throw new InvalidArgumentException("Invalid amount");
        }

        if (!preg_match('/^[A-Z]{3}$/', $this->params['currency'])) {
            throw new InvalidArgumentException("Invalid currency");
        }

    }

    /**
     *
     */
    protected function setEncData()
    {
        $arr = [
            'amount' => $this->params['amount'],
            'currency' => $this->params['currency'],
            'description' => $this->params['description'],
        ];

        if (!empty($this->params['recurring'])) {
            $arr['recurring'] = 'recurring';
        }

        $this->data = base64_encode(json_encode($arr));
    }

    /**
     * @param $key
     * @param $password
     * @return string
     */
    public function getSign($key, $password)
    {
        $sign = md5(strtoupper(
            strrev($key)
            . strrev($this->params['payment'])
            . strrev($this->data)
            . strrev($this->params['url'])
            . strrev($password)
        ));
        return $sign;

    }
}
