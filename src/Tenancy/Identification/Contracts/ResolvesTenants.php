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

namespace Tenancy\Identification\Contracts;

use Illuminate\Database\Eloquent\Model;
use Tenancy\Identification\Support\TenantModelCollection;

interface ResolvesTenants
{
    public function __invoke(): ?Tenant;

    /**
     * Registers a viable tenant model class.
     *
     * @param string $class
     *
     * @return $this
     */
    public function addModel(string $class);

    /**
     * Resolves a tenant model class based on identifier and an
     * instance if the $key argument is provided.
     *
     * @param string     $identifier
     * @param mixed|null $key
     *
     * @return string|Model|null
     */
    public function findModel(string $identifier, $key = null);

    /**
     * Loads all registered tenant models.
     *
     * @return TenantModelCollection
     */
    public function getModels(): TenantModelCollection;

    /**
     * Updates the tenant model collection.
     *
     * @param TenantModelCollection $collection
     *
     * @return $this
     */
    public function setModels(TenantModelCollection $collection);

    /**
     * @param string $contract
     * @param string $method
     *
     * @return $this
     */
    public function registerDriver(string $contract, string $method);
}
