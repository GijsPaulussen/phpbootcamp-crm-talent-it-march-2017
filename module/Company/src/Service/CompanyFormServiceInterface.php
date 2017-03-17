<?php

namespace Company\Service;


use Company\Entity\CompanyInterface;
use Zend\Stdlib\Parameters;

interface CompanyFormServiceInterface
{
    /**
     * Process form data
     *
     * @param Parameters $data
     * @return CompanyInterface
     */
    public function processFormData(Parameters $data);
}