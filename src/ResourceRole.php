<?php declare(strict_types=1);
/**
 * This file is part of CREY Framework.
 * (c) 2016 Matthias Kaschubowski, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Crey\Guardian;


use Crey\Guardian\Abstracts\AbstractRole;
use Crey\Guardian\Contracts\ResourceContract;
use SplObjectStorage;

/**
 * Class ResourceRole
 *
 * @package grey.guardian
 * @author Matthias Kaschubowski
 */
class ResourceRole extends AbstractRole
{
    /**
     * @var ResourceContract
     */
    private $resource;

    /**
     * class constructor.
     *
     * @param string $name
     * @param ResourceContract $resource
     */
    public function __construct(string $name, ResourceContract $resource)
    {
        $this->name = $name;
        $this->resource = $resource;
        $this->inheritedRoles = new SplObjectStorage();
    }

    /**
     * returns the name of the role
     *
     * @return string
     */
    public function getName(): string
    {
        return "{$this->resource->getName()}:{$this->name}";
    }

    /**
     * Resource getter
     *
     * @return ResourceContract
     */
    public function getResource(): ResourceContract
    {
        return $this->resource;
    }

}