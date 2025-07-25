<?php

namespace Pengxul\Supports\Tests;

use PHPUnit\Framework\TestCase;
use Pengxul\Supports\Collection;

class CollectionTest extends TestCase
{
    protected array $data = [];

    protected Collection $collection;

    protected function setUp(): void
    {
        $this->data = [
            'name' => 'yansongda',
            'age' => 26,
            'sex' => 1,
            'language' => [
                'php',
                'java',
                'rust',
            ],
        ];
        $this->collection = new Collection($this->data);
    }

    public function testToString()
    {
        $json = json_encode($this->data);

        self::assertEquals($json, $this->collection->toJson());
        self::assertEquals($json, $this->collection->__toString());
    }

    public function testMagicGet()
    {
        self::assertEquals('yansongda', $this->collection->name);
        self::assertEqualsCanonicalizing(['php', 'java', 'rust'], $this->collection->language);
    }

    public function testMagicSet()
    {
        $this->collection->fuck = 'ok';
        $this->collection->foo = ['bar', 'fuck'];

        self::assertEquals('ok', $this->collection->get('fuck'));
        self::assertEquals(['bar', 'fuck'], $this->collection->get('foo'));
    }

    public function testIsset()
    {
        self::assertTrue(isset($this->collection['name']));
        self::assertFalse(isset($this->collection['notExistKey']));
    }

    public function testUnset()
    {
        unset($this->collection['name']);

        self::assertFalse(isset($this->collection['name']));
    }

    public function testAll()
    {
        self::assertEquals($this->data, $this->collection->all());
    }

    public function testOnly()
    {
        self::assertEquals([
            'name' => 'yansongda',
        ], $this->collection->only(['name']));
    }

    public function testExcept()
    {
        self::assertEquals([
            'name' => 'yansongda',
            'age' => 26,
            'sex' => 1,
        ], $this->collection->except('language')->all());
    }

    public function testMerge()
    {
        $merge = ['haha' => 'enen'];

        self::assertEqualsCanonicalizing(array_merge($this->data, $merge), $this->collection->merge($merge)->all());
    }

    public function testIsEmpty()
    {
        self::assertTrue((new Collection())->isEmpty());
    }

    public function testIsNotEmpty()
    {
        self::assertTrue($this->collection->isNotEmpty());
    }

    public function testToJson()
    {
        $array = ['name' => 'yansongda', 'age' => 29];
        $str = '{"name":"yansongda","age":29}';

        self::assertEquals($str, Collection::wrap($array)->toJson());
    }

    public function testToXml()
    {
        $xml = '<xml><name><![CDATA[yansongda]]></name><age>29</age></xml>';
        $array = ['name' => 'yansongda', 'age' => 29];

        self::assertEquals($xml, Collection::wrap($array)->toXml());
    }

    public function testWrapJson()
    {
        $array = ['name' => 'yansongda', 'age' => 29];
        $str = '{"name":"yansongda","age":29}';
        self::assertEquals($array, Collection::wrapJson($str)->all());

        $str = '"json: cannot unmarshal string into Go struct field CreateOrderReq.total_amount of type int64"';
        self::assertEquals([], Collection::wrapJson($str)->all());
    }

    public function testWrapXml()
    {
        $array = ['name' => 'yansongda', 'age' => 29];
        $str = '<xml><name><![CDATA[yansongda]]></name><age>29</age></xml>';

        self::assertEquals($array, Collection::wrapXml($str)->all());
    }

    public function testWrapQuery()
    {
        $array = ['name' => 'yansongda', 'age' => 29];
        $str = 'name=yansongda&age=29';

        self::assertEquals($array, Collection::wrapQuery($str)->all());
    }

    public function testWrapQuerySpace()
    {
        $array = ['name' => 'yan+song+da', 'age' => 29];
        $str = 'name=yan+song+da&age=29';

        self::assertEquals($array, Collection::wrapQuery($str, true)->all());
    }

    public function testWrapQueryRaw()
    {
        $str = "accessType=0&bizType=000000&encoding=utf-8&merId=777290058167151&orderId=refundpay20240105165842&origQryId=052401051658427862748&queryId=052401051658427863998&respCode=00&respMsg=成功[0000000]&signMethod=01&txnAmt=1&txnSubType=00&txnTime=20240105165842&txnType=04&version=5.1.0&signPubKeyCert=-----BEGIN CERTIFICATE-----\r\nMIIEYzCCA0ugAwIBAgIFEDkwhTQwDQYJKoZIhvcNAQEFBQAwWDELMAkGA1UEBhMC\r\nQ04xMDAuBgNVBAoTJ0NoaW5hIEZpbmFuY2lhbCBDZXJ0aWZpY2F0aW9uIEF1dGhv\r\ncml0eTEXMBUGA1UEAxMOQ0ZDQSBURVNUIE9DQTEwHhcNMjAwNzMxMDExOTE2WhcN\r\nMjUwNzMxMDExOTE2WjCBljELMAkGA1UEBhMCY24xEjAQBgNVBAoTCUNGQ0EgT0NB\r\nMTEWMBQGA1UECxMNTG9jYWwgUkEgT0NBMTEUMBIGA1UECxMLRW50ZXJwcmlzZXMx\r\nRTBDBgNVBAMMPDA0MUA4MzEwMDAwMDAwMDgzMDQwQOS4reWbvemTtuiBlOiCoeS7\r\nveaciemZkOWFrOWPuEAwMDAxNjQ5NTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCC\r\nAQoCggEBAMHNa81t44KBfUWUgZhb1YTx3nO9DeagzBO5ZEE9UZkdK5+2IpuYi48w\r\neYisCaLpLuhrwTced19w2UR5hVrc29aa2TxMvQH9s74bsAy7mqUJX+mPd6KThmCr\r\nt5LriSQ7rDlD0MALq3yimLvkEdwYJnvyzA6CpHntP728HIGTXZH6zOL0OAvTnP8u\r\nRCHZ8sXJPFUkZcbG3oVpdXQTJVlISZUUUhsfSsNdvRDrcKYY+bDWTMEcG8ZuMZzL\r\ng0N+/spSwB8eWz+4P87nGFVlBMviBmJJX8u05oOXPyIcZu+CWybFQVcS2sMWDVZy\r\nsPeT3tPuBDbFWmKQYuu+gT83PM3G6zMCAwEAAaOB9DCB8TAfBgNVHSMEGDAWgBTP\r\ncJ1h6518Lrj3ywJA9wmd/jN0gDBIBgNVHSAEQTA/MD0GCGCBHIbvKgEBMDEwLwYI\r\nKwYBBQUHAgEWI2h0dHA6Ly93d3cuY2ZjYS5jb20uY24vdXMvdXMtMTQuaHRtMDkG\r\nA1UdHwQyMDAwLqAsoCqGKGh0dHA6Ly91Y3JsLmNmY2EuY29tLmNuL1JTQS9jcmw3\r\nNTAwMy5jcmwwCwYDVR0PBAQDAgPoMB0GA1UdDgQWBBTmzk7XEM/J/sd+wPrMils3\r\n9rJ2/DAdBgNVHSUEFjAUBggrBgEFBQcDAgYIKwYBBQUHAwQwDQYJKoZIhvcNAQEF\r\nBQADggEBAJLbXxbJaFngROADdNmNUyVxPtbAvK32Ia0EjgDh/vjn1hpRNgvL4flH\r\nNsGNttCy8afLJcH8UnFJyGLas8v/P3UKXTJtgrOj1mtothv7CQa4LUYhzrVw3UhL\r\n4L1CTtmE6D1Kf3+c2Fj6TneK+MoK9AuckySjK5at6a2GQi18Y27gVF88Nk8bp1lJ\r\nvzOwPKd8R7iGFotuF4/8GGhBKR4k46EYnKCodyIhNpPdQfpaN5AKeS7xeLSbFvPJ\r\nHYrtBsI48jUK/WKtWBJWhFH+Gty+GWX0e5n2QHXHW6qH62M0lDo7OYeyBvG1mh9u\r\nQ0C300Eo+XOoO4M1WvsRBAF13g9RPSw=\r\n-----END CERTIFICATE-----&signature=c++EAuubwRkvr2MVyM9zyjbdH3RMRK/L1ttftpJ4fkl4ZSY1BjyRbTj5fx/2+Z/eH4dqPNfFEQt8egVVWhF/k7PaD8tLTaueeUIPwyjnEIWmqNtVbJtzKexCouGc8wtYDHZYxTJTgo6BW7GEgO5xD6Qpxq801Bb9Zto8uhn4BUP4HI7UsxHHIzP9JYhL2cqz2B8gb3AJHpLMEBpYv+Kb3mwq8ZFgpGaieCAFFGGWImUx1+MgCzLFoe3SKlTF13nbr39Cd3AHuDJnbN+uG1N6AwUtLu12Zzq/6SM+/dqiE0v5SpvB/PeRj9KQeiGDRg/ho9larqB+D3y0FjU13EeHng==";

        $wrapQuery = Collection::wrapQuery($str, true)->all();

        self::assertIsObject(openssl_pkey_get_public($wrapQuery['signPubKeyCert']));
    }
}
