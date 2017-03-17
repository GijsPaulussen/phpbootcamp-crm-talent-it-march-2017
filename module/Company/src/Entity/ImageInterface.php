<?php

namespace Company\Entity;


interface ImageInterface extends CompanyAwareInterface
{
    /**
     * @return int
     */
    public function getCompanyImageId();

    /**
     * @return string
     */
    public function getImageLink();

    /**
     * @return bool
     */
    public function isImageActive();
}