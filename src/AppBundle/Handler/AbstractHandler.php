<?php

/**
 * Abstract handler
 *
 * @category Handler
 * @package  AppBundle\Handler
 * @author   username <username@example.com>
 * @license  http:// no licence
 * @link     handler
 */

namespace AppBundle\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractHandler
 *
 * @category Handler
 * @package  AppBundle\Handler
 * @author   username <username@example.com>
 * @license  http:// no licence
 * @link     handler
 */
abstract class AbstractHandler
{
    /**
     * Variable
     *
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * Variable
     *
     * @var Form
     */
    protected $form;

    /**
     * Variable
     *
     * @var mixed
     */
    protected $data;

    /**
     * Process
     *
     * @param $param null
     *
     * @return mixed
     */
    abstract protected function process($param = null);

    /**
     * Get form type
     *
     * @return string
     */
    abstract protected function getFormType();

    /**
     * Set Form Factory
     *
     * @param FormFactoryInterface $formFactory
     *
     * @required
     *
     * @return void
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * Get Data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Handle
     *
     * @param Entity $data
     * @param Request $request
     * @param $param
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
     *
     * @return FormView
     */
    public function createView()
    {
        return $this->form->createView();
    }
}
