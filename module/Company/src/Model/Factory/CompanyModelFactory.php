<?php

namespace Company\Model\Factory;


use Company\Entity\Company;
use Company\Entity\Factory\CompanyHydratorFactory;
use Company\Model\CompanyModel;
use Company\Model\ImageModel;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class CompanyModelFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $imageModel = $container->get(ImageModel::class);

        $companyHydratorFactory = new CompanyHydratorFactory();
        $companyHydrator = $companyHydratorFactory->prepareHydrator(
            $imageModel
        );

        return new CompanyModel(
            $container->get(AdapterInterface::class),
            $companyHydrator,
            new Company()
        );
    }

}