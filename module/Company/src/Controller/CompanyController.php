<?php

namespace Company\Controller;


use Company\Model\CompanyModelInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CompanyController extends AbstractActionController
{
    /**
     * @var CompanyModelInterface
     */
    private $companyModel;

    /**
     * CompanyController constructor.
     *
     * @param CompanyModelInterface $companyModel
     */
    public function __construct(
        CompanyModelInterface $companyModel
    )
    {
        $this->companyModel = $companyModel;
    }

    public function indexAction()
    {
        return $this->redirect()->toRoute('company/overview', ['page' => 1]);
    }

    public function overviewAction()
    {
        $page = $this->params()->fromRoute('page', 1);
        $companyId = $this->identity()->getCompanyId();

        $companies = $this->companyModel->fetchAllCompanies($companyId);

        $viewModel = [
            'companies' => $companies,
            'page' => $page,
        ];

        return new ViewModel($viewModel);
    }
}