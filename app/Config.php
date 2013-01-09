<?php

/**
 * Description of config file
 * 
 * Copyright (c) 2012 randy sesser <sesser@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @author randy sesser <sesser@gmail.com>
 * @copyright 2012, randy sesser
 * @license http://www.opensource.org/licenses/mit-license The MIT License
 * @package 
 * @subpackage 
 * @version 
 * @filesource
 */

/**
 * Description of config
 *
 * @author randy sesser <sesser@gmail.com>
 * @copyright 2012, randy sesser
 * @license http://www.opensource.org/licenses/mit-license The MIT License
 */
class Config
{
	/**
	 * @var array The parsed config.json data
	 * @access private
	 */
	private $config = [];
	
	/**
	 * @var Config A single instance of the Config object is all that's needed
	 * @access private
	 * @static
	 */
	private static $instance = NULL;
	
	private final function __construct($file)
	{
		$this->config = json_decode(file_get_contents($file), TRUE);
	}
	
	/**
	 * Initializes the config array using the supplied $file. If $file is
	 * omitted, it looks for config.json in the app root.
	 * @param string $file The config file to parse. Must be valid json.
	 */
	public static function init($file = NULL)
	{
		if ($file === NULL)
			$file = ST_APP_PATH . '/config.json';
		
		static::$instance = new self($file);
		
	}
	/**
	 * Gets configuration values from the config.json. Supports dot notation
	 * style keys (a la json/javascript) inspired by CakePHP's Configure::get()
	 * @param mixed $keys A key or keys to get. Can be specified using dot notation like json/javascript (e.g. 'app.routes')
	 * @return mixed Returns a configuration setting or a group (array) of settings
	 * @throws Exception
	 */
	public static function get($keys = NULL)
	{
		if (static::$instance === NULL)
			static::init();
		
		if (empty(static::$instance->config))
			throw new Exception("Could not parse config");
		
		$data = static::$instance->config;
		
		if ($keys === NULL)
			return $data;
		
		if (!is_array($keys))
			$keys = explode ('.', $keys);
		
		foreach ($keys as $key)
			if (isset($data[$key]))
				$data =& $data[$key];
		
		return $data;
	}

}
