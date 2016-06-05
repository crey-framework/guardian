<?php
/**
 * This file is part of CREY Framework.
 * (c) 2016 Matthias Kaschubowski, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Crey\Guardian\Abstracts;


use Crey\Guardian\Contracts\ResourceContract;
use Crey\Guardian\Contracts\RoleContract;

/**
 * Class AbstractRole
 *
 * @package grey.guardian
 * @author Matthias Kaschubowski
 */
abstract class AbstractRole implements RoleContract
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \SplObjectStorage
     */
    protected $inheritedRoles;

    /**
     * @var \SplObjectStorage
     */
    protected $resources;

    /**
     * returns the name of the role
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * inherits roles
     *
     * @param RoleContract[] ...$roles
     * @return mixed
     */
    public function inherit(RoleContract ... $roles)
    {
        foreach ( $roles as $role ) {
            if ( ! $this->inheritedRoles->contains($role) ) {
                $this->inheritedRoles->attach($role);
            }
        }
    }

    /**
     * Removes the inheritance of a specific role.
     *
     * @param RoleContract $role
     * @return mixed
     */
    public function forget(RoleContract $role)
    {
        if ( $this->inheritedRoles->contains($role) ) {
            $this->inheritedRoles->detach($role);
        }
    }

    /**
     * checks whether this role inherits the given role or not.
     *
     * @param RoleContract $role
     * @return bool
     */
    public function inheritsFrom(RoleContract $role): bool
    {
        if ( ! $this->inheritedRoles->contains($role) ) {
            foreach ( $this->inheritedRoles as $inheritedRole ) {
                /** @var RoleContract $inheritedRole */
                if ( $inheritedRole->inheritsFrom($role) ) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }

    /**
     * checks whether this role has access to a resource, optionally provided action strings
     * filter this check to the given actions only. No given actions provides a general check
     * that does return true when only one action in the resource was granted to this role.
     *
     * @param ResourceContract $resource
     * @param \string[] ...$actions
     * @return mixed
     */
    public function hasAccessTo(ResourceContract $resource, string ... $actions)
    {
        if ( empty($actions) ) {
            foreach ( $resource->getActionIterator() as $action => $role ) {
                if ( $this->inheritsFrom($role) ) {
                    return true;
                }
            }

            return false;
        }

        foreach ( $actions as $action ) {
            $role = $resource->getActionRole($action);

            if ( ! $this->inheritsFrom($role) ) {
                return false;
            }
        }

        return true;
    }

    /**
     * PHP's debug info implementation to cascade the properties to a set of information
     * that are necessary for development
     *
     * @return array
     */
    public function __debugInfo()
    {
        $inheritedRoles = iterator_to_array($this->inheritedRoles);

        $meta = ['name' => $this->getName()];

        if ( ! empty($inheritedRoles) ) {
            $meta['inherited Roles'] = $inheritedRoles;
        }

        return $meta;
    }

}