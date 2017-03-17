<?php

namespace Company\Model;


use Company\Entity\CompanyInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CompanyModel implements CompanyModelInterface
{
    const TABLE_NAME = 'company';

    /**
     * @var AdapterInterface
     */
    protected $db;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var CompanyInterface
     */
    protected $companyPrototype;

    /**
     * CompanyModel constructor.
     *
     * @param AdapterInterface $db
     * @param HydratorInterface $hydrator
     * @param CompanyInterface $companyPrototype
     */
    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, CompanyInterface $companyPrototype)
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->companyPrototype = $companyPrototype;
    }

    /**
     * @inheritdoc
     */
    public function fetchAllCompanies($companyId)
    {
        $sql = new Sql($this->db);
        $select = $sql->select(self::TABLE_NAME);
        $select->where(['company_id = ?' => $companyId]);
        $select->order(['company_name']);

        $resultSet = new HydratingResultSet($this->hydrator, $this->companyPrototype);

        $adapter = new DbSelect($select, $this->db, $resultSet);
        $paginator = new Paginator($adapter);

        return $paginator;
    }

}