<?php declare(strict_types=1);
/**
 * This file is part of CREY Framework.
 * (c) 2016 Matthias Kaschubowski, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Crey\Guardian;


use Crey\Guardian\Abstracts\AbstractRole;
use SplObjectStorage;

/**
 * Class Role
 *
 * @package grey.guardian
 * @author Matthias Kaschubowski
 */
class Role extends AbstractRole
{
    /**
     * class constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->inheritedRoles = new SplObjectStorage();
    }

    /**
     * returns the name of the role
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}