<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculationControllerTest extends WebTestCase
{
    public function testCalculation(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $client->submitForm('calculation_calculate', [
            'calculation[value_1]' => '4',
            'calculation[value_2]' => '5',
            'calculation[mathematical_action]' => '+',

        ]);

        $this->assertSelectorExists('div:contains("4 + 5 = 9")');
    }
}
