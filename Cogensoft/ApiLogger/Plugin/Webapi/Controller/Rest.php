<?php

namespace Cogensoft\ApiLogger\Plugin\Webapi\Controller;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
use Magento\Framework\Webapi\Rest\Response;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Cogensoft\ApiLogger\Model\ApiLogFactory;
use Cogensoft\ApiLogger\Model\ResourceModel\ApiLog AS ApiLogResource;

class Rest
{
	/**
	 * @var \Magento\Framework\Webapi\Rest\Request
	 */
	protected $restRequest;

	/**
	 * @var ScopeConfigInterface
	 */
	protected $scopeConfig;

	/**
	 * @var \Cogensoft\ApiLogger\Model\ApiLogFactory
	 */
	protected $apiLogFactory;

	/**
	 * @var \Cogensoft\ApiLogger\Model\ResourceModel\ApiLog
	 */
	protected $apiLogResource;

	public function __construct(
		RestRequest $restRequest,
		ScopeConfigInterface $scopeConfig,
		ApiLogFactory $apiLogFactory,
		ApiLogResource $apiLogResource
	) {
		$this->restRequest = $restRequest;
		$this->scopeConfig = $scopeConfig;
		$this->apiLogFactory = $apiLogFactory;
		$this->apiLogResource = $apiLogResource;
	}

	public function aroundDispatch( \Magento\Webapi\Controller\Rest $subject, \Closure $proceed, RequestInterface $request)
	{
		if(!$this->scopeConfig->getValue('cogensoft_api_logger/configuration/enable_logging')) {
			return $proceed($request);
		}

		$requestPath = (preg_match('/^\/rest\/(?:[^\/]+\/){0,1}v1\/(.+)$/', strtolower($request->getPathInfo()), $matches) && count($matches) == 2)
			? $matches[1]
			: null;

		$includedPathsArray = ($includedPathsString = $this->scopeConfig->getValue('cogensoft_api_logger/configuration/include_endpoints'))
			? explode(',', $includedPathsString)
			: [];

		$isPathIncluded = ($includedPathsArray) ? false : true;
		foreach($includedPathsArray AS $includedPath) {
			if(strpos($requestPath, $includedPath) !== false) {
				$isPathIncluded = true;
				break;
			}
		}

		if(!$isPathIncluded) {
			return $proceed($request);
		}

		/** @var \Cogensoft\ApiLogger\Model\ApiLog $apiLog */
		$apiLog = $this->apiLogFactory->create();
		$startDate = new \DateTime();
		$inputParams = $this->restRequest->getRequestData();
		$requestData = [
			'path' => $requestPath,
			'method' => $request->getMethod(),
			'parameters' => json_encode($inputParams),
			'ip_address' => $this->restRequest->getClientIp(),
			'start_time' => $startDate->format('Y-m-d H:i:s')
		];

		try {
			/** @var Response $response */
			$response = $proceed($request);
			$firstException = ($exceptions = $response->getException()) ? array_pop($exceptions) : null;
			if($response->isException() && $firstException) {
				throw $firstException;
			}
			$responseData = [
				'successful' => $response->isSuccess(),
				'response_code' => $response->getHttpResponseCode(),
				'response_body' => $response->getBody(),
				'exception' => null
			];
		}
		catch(\Magento\Framework\Webapi\Exception $e) {
			$responseData = [
				'successful' => false,
				'response_code' => $e->getHttpCode(),
				'response_body' => $response->getBody(),
				'exception' => $e->getMessage()
			];
		}
		catch (\Exception $e) {
			$responseData = [
				'successful' => false,
				'response_code' => null,
				'response_body' => $response->getBody(),
				'exception' => $e->getMessage()
			];
		}
		$endTime = new \DateTime();
		$responseData['duration_in_seconds'] = $endTime->getTimestamp() - $startDate->getTimestamp();

		$apiLog->setData(array_merge($requestData, $responseData));
		$this->apiLogResource->save($apiLog);

		return $response;
	}
}