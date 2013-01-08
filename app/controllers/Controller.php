<?php 
/**
 * * Copyright (c) 2013 Randy <sesser@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */
/**
* Controller base class
*/
class Controller
{
	/**
	 * The current Slim application object
	 *
	 * @var \Slim\Slim
	 **/
	protected $app = NULL;

	/**
	 * The current Slim Request object
	 *
	 * @var \Slim\Http\Request
	 **/
	protected $request = NULL;

	/**
	 * The current Slim Response object
	 *
	 * @var \Slim\Http\Response
	 **/
	protected $response = NULL;

	/**
	 * The current Slim View object
	 *
	 * @var \Slim\View
	 **/
	protected $view = NULL;

	/**
	 * Tracks whether to call the render method or not. This
	 * is set to false if $this->render() is called in child
	 * classes
	 *
	 * @var bool
	 **/
	protected $autoRender = TRUE;

	public function __construct(\Slim\Slim $app = NULL)
	{
		if ($app === NULL)
			$app = \Slim\Slim::getInstance();
		$this->app = $app;
		$this->view = $app->view();
		$this->request = $app->request();
		$this->response = $app->response();
	}

	public function __call($method, $args)
	{
		$template = sprintf('%s/%s', strtolower(get_called_class()), strtolower($method));
		if (is_callable([$this, '_' . $method])) {
			$this->before();
			call_user_func_array([$this, '_'.$method], $args);
			$this->after();
			if ($this->autoRender)
				$this->render($template, $this->view->getData());
		} else {
			$this->app->notFound();
		}
	}

	protected function before() { }

	protected function after() { }

	/**
	 * Calls the render method in the Slim app instance. Twig
	 * extension is optional and added prior to calling render()
	 *
	 * @param string $template The relative path to the template being rendered
	 * @param array $data The data to pass to the template
	 * @param int $code The response code to send to the client
	 * @return void
	 * @author randy sesser <sesser@gmail.com>
	 **/
	protected function render($template, array $data = [], $code = NULL)
	{
		if (!preg_match('/\.twig$/', $template))
			$template .= '.twig';
		$this->app->render($template, $data, $code);
	}

	/**
	 * Sets data for the view
	 *
	 * @return void
	 * @author randy sesser <sesser@gmail.com>
	 */
	protected function set()
	{
		$args = func_get_args();
		if (count($args) == 1) {
			$this->view->setData($args[0]);
		} else {
			$this->view->setData($args[0], $args[1]);
		}
	}
}