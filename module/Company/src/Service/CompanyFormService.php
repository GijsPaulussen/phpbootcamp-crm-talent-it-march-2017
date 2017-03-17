<?php

namespace Company\Service;


use Company\Entity\CompanyInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Stdlib\Parameters;

class CompanyFormService implements CompanyFormServiceInterface
{
    /**
     * @var CompanyInterface
     */
    protected $companyPrototype;

    /**
     * @var HydratorInterface
     */
    protected $companyHydrator;


    /**
     * CompanyFormService constructor.
     * @param CompanyInterface $companyPrototype
     * @param HydratorInterface $companyHydrator
     */
    public function __construct(CompanyInterface $companyPrototype, HydratorInterface $companyHydrator)
    {
        $this->companyPrototype = $companyPrototype;
        $this->companyHydrator = $companyHydrator;
    }

    /**
     * @inheritdoc
     */
    public function processFormData(Parameters $data)
    {
        $companyData = $data->offsetGet('company-fieldset');
        $company = $this->companyHydrator->hydrate($companyData, clone $this->companyPrototype);

        return $company;
    }
}