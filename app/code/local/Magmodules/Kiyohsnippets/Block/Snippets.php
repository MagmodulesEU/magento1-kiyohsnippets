<?php
/**
 * Magmodules.eu - http://www.magmodules.eu
 *
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@magmodules.eu so we can send you a copy immediately.
 *
 * @category      Magmodules
 * @package       Magmodules_Kiyohsnippets
 * @author        Magmodules <info@magmodules.eu>
 * @copyright     Copyright (c) 2017 (http://www.magmodules.eu)
 * @license       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Magmodules_Kiyohsnippets_Block_Snippets extends Mage_Core_Block_Template
{

    /**
     * @return mixed
     */
    public function getSnapshopRequest()
    {
        return $this->helper('kiyohsnippets')->getSnapshopRequest();
    }

    /**
     * @return mixed
     */
    public function getKiyohLink()
    {
        return $this->helper('kiyohsnippets')->getKiyohLink();
    }

    /**
     * @param $rating
     *
     * @return mixed
     */
    public function getKiyohStars($rating)
    {
        return $this->helper('kiyohsnippets')->getKiyohStars($rating);
    }

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->addData(array(
            'cache_lifetime' => 7200,
            'cache_tags'     => array(Mage_Cms_Model_Block::CACHE_TAG, 'kiyohsnippets_block'),
            'cache_key'      => 'kiyohsnippets-snippets-block',
        ));
        if (Mage::getStoreConfig('kiyohsnippets/api/enabled')) {
            $snippets = $this->helper('kiyohsnippets')->getSnapshopRequest();
            if ($snippets) {
                $this->setSnippets($snippets);
                $this->setTemplate('magmodules/kiyohsnippets/block.phtml');
            }
        }
    }

}