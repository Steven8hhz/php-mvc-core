<?php 

	namespace steven\phpmvc\middlewares;

	use steven\phpmvc\Application;
	use steven\phpmvc\exception\ForbiddenException;

	class AuthMiddleware extends BaseMiddleware {

		public $actions = [];

		public function __construct($actions = []) {
			$this->actions = $actions;
		}

		public function execute() {
			if (Application::isGuest()) {
				if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
					throw new ForbiddenException();
					
				}
			}
		}
		
	}