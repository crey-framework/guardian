<?php
/**
 * This file is part of CREY Framework.
 * (c) 2016 Matthias Kaschubowski, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Crey\Guardian;


use Crey\Guardian\Contracts\ResourceContract;
use Crey\Guardian\Contracts\RoleContract;
use Iterator;

/**
 * Class Resource
 *
 * @package grey.guardian
 * @author Matthias Kaschubowski
 */
class Resource implements ResourceContract
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ResourceRole[]
     */
    private $roles;

    public function __construct(string $name, string ... $actions)
    {
        $this->name = $name;
        $this->roles = $this->marshalRoleStorage(... $actions);
    }

    /**
     * returns the name of the resource
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * returns a container of roles associated with the granted actions.
     *
     * @param string $action
     * @return RoleContract
     */
    public function getActionRole(string $action): RoleContract
    {
        if ( ! array_key_exists($action, $this->roles) ) {
            throw new \LogicException("unknown action: `{$action}`");
        }

        return $this->roles[$action];
    }

    /**
     * returns an Iterator of role actions bound to their names.
     *
     * @return Iterator
     */
    public function getActionIterator(): Iterator
    {
        yield from $this->roles;
    }

    /**
     * grants ( adds ) a role to specific actions
     *
     * @param RoleContract $role
     * @param \string[] ...$actions
     * @throws \Exception if not action was given
     * @return mixed
     */
    public function grant(RoleContract $role, string ... $actions)
    {
        if ( empty($actions) ) {
            throw new \LogicException('You must specify actions to grant');
        }

        foreach ( $actions as $current ) {
            $actionRole = $this->getActionRole($current);

            $role->inherit($actionRole);
        }
    }

    /**
     * denies ( removes ) a role specific action access. If no action was given,
     * the access to all actions will be denied.
     *
     * @param RoleContract $role
     * @param \string[] ...$actions
     * @return mixed
     */
    public function deny(RoleContract $role, string ... $actions)
    {
        if ( empty($actions) ) {
            $actions = array_keys($this->roles);
        }

        foreach ( $actions as $current ) {
            $actionRole = $this->getActionRole($current);
            $role->forget($actionRole);
        }
    }

    /**
     * checks whether the specified role has access to the provided actions. If no action
     * is provided a general access check will detect if at least one action is accessible
     * for the specified role.
     *
     * @param RoleContract $role
     * @param \string[] ...$actions
     * @return bool
     */
    public function allows(RoleContract $role, string ... $actions): bool
    {
        if ( empty($actions) ) {
            foreach ( $this->getActionIterator() as $actionRole ) {
                if ( $role->inheritsFrom($actionRole) ) {
                    return true;
                }
            }

            return false;
        }

        foreach ( $actions as $current ) {
            $actionRole = $this->getActionRole($current);

            if ( ! $role->inheritsFrom($actionRole) ) {
                return false;
            }
        }

        return true;
    }

    /**
     * marshals the action role storage
     *
     * @param \string[] ...$actions
     * @return array
     */
    protected function marshalRoleStorage(string ... $actions)
    {
        if ( empty($actions) ) {
            throw new \LogicException('you must specify actions');
        }

        $storage = [];

        foreach ( $actions as $current ) {
            $storage[$current] = new ResourceRole($current, $this);
        }

        return $storage;
    }

}