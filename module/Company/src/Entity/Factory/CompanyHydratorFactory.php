<?php

namespace Company\Entity\Factory;


use Company\Entity\CompanyHydrator;
use Company\Entity\CompanyImageHydrator;
use Company\Model\ImageModelInterface;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Hydrator\Aggregate\AggregateHydrator;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class CompanyHydratorFactory
{
    /**
     * @var AggregateHydrator
     */
    protected $hydrator;

    public function __invoke(
        ImageModelInterface $imageModel
    )
    {
        return $this->prepareHydrator(
            $imageModel
        );
    }

    /**
     * Prepare the hydrator to allow aggregated hydrations
     *
     * @param ImageModelInterface $imageModel
     * @return AggregateHydrator
     */
    public function prepareHydrator(
        ImageModelInterface $imageModel
    )
    {
        $this->hydrator = new AggregateHydrator();
        $contactHydrator = new CompanyHydrator();

        $this->hydrator->add($contactHydrator);
        
        $this->hydrator->add(
            new CompanyImageHydrator($imageModel)
        );

        return $this->hydrator;
    }
}

