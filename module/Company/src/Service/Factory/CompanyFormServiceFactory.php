<?php

namespace Company\Service\Factory;


use Company\Entity\Company;
use Company\Entity\CompanyHydrator;
use Company\Service\CompanyFormService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class CompanyFormServiceFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CompanyFormService(
            new Company(),
            new CompanyHydrator()
        );
    }

}