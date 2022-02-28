<?php

namespace Magenest\Router\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;

class CustomNoRoute extends Action
{
    /**
     * @var RedirectFactory
     */
    protected $redirectFactory;

    /**
     * CustomNoRoute constructor.
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardFactory
     * @param Context $context
     */
    public function __construct(
        RedirectFactory $redirectFactory,
        Context $context
    ) {
        $this->redirectFactory = $redirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->redirectFactory->create()
            ->setPath('no-route');
    }
}
