<?php

namespace Dotdigitalgroup\Email\Block\Adminhtml\Dashboard;

class Configuration extends \Magento\Config\Block\System\Config\Edit
{

    /**
     * @var
     */
    protected $originalParams;

    /**
     * Configuration constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Config\Model\Config\Structure  $configStructure
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Config\Model\Config\Structure $configStructure,
        array $data = []
    ) {
        parent::__construct($context, $configStructure, $data);

        $this->_prepareRequestParams();
        $this->setTitle(__('dotmailer Configuration'));
        $this->_resetRequestParams();
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->_prepareRequestParams();
        parent::_prepareLayout();
       // $this->_resetRequestParams();

        return $this;
    }

    /**
     *
     */
    protected function _prepareRequestParams()
    {
        $this->originalParams = $this->getRequest()->getParam('section');
        
        $this->getRequest()->setParam('section', 'connector_developer_settings');
    }

    /**
     *
     */
    protected function _resetRequestParams()
    {
        $this->getRequest()->setParam('section', $this->originalParams);
    }

    /**
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('adminhtml/system_config/save', ['section' => 'connector_developer_settings']);
    }

}