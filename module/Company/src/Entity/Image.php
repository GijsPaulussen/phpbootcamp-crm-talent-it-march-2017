<?php

namespace Company\Entity;


class Image implements ImageInterface
{
    /**
     * @var int
     */
    protected $companyImageId;

    /**
     * @var int
     */
    protected $companyId;

    /**
     * @var string
     */
    protected $imageLink;

    /**
     * @var bool
     */
    protected $imageActive;

    /**
     * Image constructor.
     * @param int $contactImageId
     * @param int $memberId
     * @param int $contactId
     * @param string $imageLink
     * @param bool $imageActive
     */
    public function __construct($companyImageId = 0, $companyId = 0, $imageLink = '', $imageActive = false)
    {
        $this->contactImageId = $companyImageId;
        $this->contactId = $companyId;
        $this->imageLink = $imageLink;
        $this->imageActive = $imageActive;
    }

    /**
     * @return int
     */
    public function getCompanyImageId()
    {
        return $this->companyImageId;
    }

    /**
     * @param int $companyImageId
     * @return Image
     */
    public function setCompanyImageId($companyImageId)
    {
        $this->companyImageId = $companyImageId;
        return $this;
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
     * @return Image
     */
    public function setCompanyId($companyId)
    {
        $this->contactId = $companyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * @param string $imageLink
     * @return Image
     */
    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;
        return $this;
    }

    /**
     * @return bool
     */
    public function isImageActive()
    {
        return $this->imageActive;
    }

    /**
     * @param bool $imageActive
     * @return Image
     */
    public function setImageActive($imageActive)
    {
        $this->imageActive = $imageActive;
        return $this;
    }

}