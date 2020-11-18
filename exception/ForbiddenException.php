<?php 

	namespace app\core\exception;

	class ForbiddenException extends \Exception { // \Exception comes from the php 

		protected $message = 'You don\'t have permission to access this page';
		protected $code = 403;

	}