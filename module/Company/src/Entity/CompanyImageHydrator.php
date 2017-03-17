<?php

namespace Company\Entity;


use Company\Model\ImageModelInterface;
use Zend\Hydrator\HydratorInterface;

class CompanyImageHydrator implements HydratorInterface
{
    /**
     * @var ImageModelInterface
     */
    protected $imageModel;

    /**
     * CompanyImageHydrator constructor.
     * @param ImageModelInterface $imageModel
     */
    public function __construct(ImageModelInterface $imageModel)
    {
        $this->imageModel = $imageModel;
    }

    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof CompanyInterface) {
            return $object;
        }

        if ($this->propertyAvailable('company_id', $data)) {
            $object->setImages(
                $this->imageModel->fetchAllImages($data['company_id'])
            );
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }
}
