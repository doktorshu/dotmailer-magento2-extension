<?php

namespace Dotdigitalgroup\Email\Model\Config\Source\Datamapping;

class Datafields implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Dotdigitalgroup\Email\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * Configuration structure.
     *
     * @var \Magento\Config\Model\Config\Structure
     */
    protected $_configStructure;

    /**
     * Datafields constructor.
     *
     * @param \Magento\Framework\Registry                $registry
     * @param \Dotdigitalgroup\Email\Helper\Data         $data
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Dotdigitalgroup\Email\Helper\Data $data,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_helper = $data;
        $this->_registry = $registry;
        $this->_storeManager = $storeManager;
    }

    /**
     *  Datafields option.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $fields = [];
        //default data option
        $fields[] = ['value' => '0', 'label' => '-- Please Select --'];

        $apiEnabled = $this->_helper->isEnabled($this->_helper->getWebsite());
        if ($apiEnabled) {
            $savedDatafields = $this->_registry->registry('datafields');

            //get saved datafileds from registry
            if ($savedDatafields) {
                $datafields = $savedDatafields;
            } else {
                //grab the datafields request and save to register
                $client = $this->_helper->getWebsiteApiClient();
                $datafields = $client->getDatafields();
                $this->_registry->register('datafields', $datafields);
            }

            //set the api error message for the first option
            if (isset($datafields->message)) {
                //message
                $fields[] = [
                    'value' => 0,
                    'label' => $datafields->message,
                ];
            } else {
                //loop for all datafields option
                foreach ($datafields as $datafield) {
                    if (isset($datafield->name)) {
                        $fields[] = [
                            'value' => $datafield->name,
                            'label' => $datafield->name,
                        ];
                    }
                }
            }
        }

        return $fields;
    }
}
