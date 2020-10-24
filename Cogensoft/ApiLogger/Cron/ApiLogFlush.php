<?php

namespace Cogensoft\ApiLogger\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Cogensoft\ApiLogger\Model\ResourceModel\ApiLog\CollectionFactory AS ApiLogCollectionFactory;

class ApiLogFlush
{
	/**
	 * @var ScopeConfigInterface
	 */
	protected $scopeConfig;

	/**
	 * @var \Cogensoft\ApiLogger\Model\ResourceModel\ApiLog\CollectionFactory
	 */
	protected $apiLogCollectionFactory;

	public function __construct(
		ScopeConfigInterface $scopeConfig,
		ApiLogCollectionFactory $apiLogCollectionFactory
	)
	{
		$this->scopeConfig = $scopeConfig;
		$this->apiLogCollectionFactory = $apiLogCollectionFactory;
	}

	public function execute()
	{
		$retentionHistoryDays = (int) $this->scopeConfig->getValue('cogensoft_api_logger/configuration/retain_history');
		if(!$retentionHistoryDays) {
			return true;
		}

		$deleteBefore = new \DateTime();
		$deleteBefore->modify('-'.$retentionHistoryDays. 'days');

		/** @var \Cogensoft\ApiLogger\Model\ResourceModel\ApiLog\Collection $apiLogCollection */
		$apiLogCollection = $this->apiLogCollectionFactory->create();
		$apiLogCollection
			->filterByBeforeStartTime($deleteBefore->format('Y-m-d H:i:s'))
			->walk('delete');
	}
}