<?php
namespace Cogensoft\ApiLogger\Model;

use Magento\Framework\Model\AbstractModel;

class ApiLog extends AbstractModel {
	const ID = 'id';
	const PATH = 'path';
	const METHOD = 'method';
	const PARAMETERS = 'parameters';
	const IP_ADDRESS = 'ip_address';
	const START_TIME = 'start_time';
	const SUCCESSFUL = 'successful';
	const RESPONSE_CODE = 'response_code';
	const RESPONSE_BODY = 'response_body';
	const EXCEPTION = 'exception';
	const DURATION_IN_SECONDS = 'duration_in_seconds';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	protected function _construct() {
		parent::_construct();
		$this->_init( 'Cogensoft\ApiLogger\Model\ResourceModel\ApiLog' );
	}

	/**
	 * @return integer
	 */
	public function getId() {
		return $this->_getData(self::ID);
	}

	/**
	 * @return $this
	 */
	public function setId( $id )
	{
		return $this->setData(self::ID, $id);
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return $this->_getData(self::PATH);
	}

	/**
	 * @return $this
	 */
	public function setPath( $path )
	{
		return $this->setData(self::PATH, $path);
	}

	/**
	 * @return string
	 */
	public function getMethod() {
		return $this->_getData(self::METHOD);
	}

	/**
	 * @return $this
	 */
	public function setMethod( $method )
	{
		return $this->setData(self::METHOD, $method);
	}

	/**
	 * @return string
	 */
	public function getParameters() {
		return $this->_getData(self::PARAMETERS);
	}

	/**
	 * @return $this
	 */
	public function setParameters( $parameters )
	{
		return $this->setData(self::PARAMETERS, $parameters);
	}

	/**
	 * @return string
	 */
	public function getIpAddress() {
		return $this->_getData(self::IP_ADDRESS);
	}

	/**
	 * @return $this
	 */
	public function setIpAddress( $ipAddress )
	{
		return $this->setData(self::IP_ADDRESS, $ipAddress);
	}

	/**
	 * @return string
	 */
	public function getStartTime() {
		return $this->_getData(self::START_TIME);
	}

	/**
	 * @return $this
	 */
	public function setStartTime( $startTime )
	{
		return $this->setData(self::START_TIME, $startTime);
	}

	/**
	 * @return boolean
	 */
	public function getSuccessful() {
		return $this->_getData(self::SUCCESSFUL);
	}

	/**
	 * @return $this
	 */
	public function setSuccessful( $successful )
	{
		return $this->setData(self::SUCCESSFUL, $successful);
	}

	/**
	 * @return string
	 */
	public function getResponseCode() {
		return $this->_getData(self::RESPONSE_CODE);
	}

	/**
	 * @return $this
	 */
	public function setResponseCode( $responseCode )
	{
		return $this->setData(self::RESPONSE_CODE, $responseCode);
	}

	/**
	 * @return string
	 */
	public function getResponseBody() {
		return $this->_getData(self::RESPONSE_BODY);
	}

	/**
	 * @return $this
	 */
	public function setResponseBody( $responseBody )
	{
		return $this->setData(self::RESPONSE_BODY, $responseBody);
	}

	/**
	 * @return string
	 */
	public function getException() {
		return $this->_getData(self::EXCEPTION);
	}

	/**
	 * @return $this
	 */
	public function setException( $exception )
	{
		return $this->setData(self::EXCEPTION, $exception);
	}

	/**
	 * @return integer
	 */
	public function getDurationInSeconds() {
		return $this->_getData(self::DURATION_IN_SECONDS);
	}

	/**
	 * @return $this
	 */
	public function setDurationInSeconds( $durationInSeconds )
	{
		return $this->setData(self::DURATION_IN_SECONDS, $durationInSeconds);
	}
}