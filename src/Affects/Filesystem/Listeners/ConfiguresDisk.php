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

namespace Tenancy\Affects\Filesystem\Listeners;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem\FilesystemManager;
use Tenancy\Affects\Filesystem\Events\ConfigureDisk;
use Tenancy\Concerns\DispatchesEvents;
use Tenancy\Contracts\TenantAffectsApp;
use Tenancy\Identification\Events\Switched;

class ConfiguresDisk implements TenantAffectsApp
{
    use DispatchesEvents;

    public function handle(Switched $event): ?bool
    {
        /** @var Factory|FilesystemManager $manager */
        $manager = resolve(Factory::class);
        /** @var Repository $config */
        $config = resolve(Repository::class);

        if ($event->tenant) {
            $diskConfig = [];

            $this->events()->dispatch(new ConfigureDisk($event, $diskConfig));
        }

        // Configure the tenant disk.
        $config->set('filesystems.disks.tenant', $diskConfig ?? null);

        // This demands a reload of the disk.
        $manager->forgetDisk('tenant');

        return null;
    }
}
