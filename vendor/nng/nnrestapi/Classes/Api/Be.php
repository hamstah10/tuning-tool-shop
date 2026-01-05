<?php
namespace Nng\Nnrestapi\Api;

use Nng\Nnrestapi\Annotations as Api;

/**
 * Nnrestapi
 *
 */
class Be extends AbstractApi
{
	/**
	 * # GET the current logs
	 *
	 * @Api\Access("be_users")
	 * @Api\Log(false)
	 * @return array
	 */
	public function getLogsAction()
	{
		$filter = $this->request->getArguments();
		return \nn\rest::Log()->dump($filter);
	}

	/**
	 * # POST settings
	 *
	 * @Api\Access("be_users")
	 * @Api\Log(false)
	 * @return array
	 */
	public function postSettingsAction()
	{
		$settings = $this->request->getBody();
		\nn\rest::Settings()->update($settings);
		return [
			'settings' => $settings
		];
	}

	/**
	 * # Delete the logs
	 *
	 * @Api\Access("be_users")
	 * @Api\Log(false)
	 * @return array
	 */
	public function deleteLogsAction()
	{
		return \nn\rest::Log()->clear(true);
	}

}
