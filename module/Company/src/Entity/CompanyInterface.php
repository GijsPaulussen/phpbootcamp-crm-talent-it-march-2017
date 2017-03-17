<?php

namespace Company\Entity;


interface CompanyInterface extends CompanyAwareInterface
{
    /**
     * Retrieve the name from this Company
     *
     * @return string
     */
    public function getCompanyName();
}