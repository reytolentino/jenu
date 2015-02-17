<?php
class MD_Partialpayment_Model_Payment_Authorizenetcim extends MD_Partialpayment_Model_Payment_Authorizenet
{
    protected $_paymentModel = array(
        Gorilla_AuthorizenetCim_Model_Gateway::METHOD_CODE => 'authorizenetcim/gateway',
    );
    
    public function pay($details){
        $responseMessages = array();
        $gorillaHelper = Mage::helper('authorizenetcim');
        $payments = $this->getPayments();
        $summary = $this->getSummary();
        $order = $this->getOrder();
        $methodObject = Mage::getModel($this->_paymentModel[$details['method']]);
        $soap_env = $this->_buildRequest($details, $methodObject);
        if(is_array($soap_env) && count($soap_env) > 0)
        {
            
            $response = $this->_postRequest($soap_env, $methodObject);
            
        switch ($response->getResponseCode()) {
                    case Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_CODE_APPROVED:
                        $text = $gorillaHelper->__('successful');
                        $summary->setPaidDate(date('Y-m-d'))
                                        ->setStatus(MD_Partialpayment_Model_Summary::PAYMENT_SUCCESS)
                                        ->setTransactionId($response->getTransactionId())
                                        ->setPaymentMethod(Gorilla_AuthorizenetCim_Model_Gateway::METHOD_CODE)
                                        ->setPaymentFailCount($summary->getPaymentFailCount() + 0)
                                        ->setTransactionDetails(serialize($response->getData()));
                                 
                                     $payments->setPaidAmount($payments->getPaidAmount() + $response->getAmount())
                                        ->setDueAmount(max(0,($payments->getDueAmount() - $response->getAmount())))
                                        ->setLastInstallmentDate(date('Y-m-d'))
                                        ->setPaidInstallments($payments->getPaidInstallments() + 1)
                                        ->setDueInstallments(max(0,($payments->getDueInstallments() - 1)))
                                        ->setUpdatedAt(Mage::getSingleton('core/date')->gmtDate());
                                     
                                    if($payments->getDueInstallments() > 0){
                                        $orderDueAmount = max(0,($order->getTotalDue() - $response->getAmount()));
                                        $baseOrderDueAmount = max(0,($order->getBaseTotalDue() - $response->getAmount()));
                                    }else{
                                        $orderDueAmount = 0;
                                        $baseOrderDueAmount = 0;
                                    }
                                     
                                     $order->setTotalPaid($order->getTotalPaid() + $response->getAmount())
                                        ->setBaseTotalPaid($order->getBaseTotalPaid() + $response->getAmount())
                                        ->setTotalDue($orderDueAmount)
                                        ->setBaseTotalDue($baseOrderDueAmount);
                                    $responseMessages['success'] = $gorillaHelper->__('Payment Processed Successfully.');
                        break;
                    case Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_CODE_DECLINED:
                    case Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_CODE_ERROR:
                        $text = $gorillaHelper->__('failed');
                                 $summary->setPaidDate(date('Y-m-d'))
                                        ->setStatus(MD_Partialpayment_Model_Summary::PAYMENT_FAIL)
                                        ->setTransactionId($response->getTransactionId())
                                        ->setPaymentMethod(Gorilla_AuthorizenetCim_Model_Gateway::METHOD_CODE)
                                        ->setPaymentFailCount($summary->getPaymentFailCount() + 1)
                                        ->setTransactionDetails(serialize($response->getData()));
                                 $responseMessages['error'] = $response->getResponseReasonText();
                        break;
                    default:
                           break;
                }
                if(strlen($text) > 0){
                        $operation = ($paymentAction == Mage_Payment_Model_Method_Abstract::ACTION_AUTHORIZE) ? 'authorize': 'authorize and capture';
                            $amount = $gorillaHelper->__('amount %s',$order->formatPrice($response->getAmount()));
                            $card = $gorillaHelper->__('Credit Card: xxxx-%s', $response->getCcLast4());
                            $transactionString = $gorillaHelper->__('Authorize.Net CIM Transaction ID %s', $response->getTransactionId());
                            $statusHistryText = $gorillaHelper->__('%s %s %s - %s. %s. %s', $card, strip_tags($amount), $operation, $text, $transactionString, $response->getResponseReasonText());
                            $order->addStatusHistoryComment($statusHistryText);
                            $transaction = Mage::getModel('core/resource_transaction');
                            $transaction->addObject($summary);
                            $transaction->addObject($payments);
                            $transaction->addObject($order);
                            try{
                                $transaction->save();
                                $summary->sendStatusPaymentEmail(true,true);
                            }catch(Exception $e){
                                Mage::getSingleton('core/session')->addError($e->getMessage());
                            }
                    }
                if(array_key_exists('success', $responseMessages)){
                    Mage::getSingleton('core/session')->addSuccess($responseMessages['success']);
                }elseif(array_key_exists('notice', $responseMessages)){
                    Mage::getSingleton('core/session')->addError($responseMessages['notice']);
                }elseif(array_key_exists('error', $responseMessages)){
                    Mage::getSingleton('core/session')->addError($responseMessages['error']);
                }
        }
        return $this;
    }
    
    public function _buildRequest($data, $methodObject){
        
        $payments = $this->getPayments();
        $soap_env = array();
        $summary = $this->getSummary();
        $customer = Mage::getModel('customer/customer')->setStoreId($payments->getStoreId())->load($payments->getCustomerId());
        $resource = Mage::getSingleton('core/resource');
        $tableName = $resource->getTableName('authorizenetcim/profile');
        $isTestMode = (boolean)$methodObject->getConfigData('test',$payments->getStoreId());
        $apiLoginId = ($isTestMode) ? $methodObject->getConfigData('test_login',$payments->getStoreId()): $methodObject->getConfigData('login',$payments->getStoreId());
        $transactionKey = ($isTestMode) ? $methodObject->getConfigData('test_trans_key',$payments->getStoreId()): $methodObject->getConfigData('trans_key',$payments->getStoreId());
        $paymentAction = $methodObject->getConfigData('payment_action',$payments->getStoreId());
        $anetTransType = ($paymentAction == Mage_Payment_Model_Method_Abstract::ACTION_AUTHORIZE) ? Gorilla_AuthorizenetCim_Model_Profile::TRANS_AUTH_ONLY: Gorilla_AuthorizenetCim_Model_Profile::TRANS_AUTH_CAPTURE;
         
        if(isset($data['authorizenetcim_payment_id']) && strlen($data['authorizenetcim_payment_id']) > 0){
            $paymentProfileId = $data['authorizenetcim_payment_id'];
            
            
            $readAdapter = $resource->getConnection('core_read');
            
            $query = "SELECT `gateway_id` FROM `".$tableName."` WHERE `customer_id`='".$payments->getCustomerId()."' AND `default_payment_id`='".$paymentProfileId."'";
            if($isTestMode){
                $query .= " AND `is_test_mode`='1' LIMIT 1";
            }else{
                $query .= " AND `is_test_mode`='0' LIMIT 1";
            }
            
            $customerProfileId = $readAdapter->fetchOne($query);
            if(strlen($customerProfileId) <= 0){
                $customerProfileId = $payments->getOrder()->getPayment()->getAuthorizenetcimCustomerId();
            }
        }else{
            $soap_envReq = array(
                Gorilla_AuthorizenetCim_Model_Profile::TRANS_CREATE_CUSTOMER =>  array(
                    'merchantAuthentication' => array(
                            'name' => $apiLoginId,
                            'transactionKey' => $transactionKey
                        ),
                    'profile' => array(
                    'merchantCustomerId' => $payments->getCustomerId(),
                    'description' => Mage::getBaseUrl() . ": " . $payments->getCustomerEmail() . " : " . now(), //Base URL + Description + timestamp to avoid duplicates
                    'email' => $payments->getCustomerEmail(),
                    'paymentProfiles' => array(
                        array(
                            'customerType' => 'individual',
                            'billTo' => array(
                                'firstName' => $customer->getFirstname(),
                                'lastName' => $customer->getLastname(),
                                'company' => $customer->getCompany(),
                                'address' => $customer->getAddress(),
                                'city' => $customer->getCity(),
                                'state' => $customer->getState(),
                                'zip' => $customer->getZip(),
                                'country' => $customer->getCountry(),
                                'phoneNumber' => $customer->getPhoneNumber(),
                                'faxNumber' => $customer->getFaxNumber(),
                            ),
                            'payment' => array(
                                'creditCard' => array(
                                    'cardNumber' => $data['cc_number'],
                                    'expirationDate' => sprintf('%04d-%02d', $data['cc_exp_year'], $data['cc_exp_month']),
                                )
                            ) 
                        )
                    )
                ) 
                ),
            );
            if(in_array('cc_cid',$data) && strlen($data['cc_cid']) > 0){
                $soap_envReq[Gorilla_AuthorizenetCim_Model_Profile::TRANS_CREATE_CUSTOMER]['profile']['paymentProfiles'][0]['payment']['creditCard']['cardCode'] = $data['cc_cid'];
            }
            $soap_envReq[Gorilla_AuthorizenetCim_Model_Profile::TRANS_CREATE_CUSTOMER]['validationMode'] = Gorilla_AuthorizenetCim_Model_Gateway::VALIDATION_MODE_NONE;
            $profileCreateResponse = Mage::getSingleton('authorizenetcim/profile')->doCall(Gorilla_AuthorizenetCim_Model_Profile::TRANS_CREATE_CUSTOMER, $soap_envReq);
            
            
            if($profileCreateResponse && $profileCreateResponse->CreateCustomerProfileResult->resultCode == 'Ok'){
                $customerProfileId = $profileCreateResponse->CreateCustomerProfileResult->customerProfileId;
                $paymentProfileId = $profileCreateResponse->CreateCustomerProfileResult->customerPaymentProfileIdList->long;
                
                if($data['cc_save_card'] == 'Yes'){
                    $writeAdapter = $resource->getConnection('core_write');
                    $insertQuery = "INSERT INTO `".$tableName."`(customer_id,gateway_id,default_payment_id,is_test_mode) VALUES('".$payments->getCustomerId()."','".$customerProfileId."','".$paymentProfileId."','".(int)$isTestMode."')";
                    try{
                        $writeAdapter->query($insertQuery);
                    }catch(Exception $e){
                        Mage::getSingleton('core/session')->addError($e->getMessage());
                    }
                }
                
            }else{
                Mage::getSingleton('core/session')->addError($profileCreateResponse->messages->text);
            }
        }
        if(strlen($customerProfileId) > 0 && strlen($paymentProfileId) > 0){
                $soap_env = array(
                    Gorilla_AuthorizenetCim_Model_Profile::TRANS_CREATE_TRANS => array(
                        'merchantAuthentication' => array(
                            'name' => $apiLoginId,
                            'transactionKey' => $transactionKey
                        ),
                        'transaction' => array(
                            $anetTransType => array(
                                'amount' => $summary->getAmount(),
                                'tax'=>array(
                                    'amount' => 0
                                ),
                                'shipping'=>array(
                                    'amount' => 0  
                                ),
                                'customerProfileId' => $customerProfileId,
                                'customerPaymentProfileId' => $paymentProfileId,
                                'order' => array(
                                    'invoiceNumber' => $payments->getOrderId().'-'.$summary->getId()
                                )
                            ),
                        ),
                        'extraOptions' => 'x_delim_char='.  Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_DELIM_CHAR . '&x_duplicate_window=' . $methodObject->getConfigData('transaction_timeout',$payments->getStoreId()),
                        'x_duplicate_window' => $methodObject->getConfigData('transaction_timeout',$payments->getStoreId())
                    )
                );
        }  
            return $soap_env;
    }
    
    public function _postRequest($soap_env){
        try{      
                $directResponse = Mage::getSingleton('authorizenetcim/profile')->doCall(Gorilla_AuthorizenetCim_Model_Profile::TRANS_CREATE_TRANS, $soap_env);
                $responseBody = $directResponse->CreateCustomerProfileTransactionResult->directResponse;       
        }catch(Exception $e){
            $responseBody = false;
            echo $e->getMessage().'<br />';
        }
        $result = null;
        if($responseBody){
            
            $r = explode(Gorilla_AuthorizenetCim_Model_Gateway::RESPONSE_DELIM_CHAR, $responseBody);
            if ($r) {
                $result = Mage::getModel('authorizenetcim/gateway_result');
                        $result->setResponseCode((int)str_replace('"','',$r[0]))
                               ->setResponseSubcode((int)str_replace('"','',$r[1]))
                                ->setResponseReasonCode((int)str_replace('"','',$r[2]))
                                ->setResponseReasonText($r[3])->setApprovalCode($r[4])->setAvsResultCode($r[5])
                                ->setTransactionId($r[6])->setInvoiceNumber($r[7])->setDescription($r[8])
                                ->setAmount($r[9])->setMethod($r[10])->setTransactionType($r[11])
                                ->setCustomerId($r[12])->setMd5Hash($r[37])->setCardCodeResponseCode($r[38])
                                ->setCAVVResponseCode( (isset($r[39])) ? $r[39] : null)->setSplitTenderId($r[52])
                                ->setAccNumber($r[50])->setCardType($r[51])->setRequestedAmount($r[53])
                                ->setBalanceOnCard($r[54])->setCcLast4(substr($r[50], -4));
            }
        }
        return $result;
    }
    
}

