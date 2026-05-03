<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class ProductSearch extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slide';
    private const LIMIT = 20;

    public function __construct(
        Context $context,
        private readonly CollectionFactory $productCollectionFactory,
        private readonly ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $product = $this->productRepository->getById((int)$id);
                return $resultJson->setData(['items' => [[
                    'id' => (int)$product->getId(),
                    'sku' => (string)$product->getSku(),
                    'name' => (string)$product->getName(),
                ]]]);
            } catch (\Throwable $e) {
                return $resultJson->setData(['items' => []]);
            }
        }

        $query = trim((string)$this->getRequest()->getParam('q', ''));

        $collection = $this->productCollectionFactory->create()
            ->addAttributeToSelect(['name', 'sku'])
            ->setPageSize(self::LIMIT)
            ->setCurPage(1);

        if ($query !== '') {
            $collection->addAttributeToFilter([
                ['attribute' => 'name', 'like' => '%' . $query . '%'],
                ['attribute' => 'sku', 'like' => '%' . $query . '%'],
            ]);
        }

        $items = [];
        foreach ($collection as $product) {
            $items[] = [
                'id' => (int)$product->getId(),
                'sku' => (string)$product->getSku(),
                'name' => (string)$product->getName(),
            ];
        }

        return $resultJson->setData(['items' => $items]);
    }
}
