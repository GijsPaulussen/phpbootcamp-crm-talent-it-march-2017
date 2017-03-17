<?php

namespace Company\Entity;


use Zend\Hydrator\HydratorInterface;

class ImageHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if (!$object instanceof ImageInterface) {
            return [];
        }

        return [
            'company_image_id' => $object->getCompanyImageId(),
            'company_id' => $object->getCompanyId(),
            'image_link' => $object->getImageLink(),
            'image_active' => $object->isImageActive() ? 1 : 0,
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof ImageInterface) {
            return $object;
        }

        if ($this->propertyAvailable('company_image_id', $data)) {
            $object->setCompanyImageId($data['company_image_id']);
        }

        if ($this->propertyAvailable('company_id', $data)) {
            $object->setCompanyId($data['company_id']);
        }

        if ($this->propertyAvailable('image_link', $data)) {
            $object->setImageLink($data['image_link']);
        }

        if ($this->propertyAvailable('image_active', $data)) {
            $object->setImageActive((1 === (int) $data['image_active']));
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }
}