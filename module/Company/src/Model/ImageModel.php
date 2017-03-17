<?php

namespace Company\Model;


use Company\Entity\ImageInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class ImageModel implements ImageModelInterface
{
    const TABLE_NAME = 'company_image';

    /**
     * @var AdapterInterface
     */
    private $db;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var ImageInterface
     */
    private $imagePrototype;

    /**
     * ImageModel constructor.
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param ImageInterface $imagePrototype
     */
    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, ImageInterface $imagePrototype)
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->imagePrototype = $imagePrototype;
    }

    /**
     * @inheritDoc
     */
    public function fetchAllImages($companyId)
    {
        $sql = new Sql($this->db);
        $select = $sql->select(self::TABLE_NAME);
        $select->where(['company_id = ?' => $companyId]);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \DomainException('Cannot find images for given company');
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->imagePrototype);
        $resultSet->initialize($result);

        if (!$resultSet) {
            throw new \RuntimeException('Cannot process image data for this company');
        }

        return $resultSet;
    }

    /**
     * @inheritDoc
     */
    public function findImageById($companyId, $imageId)
    {
        $sql = new Sql($this->db);
        $select = $sql->select(self::TABLE_NAME);
        $select->where([
            'company_id = ?' => $companyId,
            'company_image_id = ?' => $imageId,
        ]);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \DomainException('Cannot find images for given company');
        }
        return $this->hydrator->hydrate($result->current(), $this->imagePrototype);
    }

    /**
     * @inheritDoc
     */
    public function saveImage(ImageInterface $image)
    {
        if (0 < (int) $image->getCompanyImageId()) {
            return $this->updateImage($image);
        }
        return $this->insertImage($image);
    }

    /**
     * @inheritDoc
     */
    public function deleteImage(ImageInterface $image)
    {
        // TODO: Implement deleteImage() method.
    }

    /**
     * Update existing Image
     *
     * @param ImageInterface $image
     * @return ImageInterface
     * @throws \RuntimeException
     */
    private function updateImage(ImageInterface $image)
    {
        $date = date('Y-m-d H:i:s');
        $imageData = $this->hydrator->extract($image);
        unset (
            $imageData['company_id'],
            $imageData['company_image_id'],
            $imageData['created']
        );
        $imageData['modified'] = $date;

        $sql = new Sql($this->db);
        $update = new Update(self::TABLE_NAME);
        $update->set($imageData);
        $update->where([
            'company_id = ?' => $image->getCompanyId(),
            'company_image_id = ?' => $image->getCompanyImageId()
        ]);

        $stmt = $sql->prepareStatementForSqlObject($update);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Cannot store the company image');
        }
        return $image;
    }

    /**
     * Insert new Image
     *
     * @param ImageInterface $image
     * @return ImageInterface
     * @throws \RuntimeException
     */
    private function insertImage(ImageInterface $image)
    {
        $date = date('Y-m-d H:i:s');
        $imageData = $this->hydrator->extract($image);
        unset (
            $imageData['company_image_id']
        );
        $imageData['created'] = $imageData['modified'] = $date;

        $sql = new Sql($this->db);
        $insert = new Insert(self::TABLE_NAME);
        $insert->values($imageData);

        $stmt = $sql->prepareStatementForSqlObject($insert);
        $result = $stmt->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException('Cannot store the company image');
        }
        return $image->setCompanyImageId($result->getGeneratedValue());
    }
}