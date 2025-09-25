<?php
/**
 * User: david
 * Date: 9/28/18
 * Time: 4:42 PM
 */

namespace NYX\Blog\Controller\Adminhtml\Post;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    //const ADMIN_RESOURCE = 'Magento_Cms::page_delete';

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('post_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            $postName = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\NYX\Blog\Model\Post::class);
                $model->load($id);

                $postName = $model->getPostName();
                $model->delete();

                // display success message
                $this->messageManager->addSuccessMessage(__('The post has been deleted.'));


                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a post to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
    public function _isAllowed(){
        return $this->_authorization->isAllowed('NYX_Blog::delete');
    }
}