<?php
/**
 * Created by PhpStorm.
 * User: rtolentino
 * Date: 2/23/16
 * Time: 3:38 PM
 */

class Jenu_ReviewForm_Model_Resource_Review extends Mage_Review_Model_Resource_Review
{
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $adapter = $this->_getWriteAdapter();
        /**
         * save detail
         */
        $detail = array(
            'title'     => $object->getTitle(),
            'detail'    => $object->getDetail(),
            'nickname'  => $object->getNickname(),
            'email2'    => $object->getEmail2(),
            'products2'  => $object->getProducts2(),
        );
        $select = $adapter->select()
            ->from($this->_reviewDetailTable, 'detail_id')
            ->where('review_id = :review_id');
        $detailId = $adapter->fetchOne($select, array(':review_id' => $object->getId()));

        if ($detailId) {
            $condition = array("detail_id = ?" => $detailId);
            $adapter->update($this->_reviewDetailTable, $detail, $condition);
        } else {
            $detail['store_id']   = $object->getStoreId();
            $detail['customer_id']= $object->getCustomerId();
            $detail['review_id']  = $object->getId();
            $adapter->insert($this->_reviewDetailTable, $detail);
        }


        /**
         * save stores
         */
        $stores = $object->getStores();
        if (!empty($stores)) {
            $condition = array('review_id = ?' => $object->getId());
            $adapter->delete($this->_reviewStoreTable, $condition);

            $insertedStoreIds = array();
            foreach ($stores as $storeId) {
                if (in_array($storeId, $insertedStoreIds)) {
                    continue;
                }

                $insertedStoreIds[] = $storeId;
                $storeInsert = array(
                    'store_id' => $storeId,
                    'review_id'=> $object->getId()
                );
                $adapter->insert($this->_reviewStoreTable, $storeInsert);
            }
        }

        // reaggregate ratings, that depend on this review
        $this->_aggregateRatings(
            $this->_loadVotedRatingIds($object->getId()),
            $object->getEntityPkValue()
        );

        return $this;
    }

}