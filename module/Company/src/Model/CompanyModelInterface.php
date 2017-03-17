<?php

namespace Company\Model;


use Company\Entity\CompanyInterface;
use Zend\Paginator\Paginator;

interface CompanyModelInterface
{
    /**
     * Fetch all companys related to given member ID
     *
     * @param int $memberId
     * @return Paginator
     */
    public function fetchAllCompanys($memberId);

}