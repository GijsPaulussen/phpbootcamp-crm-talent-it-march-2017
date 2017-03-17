<?php

namespace Company\Entity;


interface CompanyAwareInterface
{
    /**
     * Retrieve the sequence ID of a Company entity
     *
     * @return int
     */
    public function getCompanyId();
}