<?php

namespace Company\Entity;


use Zend\Hydrator\HydratorInterface;

class CompanyHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if (!$object instanceof CompanyInterface) {
            return [];
        }

        return [
            'company_id' => $object->getCompanyId(),
            'company_name' => $object->getCompanyName(),
        ];
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
            $object->setCompanyId($data['company_id']);
        }

        if ($this->propertyAvailable('company_name', $data)) {
            $object->setFirstName($data['company_name']);
        }

        return $object;
    }

    private function propertyAvailable($property, $data)
    {
        return (array_key_exists($property, $data) && !empty($data[$property]));
    }

}

