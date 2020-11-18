<?php 

	namespace steven\phpmvc;

	class Controller {

		public $layout = 'main';
		public $action = '';

		/** @var steven\phpmvc\middlewares\BaseMiddleware[] */
		protected $middlewares = []; // array of middleware classes

		public function setLayout($layout) {
			$this->layout = $layout;
		}

		public function render($view, $params = []) {
			return Application::$app->view->renderView($view, $params);
		}

		public function registerMiddleware($middlewares) {
			$this->middlewares[] = $middlewares;
		}

		public function getMiddlewares() : array {
			return $this->middlewares;
		}

	}