<?php
/** This script is part of the Crosssale project **/
/** septsite.pl | szokart.eu **/
class Szokart_Crosssell_IndexController extends Mage_Core_Controller_Front_Action
{

public function indexAction()
{
$this->loadLayout();     
$this->renderLayout();
}
}