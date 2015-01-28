<?php

class Jenu_AdminReports_Adminhtml_SubscribedcustomersController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        //$this->_addContent($this->getLayout()->createBlock('jenu_adminreports/adminhtml_subscribedcustomers'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('jenu_adminreports/adminhtml_subscribedcustomers_grid')->toHtml()
        );
    }

    public function exportCsvAction()
    {
        $fileName = 'subscribedcustomers.csv';
        $content = $this->getLayout()->createBlock('jenu_adminreports/adminhtml_subscribedcustomers_grid')->getCsv();
        $content = strip_tags($content);
        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName = 'subscribedcustomers.xml';
        $content = $this->getLayout()->createBlock('jenu_adminreports/adminhtml_subscribedcustomers_grid')->getXml();
        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $this->getResponse()
            ->setHeader('HTTP/1.1 200 OK', '')
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Cache-Control', 'must-revalidate, postcheck=0, pre-check=0', true)
            ->setHeader('Content-Disposition', 'attachment; filename=' . $fileName)
            ->setHeader('Last-Modified', date('r'))
            ->setHeader('Accept-Ranges', 'bytes')
            ->setHeader('Content-Length', strlen($content))
            ->setHeader('Content-type', $contentType)
            ->setBody($content)
            ->sendResponse();
        die;
    }

}