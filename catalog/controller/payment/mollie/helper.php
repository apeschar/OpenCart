<?php
class MollieHelper
{
	const PLUGIN_VERSION = "6.2.3";

	// All available modules. These should correspond to the Mollie_API_Object_Method constants.
	const MODULE_NAME_BANKTRANSFER = "banktransfer";
	const MODULE_NAME_BELFIUS      = "belfius";
	const MODULE_NAME_BITCOIN      = "bitcoin";
	const MODULE_NAME_CREDITCARD   = "creditcard";
	const MODULE_NAME_IDEAL        = "ideal";
	const MODULE_NAME_MISTERCASH   = "mistercash";
	const MODULE_NAME_PAYPAL       = "paypal";
	const MODULE_NAME_PAYSAFECARD  = "paysafecard";
	const MODULE_NAME_SOFORT       = "sofort";

	// List of all available module names.
	static public $MODULE_NAMES = array(
		self::MODULE_NAME_BANKTRANSFER,
		self::MODULE_NAME_BELFIUS,
		self::MODULE_NAME_BITCOIN,
		self::MODULE_NAME_CREDITCARD,
		self::MODULE_NAME_IDEAL,
		self::MODULE_NAME_MISTERCASH,
		self::MODULE_NAME_PAYPAL,
		self::MODULE_NAME_PAYSAFECARD,
		self::MODULE_NAME_SOFORT,
	);

	static protected $api_client;

	/**
	 * @return bool
	 */
	public static function apiClientFound ()
	{
		return file_exists(realpath(DIR_SYSTEM . "/..") . "/catalog/controller/payment/mollie-api-client/");
	}

	/**
	 * Get the Mollie client. Needs the Config object to retrieve the API key.
	 *
	 * @param Config $config
	 *
	 * @return Mollie_API_Client
	 */
	public static function getAPIClient ($config)
	{
		if (!self::$api_client && self::apiClientFound())
		{
			require_once(realpath(DIR_SYSTEM . "/..") . "/catalog/controller/payment/mollie-api-client/src/Mollie/API/Autoloader.php");

			$mollie = new Mollie_API_Client;

			$mollie->setApiKey($config->get('mollie_api_key'));

			$mollie->addVersionString("OpenCart/" . VERSION);
			$mollie->addVersionString("MollieOpenCart/" . self::PLUGIN_VERSION);

			self::$api_client = $mollie;
		}

		return self::$api_client;
	}
}
