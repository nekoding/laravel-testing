<?php

namespace Tests\Unit\Helper;

use App\Helpers\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{

    public function test_add_function()
    {
        $result = Math::add(1, 2);
        $this->assertEquals(3, $result);
        $this->assertIsInt($result);
    }

    public function test_add_multiple_parameter()
    {
        $result = Math::add(1, 2, 3, 4);
        $this->assertEquals(10, $result);
        $this->assertIsInt($result);
    }

    public function test_add_error_when_receive_string_as_parameter()
    {
        $this->expectError();
        $result = Math::add("test");
    }

    public function test_add_receive_decimal_number()
    {
        $result = Math::add(10.2, 1.4);
        $this->assertEquals(11.6, $result);
        $this->assertIsFloat($result);
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_add($nilai1, $nilai2, $hasil, $tipedata)
    {
        $result = Math::add($nilai1, $nilai2);
        $this->assertEquals($hasil, $result);
        $this->assertEquals($tipedata, gettype($result));
    }

    public function dataProvider()
    {
        return [
            [1, 2, 3, "integer"],
            [1, 4, 5, "integer"],
            [1.5, 4.5, 6.0, "double"],
            [1.2, 4.2, 5.4, "double"],
            [1, 4.2, 5.2, "double"],
        ];
    }
}
