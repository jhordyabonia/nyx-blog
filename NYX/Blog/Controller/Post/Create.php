<?php
declare(strict_types=1);

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace NYX\Blog\Controller\Post;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use NYX\Blog\Model\PostFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

use Magento\Framework\Message\ManagerInterface;
use NYX\Blog\Model\CommentFactory;
use NYX\Blog\Model\ImageUploader;

class Create implements HttpPostActionInterface, CsrfAwareActionInterface
{
    private $error = false;
    public function __construct(
        private PostFactory $postFactory,
        private RequestInterface $request,
        private DataPersistorInterface $dataPersistor,
        private ManagerInterface $messageManager,
        private CommentFactory $commentFactory,
        private Context $context,
        private JsonFactory $jsonResultFactory,
        private ImageUploader $imageUploader,
    ) {}

    /**
     * validateData function
     * Extra validations to test
     *
     * @return array
     */
    private function validateData(){
        $data = json_decode($this->request->getContent(),true);

        if(!isset($data['post_title'])){
            $this->error = __("error, title is should empty!");
        }

        if(!isset($data['post_email'])){
            $this->error = __("error, email is should empty!");
        }
        
        if(!isset($data['post_details'])){
            $this->error = __("error, comment is should empty!");
        }
        if($this->error){
            $this->messageManager->addErrorMessage($this->error);
            return false;
        }
        $data['post_is_active'] = 1;

        unset($data['form_key']);
        return $data;
    }
    /**
     * Show Blog page
     */
    public function execute(){        
        
        $data = $this->validateData();        
        if(!$data){
            return $this->jsonResultFactory->create()->setData(['ok'=>false,'message'=>$this->error]);                       
        }

        $post = $this->postFactory->create();
        $post->setData($data);

        try{
            $post->save();
            $this->messageManager->addSuccessMessage(__("Success! Post saved, await up it  review"));
            $this->dataPersistor->set('post',$post->getData());
            if(isset($data['post_file'])){
                $this->imageUploader->saveFileToTmpDir('post_file');
            }
        }catch(\Exception $e){
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->jsonResultFactory->create()->setData(['ok'=>false,'message'=>$e->getMessage()]);        
        }        
        return $this->jsonResultFactory->create()->setData(['ok'=>true,'message'=>'Success! Post saved, await up it  review']);              
    }

    public function _isAllowed(){
        return $this->_authorization->isAllowed('NYX_Blog::save');
    }

    public function createCsrfValidationException(RequestInterface $request): ? InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
