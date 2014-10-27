<?php
/**
 * Created by PhpStorm.
 * User: ind
 * Date: 10/26/14
 * Time: 9:22 PM
 */
class ReviewController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function reviewAction()
    {
        $form = new Application_Form_Review();
        $this->view->form = $form;


        $pid = $this->_request->getParam('pid');

        $reviewDb = new Application_Model_DbTable_Reviews();
        $this->view->item = $reviewDb->getReviewsByItem($pid);

    }


}