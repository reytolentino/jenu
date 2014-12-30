<?php

class Gorilla_AuthorizenetCim_Model_Adminhtml_Customer_Edit_Region_Renderer
    implements Varien_Data_Form_Element_Renderer_Interface
{
    static protected $_regionCollections;

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $countryId = false;
        if ($country = $element->getForm()->getElement('country_id')) {
            $countryId = $country->getValue();
        }

        $regionCollection = false;
        if ($countryId) {
            if (!isset(self::$_regionCollections[$countryId])) {
                self::$_regionCollections[$countryId] = Mage::getModel('directory/country')
                    ->setId($countryId)
                    ->getLoadedRegionCollection()
                    ->toOptionArray();
            }
            $regionCollection = self::$_regionCollections[$countryId];

            if (isset($regionCollection[0]) && isset($regionCollection[0]['value'])) {
                if ($regionCollection[0]['value'] == 0) {
                    $regionCollection[0]['value'] = '';
                }
            }
        }

        $regionId = intval($element->getForm()->getElement('region_id')->getValue());

        $htmlAttributes = $element->getHtmlAttributes();
        foreach ($htmlAttributes as $key => $attribute) {
            if ('type' === $attribute) {
                unset($htmlAttributes[$key]);
                break;
            }
        }

        // Output two elements - for 'region' and for 'region_id'.
        // Two elements are needed later upon form post - to properly set data to address model,
        // otherwise old value can be left in region_id attribute and saved to DB.
        // Depending on country selected either 'region' (input text) or 'region_id' (selectbox) is visible to user
        $regionIdHtmlName = 'region_id';
        $regionIdHtmlId = 'region_id';


        $elementClass = $element->getClass();
        $html = '<td class="label">'.$element->getLabelHtml().'</td>';
        $html.= '<td class="value">';

        $html .= '<select id="' . $regionIdHtmlId . '" name="' . $regionIdHtmlName . '" '
            . $element->serialize($htmlAttributes) .'>' . "\n";
        if ($regionCollection && count($regionCollection) > 0) {
            foreach ($regionCollection as $region) {
                $selected = ($regionId==$region['value']) ? ' selected="selected"' : '';
                $html.= '<option value="'.$region['value'].'"'.$selected.'>'.$region['label'].'</option>';
            }
        }
        $html.= '</select>' . "\n";

        $html.= '<input id="region" name="region" value="" type="text" class="input-text"></td>';
        $element->setClass($elementClass);

        $html .= '
                <script type="text/javascript">
                    document.observe("dom:loaded", function() {
                        var updater = new regionUpdater("country_id", "region", "region_id", ' . Mage::helper('directory')->getRegionJson() . ', "hide");
                        updater.update();
                    });
                </script>';
        return $html;
    }
}
