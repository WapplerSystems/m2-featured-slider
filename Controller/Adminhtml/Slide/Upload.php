<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Upload extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slide';
    public const UPLOAD_PATH = 'wapplersystems/featuredslider';

    public function __construct(
        Context $context,
        private readonly UploaderFactory $uploaderFactory,
        private readonly Filesystem $filesystem,
        private readonly StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);

            $mediaDir = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $result = $uploader->save($mediaDir->getAbsolutePath(self::UPLOAD_PATH));
            $relPath = self::UPLOAD_PATH . '/' . ltrim($result['file'], '/');
            $result['url'] = $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $relPath;
            $result['name'] = $relPath;

            return $resultJson->setData($result);
        } catch (\Throwable $e) {
            return $resultJson->setData(['error' => $e->getMessage(), 'errorcode' => $e->getCode()]);
        }
    }
}
