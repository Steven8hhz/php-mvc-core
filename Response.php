<?php 

	namespace steven\phpmvc;

	class Response {

		public function setStatusCode($code) {
			return http_response_code($code);
		}

		public function redirect($url) {
			header("location:" . $url);
		}

	}