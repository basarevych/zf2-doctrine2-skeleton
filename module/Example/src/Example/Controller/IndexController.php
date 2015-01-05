<?php
/**
 * zf2-skeleton
 *
 * @link        https://github.com/basarevych/zf2-skeleton
 * @copyright   Copyright (c) 2014 basarevych@gmail.com
 * @license     http://choosealicense.com/licenses/mit/ MIT
 */

namespace Example\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Example\Form\EditSampleForm;

/**
 * Index controller
 *
 * @category    Example
 * @package     Controller
 */
class IndexController extends AbstractActionController
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $sl = $this->getServiceLocator();
        $em = $sl->get('Doctrine\ORM\EntityManager');

        $entities = $em->getRepository('Application\Entity\Sample')
                       ->findAll();

        return new ViewModel([
            'entities'  => $entities
        ]);
    }

    /**
     * Create/edit entity form action
     */
    public function editFormAction()
    {
        $sl = $this->getServiceLocator();
        $em = $sl->get('Doctrine\ORM\EntityManager');

        $request = $this->getRequest();

        $formSubmitted = false;
        $form = new EditSampleForm($em);
        $messages = [];

        if ($request->isPost()) {
            $formSubmitted = true;
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                var_dump($data);
            }
        }

        $model = new ViewModel([
            'formSubmitted' => $formSubmitted,
            'form'          => $form,
            'messages'      => $messages,
        ]);
        $model->setTerminal(true);
        return $model;
    }

    /**
     * Validate entity form field action
     */
    public function validateEditFormAction()
    {
        $sl = $this->getServiceLocator();
        $em = $sl->get('Doctrine\ORM\EntityManager');

        $name = $this->params()->fromQuery('name');
        $value = $this->params()->fromQuery('value');

        $form = new EditSampleForm($em);
        $form->setData([ $name => $value ]);
        $form->isValid();

        $control = $form->get($name);
        $messages = $control->getMessages();

        return new JsonModel([
            'valid'     => (count($messages) == 0),
            'messages'  => array_values($messages),
        ]);
    }

    /**
     * This action is called when requested action is not found
     */
    public function notFoundAction()
    {
        throw new \Application\Exception\NotFoundException('Action is not found');
    }
}
