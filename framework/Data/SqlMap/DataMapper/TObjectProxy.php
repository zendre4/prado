<?php
/**
 * TLazyLoadList, TObjectProxy classes file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2014 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @package System.Data.SqlMap
 */

/**
 * TObjectProxy sets up a simple object that intercepts method calls to a
 * particular object and relays the call to handler object.
 *
 * @author Wei Zhuo <weizho[at]gmail[dot]com>
 * @package System.Data.SqlMap
 * @since 3.1
 */
class TObjectProxy
{
	private $_object;
	private $_handler;

	/**
	 * @param object handler to method calls.
	 * @param object the object to by proxied.
	 */
	public function __construct($handler, $object)
	{
		$this->_handler = $handler;
		$this->_object = $object;
	}

	/**
	 * Relay the method call to the handler object (if able to be handled), otherwise
	 * it calls the proxied object's method.
	 * @param string method name called
	 * @param array method arguments
	 * @return mixed method return value.
	 */
	public function __call($method,$params)
	{
		if($this->_handler->hasMethod($method))
			return $this->_handler->intercept($method, $params);
		else
			return call_user_func_array(array($this->_object, $method), $params);
	}
}