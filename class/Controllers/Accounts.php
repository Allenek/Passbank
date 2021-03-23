<?php
namespace Controllers;
use \Tools\FlashMessage;
/**
 *
 */
class Accounts extends GlobalController  {
  /**
   * [getPasswords description]
   * @return [type] [description]
   */
  public function getPasswords()  {
    $this->view->setTemplate('Account/getPasswords');
    $this->view->addCSSSet(array('datatables.min'));
    $model = $this->createModel('Accounts');
    $data['data'] = $model->selectPasswords();
    return $data;
  }
  /**
   * [ajaxAddAccountForm description]
   * @return [type] [description]
   */
  public function ajaxAddAccountForm()
  {
    $this->view->setTemplate('ajaxModals/addAccount');
    $this->view->addCSSSet(array('assets/css/icon-captcha.min.css'));
  }
  /**
   * [addAccount description]
   */
  public function addAccount() {
    $model= $this->createModel('Accounts');
    if ($model->passwordVerify($this->getPost('main-password'))) {
      $model->insertAccount($this->getPost('website'),
                            $this->getPost('login'),
                            $this->getPost('password'));
    }
    $this->redirect('');
  }
  public function ajaxDecryptPassword($id)
  {
    $model = $this->createModel('Accounts');
    $data['data'] = $model->selecteOneById($id);
    $this->view->setTemplate('ajaxModals/showPassword');
    $this->view->addJSSet(array('decrypt-password'));
    return $data;
  }
  public function delete($id) {
      $this->deleteOne($id);
      $this->redirect('');
    }
}
