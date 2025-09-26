<?php

namespace NYX\Blog\Controller\Adminhtml\Comment;

class MassDelete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected', []);
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addError(__('Please select item(s).'));
            return $resultRedirect->setPath('*/*/');
        }
        try {
            foreach ($ids as $id) {
                $model = $this->_objectManager->create(\NYX\Blog\Model\Comment::class);
                $model->load($id);
                $model->delete();
            }
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', count($ids)));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }
}
