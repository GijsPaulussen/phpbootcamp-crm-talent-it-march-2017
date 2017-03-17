<?php

namespace Company\Entity;


class Company implements CompanyInterface
{
    /**
     * @var int
     */
    protected $companyId;

    /**
     * @var string
     */
    protected $companyName;

    /**
     * @var array
     */
    protected $images = [];

    /**
     * Company constructor.
     * @param int $companyId
     * @param string $companyName
     */
    public function __construct($companyId = 0, $companyName = '')
    {
        $this->companyId = $companyId;
        $this->companyName = $companyName;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param int $companyId
     * @return Company
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = (int) $companyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return Company
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array $images
     * @return Company
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

}