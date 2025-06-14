<?php

class MsisdnTest extends PHPUnit_Framework_TestCase
{
    protected $validMobileNumbers = [
        '09171231234',
        '0917-123-1234',
        '63917-123-1234',
        '+63-917-123-1234',
        '+63.917.123.1234 ',
        '+639171231234',
        ' +639171231234  ',
    ];

    protected $invalidMobileNumbers = [
        '0918123123',
        '+6391812312345',
        '',
    ];

    public function testValidNumbers()
    {
        foreach ($this->validMobileNumbers as $mobileNumber) {
            $this->assertTrue(Alfan06\MsisdnPh\Msisdn::validate($mobileNumber),
                'Mobile number "' . $mobileNumber . '" should be valid.');
        }
    }

    public function testInvalidNumbers()
    {
        foreach ($this->invalidMobileNumbers as $mobileNumber) {
            $this->assertFalse(Alfan06\MsisdnPh\Msisdn::validate($mobileNumber),
                'Mobile number "' . $mobileNumber . '" should be invalid.');
        }
    }

    /**
     * @expectedException \Alfan06\MsisdnPh\Exceptions\InvalidMsisdnException
     */
    public function testExceptionInConstructor()
    {
        foreach ($this->invalidMobileNumbers as $mobileNumber) {
            new \Alfan06\MsisdnPh\Msisdn($mobileNumber);
        }
    }

    public function testFormattedNumbers()
    {
        $mobileNumber = '+63917123-1234';

        $msisdn = new \Alfan06\MsisdnPh\Msisdn($mobileNumber);

        $this->assertEquals('09171231234', $msisdn->get());

        $this->assertEquals('+639171231234', $msisdn->get(true));

        $this->assertEquals('0917-123-1234', $msisdn->get(false, '-'));

        $this->assertEquals('+63 917 123 1234', $msisdn->get(true, ' '));
    }

    public function testPrefix()
    {
        $mobileNumber = '09173231234';

        $msisdn = new \Alfan06\MsisdnPh\Msisdn($mobileNumber);

        $this->assertEquals('917', $msisdn->getPrefix());
    }

    public function testOperator()
    {
        $globeMsisdn = new \Alfan06\MsisdnPh\Msisdn('09255231234');

        $smartMsisdn = new \Alfan06\MsisdnPh\Msisdn('09191231234');

        $sunMsisdn = new \Alfan06\MsisdnPh\Msisdn('09251231234');

        $ditoMsisdn = new \Alfan06\MsisdnPh\Msisdn('09911231234');

        $gomoMsisdn = new \Alfan06\MsisdnPh\Msisdn('09761231234');

        $unknownMsisdn = new \Alfan06\MsisdnPh\Msisdn('08881231234');

        $this->assertEquals('GLOBE', $globeMsisdn->getOperator());

        $this->assertEquals('SMART', $smartMsisdn->getOperator());

        $this->assertEquals('SUN', $sunMsisdn->getOperator());

        $this->assertEquals('DITO', $ditoMsisdn->getOperator());

        $this->assertEquals('GOMO', $gomoMsisdn->getOperator());

        $this->assertEquals('UNKNOWN', $unknownMsisdn->getOperator());
    }
}
