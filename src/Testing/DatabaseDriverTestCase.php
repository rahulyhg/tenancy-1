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

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use InvalidArgumentException;
use PDO;
use PDOException;
use Tenancy\Facades\Tenancy;
use Tenancy\Identification\Contracts\ResolvesTenants;
use Tenancy\Tenant\Events\Created;
use Tenancy\Tenant\Events\Deleted;
use Tenancy\Tenant\Events\Updated;
use Tenancy\Testing\Mocks\Tenant;

abstract class DatabaseDriverTestCase extends TestCase
{
    protected $db;
    protected $tenant;
    public $tenantModel = Tenant::class;
    public $pdo = true;

    protected function afterSetUp()
    {
        $this->registerModel();
        $this->db = resolve(DatabaseManager::class);

        $this->tenant = factory($this->tenantModel)->create([
            'id' => 1803,
        ]);
        $this->tenant->unguard();

        $this->resolveTenant($this->tenant);
    }

    protected function getTenantConnection()
    {
        Tenancy::getTenant();

        return $this->db->connection(Tenancy::getTenantConnectionName());
    }

    protected function getSystemConnection()
    {
        return $this->db->connection($this->tenant->getManagingSystemConnection());
    }

    protected function registerModel()
    {
        /** @var ResolvesTenants $resolver */
        $resolver = $this->app->make(ResolvesTenants::class);
        $resolver->addModel($this->tenantModel);
    }

    /**
     * @test
     */
    public function returns_valid_config()
    {
        Tenancy::getTenant();

        $this->assertInstanceOf(
            Connection::class,
            $this->getTenantConnection()
        );
    }

    /**
     * @test
     */
    public function runs_create()
    {
        $this->events->dispatch(new Created($this->tenant));

        if (in_array(ManagesSystemConnection::class, class_implements($this->tenant))) {
            $system = $this->getSystemConnection();
            $query = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?';
            $this->assertNotEmpty($system->select($query, [$this->tenant->getTenantIdentifier()]));
        }

        $this->assertInstanceOf(
            PDO::class,
            $this->getTenantConnection()->getPdo()
        );

        $this->db->purge(Tenancy::getTenantConnectionName());

        // Not an actual test, but delete the updated tenant for cleaning purposes
        $this->events->dispatch(new Deleted($this->tenant));
    }

    /**
     * @test
     */
    public function prevent_same_update()
    {
        $this->events->dispatch(new Updated($this->tenant));

        $this->expect_exception();
        $this->getTenantConnection()->getPdo();
    }

    /**
     * @test
     */
    public function runs_update()
    {
        $this->events->dispatch(new Created($this->tenant));

        $this->tenant->id = 1997;
        $this->events->dispatch(new Updated($this->tenant));

        $this->assertInstanceOf(
            PDO::class,
            $this->getTenantConnection()->getPdo()
        );

        $this->db->purge(Tenancy::getTenantConnectionName());

        // Not an actual test, but delete the updated tenant for cleaning purposes
        $this->events->dispatch(new Deleted($this->tenant));
    }

    /**
     * @test
     */
    public function runs_delete()
    {
        $this->events->dispatch(new Created($this->tenant));
        $this->events->dispatch(new Deleted($this->tenant));

        $this->expect_exception();
        $this->getTenantConnection()->getPdo();
    }

    public function expect_exception()
    {
        if ($this->pdo) {
            $this->expectException(PDOException::class);
        } else {
            $this->expectException(InvalidArgumentException::class);
        }
    }
}
