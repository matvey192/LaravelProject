<?php

namespace Tests\Unit;

use App\Enums\PlatformEnum;
use App\Enums\ProjectStatusEnum;
use PHPUnit\Framework\TestCase;

class EnumsTest extends TestCase
{
    /** @test */
    public function testPlatformEnumReturnsAllValues()
    {
        $values = PlatformEnum::getValues();

        $this->assertContains('WordPress', $values);
        $this->assertContains('Bitrix', $values);
        $this->assertContains('Custom', $values);
        $this->assertContains('Other', $values);

        $this->assertCount(4, $values);
    }

    /** @test */
    public function testStatusEnumReturnsAllValues()
    {
        $values = ProjectStatusEnum::getValues();

        $this->assertContains('development', $values);
        $this->assertContains('production', $values);
        $this->assertContains('maintenance', $values);
        $this->assertContains('archived', $values);

        $this->assertCount(4, $values);
    }

    /** @test */
    public function testPlatformEnumHasValidValues()
    {
        $this->assertTrue(PlatformEnum::isValid('WordPress'));
        $this->assertFalse(PlatformEnum::isValid('NotExists'));
    }

    /** @test */
    public function testProjectStatusEnumHasValidValues()
    {
        $this->assertTrue(ProjectStatusEnum::isValid('production'));
        $this->assertFalse(ProjectStatusEnum::isValid('broken-status'));
    }
}
