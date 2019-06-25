<?php

/*
 * This file is part of the tenancy/tenancy package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see http://laravel-tenancy.com
 * @see https://github.com/tenancy
 */

namespace Tenancy\Database\Drivers\Mysql\Concerns;

interface ManagesSystemConnection
{
    /**
     * Allows overriding the system connection used for the tenant.
     *
     * @return null|string
     */
    public function getManagingSystemConnection(): ?string;
}
