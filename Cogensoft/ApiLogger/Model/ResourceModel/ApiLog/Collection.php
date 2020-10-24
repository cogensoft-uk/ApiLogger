<?php
namespace Cogensoft\ApiLogger\Model\ResourceModel\ApiLog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Cogensoft\ApiLogger\Model\ApiLog', 'Cogensoft\ApiLogger\Model\ResourceModel\ApiLog');
	}

	public function filterByBeforeStartTime($startTime) {
		$this
			->getSelect()
			->where('start_time < ?', $startTime);

		return $this;
	}
}