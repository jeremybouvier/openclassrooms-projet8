<?php

namespace AppBundle\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractHandler
{

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var mixed
     */
    protected $data;

    abstract protected function process($param = null);

    /**
     * @return string
     */
    abstract protected  function getFormType();

    /**
     * @required
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null $data
     * @param Request $request
     * @return bool
     */
    public function handle(Request $request, $data, $param = null)
    {
        $this->data = $data;
        $this->form = $this->formFactory->create($this->getFormType(), $data)->handleRequest($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->process($param);
            return true;
        }
        return false;
    }

    /**
     * Création de la vue du formulaire
     * @return FormView
     */
    public function createView()
    {
        return $this->form->createView();
    }
}
