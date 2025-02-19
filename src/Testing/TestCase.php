<?php

declare(strict_types=1);

/*
 * This file is part of the tenancy/tenancy package.
 *
 * Copyright Laravel Tenancy & Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see http://laravel-tenancy.com
 * @see https://github.com/tenancy
 */

namespace Tenancy\Testing;

use Illuminate\Foundation\Testing;

class TestCase extends Testing\TestCase
{
    use Concerns\CreatesApplication,
        Concerns\InteractsWithTenants,
        Concerns\MocksApplicationServices,
        Testing\RefreshDatabase,
        Concerns\LifecycleHooks;

    protected function beforeBoot()
    {
        // ..
    }

    protected function afterSetUp()
    {
        // ..
    }

    protected function beforeTearDown()
    {
        // ..
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->beforeBoot();
        $this->bootTenancy();
        $this->afterSetUp();
    }

    protected function tearDown(): void
    {
        $this->beforeTearDown();
        $this->tearDownTenancy();

        parent::tearDown();
    }
}
