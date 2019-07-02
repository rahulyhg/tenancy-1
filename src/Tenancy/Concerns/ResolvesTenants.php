<?php declare(strict_types=1);

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

namespace Tenancy\Concerns;

use Tenancy\Identification\Contracts\ResolvesTenants as Resolver;

trait ResolvesTenants
{
    protected function tenantResolver(): Resolver
    {
        return resolve(Resolver::class);
    }
}
