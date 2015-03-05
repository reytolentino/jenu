<?php


class Web2Market_Report_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_sqlQueryResults;
 protected $_gridConfig = null;
    public function __construct()
    {
        parent::__construct();
		
        $this->setId('reportsGrid');
        $this->setDefaultSort('report_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        
	
		
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->unsetChild('search_button');
        $this->unsetChild('reset_filter_button');

        return $this;
    }

    /**
     * @return Clean_SqlReports_Model_Report
     */
    protected function _getReport()
    {
        return Mage::registry('current_report');
    }


	protected function checkDataValue()
	{
		$array=array();
		$collection=Mage::getModel('queryreport/reportsave')->getCollection();
		foreach($collection as $data)
		{
			$array[]=$data->getDescriptionType();
			$array[]=$data->getQueryType();
			}
		return $array;
		}


	  protected function savedata()
    {
		
		
		
        $query_type   = $this->getFilterData('query_type');
		 $save_report   = $this->getFilterData('save_report');
		 $description_type   = $this->getFilterData('description_type');
		  $report_type   = $this->getFilterData('report_type');
		 		 
	
	
		 if (!(in_array($description_type, $this->checkDataValue())) || !(in_array($query_type, $this->checkDataValue()))) {
		 
		 	if($save_report=='yes')
		 		{
			 	
			 		$savedata=Mage::getModel('queryreport/reportsave');
			 		if($report_type=="")
			 			{
		 	echo "abc";
						$savedata->setData('description_type', $description_type);
      					$savedata->setData('query_type', $query_type);    
	    				$savedata->save();
						
					$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'http' : 'https';
$currentUrl = $protocol."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

						
						
						$reporturl=	Mage::helper("adminhtml")->getUrl("adminhtml/report/index");
							$message="Your Report have been saved successfully,please check in dropdown.";	
						Mage::getSingleton('core/session')->addSuccess($message);
						$savedata->save();
					Mage::app()->getFrontController()->getResponse()->setRedirect($currentUrl);
						}
						else
			 			{
						echo "def";
						$savedata->load($report_type);
						$savedata->setData('description_type', $description_type);
      					$savedata->setData('query_type', $query_type);    
	    				$savedata->save();
						
						$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'http' : 'https';
$currentUrl = $protocol."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

						
						
						$reporturl=	Mage::helper("adminhtml")->getUrl("adminhtml/report/index");
						$message="Your Report have been updated successfully,please check in dropdown.";		
						Mage::getSingleton('core/session')->addSuccess($message);
						$savedata->save();
					Mage::app()->getFrontController()->getResponse()->setRedirect($currentUrl);
						 }
		 	 }
		 }
		 
    }





    /**
     * @author Lee Saferite <lee.saferite@aoe.com>
     * @return Varien_Data_Collection_Db
     */
    protected function _createCollection()
    {
		 $query_type   = $this->getFilterData('query_type');
		 $save_report   = $this->getFilterData('save_report');
		 $description_type   = $this->getFilterData('description_type'); 
		 
	
			
		 	
       $connection = Mage::helper('queryreport')->getDefaultConnection();
            
        $collection = Mage::getModel('queryreport/reportCollection', $connection);
//	$collection->getSelect()->from(new Zend_Db_Expr($query_type));
       // $collection->getSelect()->from(new Zend_Db_Expr("(".$filterData.")"));
$collection->getSelect()->from(new Zend_Db_Expr('(' .$query_type. ')'));
        return $collection;
    }

    /**
     * make an attempt to catch errors loading/preparing grid
     * for instance: if the query contains an `id` column which is non-unique
     * the varien data collection will throw a:
     *  "Item (Varien_Object) with the same id "1" already exist"
     *  exception
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareCollection
     */
    protected function _prepareCollection()
    {
        if (isset($this->_collection)) {
            return $this->_collection;
        }

        $collection = $this->_createCollection();
        $this->setCollection($collection);

        try {
        parent::_prepareCollection();
        }
		 catch (Exception $e) {
            //Mage::getSingleton('adminhtml/session')->addError($this->__('An error occured rendering the grid: ' . $e->getMessage()));
            //Mage::logException($e);
            //abort rendering grid and replace collection with an empty one
            $this->setCollection(new Varien_Data_Collection());
        }
        return $this;
    }
	
	
	    public function getGridConfig()
    {
        if (!$this->_gridConfig) {
            $config = json_decode($this->getData('grid_config'), true);
            if (!is_array($config)) {
                $config = array();
            }
            $this->_gridConfig = Mage::getModel('queryreport/report_gridConfig', $config);
        }
		
        return $this->_gridConfig;
    }

    protected function _prepareColumns()
    {
		 $query_type   = $this->getFilterData('query_type');
		 if($query_type!=''){
		$this->savedata();
        try {
            $collection = $this->_createCollection();
            $collection->setPageSize(1);
            $collection->load();
        } catch (Exception $e) {


            Mage::getSingleton('adminhtml/session')->addError($this->__('An error occured rendering the grid: ' . $e->getMessage()));
			
			$reporturl=	Mage::helper("adminhtml")->getUrl("adminhtml/report/index");
Mage::app()->getFrontController()->getResponse()->setRedirect($reporturl);
            Mage::logException($e);
			
			
            $collection = new Varien_Data_Collection();
        }
	
       // $config     = $this->_getReport()->getGridConfig();
		
        $filterable = array();
        $items      = $collection->getItems();
        if (count($items)) {
            $item = reset($items);
            foreach ($item->getData() as $key => $val) {
                $isFilterable = false;
                if (isset($filterable[$key])) {
                    $isFilterable = $filterable[$key];
                } elseif (in_array($key, $filterable)) {
                    $isFilterable = 'adminhtml/widget_grid_column_filter_text';
                }
                $this->addColumn(
                    $key,
                    array(
                        'header'   => Mage::helper('core')->__($key),
                        'index'    => $key,
                        'filter'   => $isFilterable,
                        'sortable' => true,
                    )
                );
            }
        }

        return parent::_prepareColumns();
		}
    }
}
