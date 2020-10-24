<?php
namespace Cogensoft\ApiLogger\Model\ResourceModel;

class ApiLog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	const TABLE = 'cogensoft_api_log';

	/**
	 * Resource initialization
	 *
	 * @return void
	 */
	protected function _construct() {
		$this->_init( self::TABLE, 'id' );
	}
}