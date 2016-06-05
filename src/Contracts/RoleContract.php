<?php
/**
 * This file is part of CREY Framework.
 * (c) 2016 Matthias Kaschubowski, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Crey\Guardian\Contracts;


interface RoleContract
{
    /**
     * returns the name of the role
     *
     * @return string
     */
    public function getName(): string;

    /**
     * inherits roles
     *
     * @param RoleContract[] ...$roles
     * @return mixed
     */
    public function inherit(RoleContract ... $roles);

    /**
     * checks whether this role inherits the given role or not.
     *
     * @param RoleContract $role
     * @return bool
     */
    public function inheritsFrom(RoleContract $role): bool;

    /**
     * Removes the inheritance of a specific role.
     *
     * @param RoleContract $role
     * @return mixed
     */
    public function forget(RoleContract $role);

    /**
     * checks whether this role has access to a resource, optionally provided action strings
     * filter this check to the given actions only. No given actions provides a general check
     * that does return true when only one action in the resource was granted to this role.
     *
     * @param ResourceContract $resource
     * @param \string[] ...$actions
     * @return mixed
     */
    public function hasAccessTo(ResourceContract $resource, string ... $actions);
}