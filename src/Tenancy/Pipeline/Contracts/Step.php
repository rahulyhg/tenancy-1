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

namespace Tenancy\Pipeline\Contracts;

interface Step
{
    /**
     * At what priority the Step has to be executed.
     * Lower means sooner. Higher is later.
     * Tenancy framework uses -100 to 100, check
     * the documentation for more about this.
     *
     * @return int
     */
    public function priority(): int;

    public function for($event);

    /**
     * Whether the Step has to fire. Can be toggled
     * of based on the Event the Step is handling.
     *
     * @return bool
     */
    public function fires(): bool;

    /**
     * Executes the logic.
     */
    public function fire(): void;
}
