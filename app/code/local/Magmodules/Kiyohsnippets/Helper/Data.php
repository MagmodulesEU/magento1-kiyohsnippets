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

class Magmodules_Kiyohsnippets_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * @return array|bool
     */
    function getSnapshopRequest()
    {
        $kiyohShopId = Mage::getStoreConfig('kiyohsnippets/api/shop_id');
        $apiUrl = Mage::getStoreConfig('kiyohsnippets/api/api_url');
        $dataType = Mage::getStoreConfig('kiyohsnippets/api/data_type');
        $textSuffix = Mage::getStoreConfig('kiyohsnippets/api/kiyoh_suffix');

        $filename = 'https://' . $apiUrl . '/widgetfeed.php?company=';

        if (!$kiyohShopId) {
            return false;
        }

        $xml = $this->getXml($filename . $kiyohShopId, 1);

        if (!$xml) {
            return false;
        }

        $xmlData = $xml->channel->description;

        $qty = explode(' ', $xmlData);
        $qty = array_pop($qty);

        if (empty($qty)) {
            return false;
        }

        if (empty($dataType)) {
            $max = '10';
            $data = explode(',', $xmlData);
            $data = explode(' ', $data[0]);
            $data = array_pop($data);
            $percentage = ($data * 10);
        } else {
            $data = '';
            $max = '100';
            if (preg_match("/[0-9]+%/", $xmlData, $matches)) {
                $data = substr($matches[0], 0, -1);
            }
            $percentage = $data;
            $data = $data . '%';
        }

        $snippets = array();
        $snippets['qty'] = $qty;
        $snippets['avg'] = $data;
        $snippets['max'] = $max;
        $snippets['percentage'] = $percentage;
        $snippets['data_type'] = $dataType;
        $snippets['text_suffix'] = $textSuffix;

        return $snippets;
    }

    /**
     * @param     $url
     * @param int $timeout
     *
     * @return bool|SimpleXMLElement
     */
    public function getXml($url, $timeout = 0)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => (int)$timeout));
        if ($xml = curl_exec($ch)) {
            return simplexml_load_string($xml);
        } else {
            return false;
        }
    }

    /**
     * @return bool|mixed
     */
    function getKiyohLink()
    {
        $showLink = Mage::getStoreConfig('kiyohsnippets/api/show_link');

        if (!$showLink) {
            return false;
        }

        $kiyohLink = Mage::getStoreConfig('kiyohsnippets/api/kiyoh_link');
        return $kiyohLink;
    }

    /**
     * @param $rating
     *
     * @return bool|string
     */
    function getKiyohStars($rating)
    {
        $showStars = Mage::getStoreConfig('kiyohsnippets/api/show_stars');
        if (!$showStars) {
            return false;
        }

        $html = '<div class="rating-box">';
        $html .= '	<div class="rating" style="width:' . $rating . '%"></div>';
        $html .= '</div>';

        return $html;
    }

}