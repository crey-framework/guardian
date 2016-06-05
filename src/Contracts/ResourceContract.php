<?php
/**
 * This file is part of CREY Framework.
 * (c) 2016 Matthias Kaschubowski, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Crey\Guardian\Contracts;

use Iterator;

/**
 * Interface ResourceContract
 *
 * @package grey.guardian
 * @author Matthias Kaschubowski
 */
interface ResourceContract
{
    /**
     * returns the name of the resource
     *
     * @return string
     */
    public function getName(): string;

    /**
     * returns a container of roles associated with the granted actions.
     *
     * @param string $action
     * @return RoleContract
     */
    public function getActionRole(string $action): RoleContract;

    /**
     * returns an Iterator of role actions bound to their names.
     *
     * @return Iterator
     */
    public function getActionIterator(): Iterator;

    /**
     * grants ( adds ) a role to specific actions
     *
     * @param RoleContract $role
     * @param \string[] ...$actions
     * @throws \Exception if not action was given
     * @return mixed
     */
    public function grant(RoleContract $role, string ... $actions);

    /**
     * denies ( removes ) a role specific action access. If no action was given,
     * the access to all actions will be denied.
     *
     * @param RoleContract $role
     * @param \string[] ...$actions
     * @return mixed
     */
    public function deny(RoleContract $role, string ... $actions);

    /**
     * checks whether the specified role has access to the provided actions. If no action
     * is provided a general access check will detect if at least one action is accessible
     * for the specified role.
     *
     * @param RoleContract $role
     * @param \string[] ...$actions
     * @return bool
     */
    public function allows(RoleContract $role, string ... $actions): bool;
}