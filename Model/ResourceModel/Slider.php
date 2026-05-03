<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\Store;

class Slider extends AbstractDb
{
    private const STORE_TABLE = 'wapplersystems_featuredslider_slider_store';

    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct(): void
    {
        $this->_init('wapplersystems_featuredslider_slider', 'slider_id');
    }

    protected function _afterLoad(AbstractModel $object): self
    {
        $object->setData('stores', $this->lookupStoreIds((int)$object->getId()));
        return parent::_afterLoad($object);
    }

    protected function _afterSave(AbstractModel $object): self
    {
        $stores = (array)$object->getStores();
        if (empty($stores)) {
            $stores = [Store::DEFAULT_STORE_ID];
        }
        $connection = $this->getConnection();
        $table = $this->getTable(self::STORE_TABLE);
        $connection->delete($table, ['slider_id = ?' => (int)$object->getId()]);
        $rows = [];
        foreach ($stores as $storeId) {
            $rows[] = ['slider_id' => (int)$object->getId(), 'store_id' => (int)$storeId];
        }
        if ($rows) {
            $connection->insertMultiple($table, $rows);
        }
        return parent::_afterSave($object);
    }

    public function lookupStoreIds(int $sliderId): array
    {
        $connection = $this->getConnection();
        return $connection->fetchCol(
            $connection->select()
                ->from($this->getTable(self::STORE_TABLE), 'store_id')
                ->where('slider_id = ?', $sliderId)
        );
    }
}
