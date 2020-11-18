<?php 

	namespace app\core;

	use app\core\db\Database;

	class Application {

		public static $ROOT_DIR;
		public static $app;

		public $userClass; // string
		public $layout = 'main';
		public $router;
		public $request;
		public $response;
		public $session;
		public $db;
		public $controller;
		public $user; // ?UserModel
		public $view;

		public function __construct($rootPath, $config) {
			self::$ROOT_DIR = $rootPath;
			self::$app = $this;
			$this->request = new Request();
			$this->response = new Response();
			$this->session = new Session();
			$this->router = new Router($this->request, $this->response);
			$this->view = new View();

			$this->db = new Database($config['db']);

			$this->userClass = $config['userClass'];
			
			$primaryValue = $this->session->get('user');

			if ($primaryValue) {
				$primaryKey = $this->userClass::primaryKey();
				$this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
			} else {
				$this->user = null;
			}
		}

		public static function isGuest() {
			return !self::$app->user;
		}

		public function run() {
			try {
				echo $this->router->resolve();
			} catch(\Exception $e) {
				$this->response->setStatusCode($e->getCode());
				echo $this->view->renderView('_error', [
					'exception' => $e
				]);
			}
		}

		public function getController() {
			return $this->controller;
		}

		public function setController($controller) {
			$this->controller = $controller;
		}

		public function login($user) { // UserModel
			$this->user = $user;
			$primaryKey = $user->primaryKey();
			$primaryValue = $user->{$primaryKey};

			$this->session->set('user', $primaryValue);

			return true;
		}

		public function logout() {
			$this->user = null;
			$this->session->remove('user');
		}

	}