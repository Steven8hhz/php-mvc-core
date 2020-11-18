<?php 

	namespace app\core\form;

	class InputField extends BaseField {

		public const TYPE_TEXT = 'text';
		public const TYPE_PASSWORD = 'password';
		public const TYPE_NUM = 'number';

		public $type;

		public function __construct($model, $attribute) {
			$this->type = self::TYPE_TEXT;
			parent::__construct($model, $attribute);
		}

		public function passwordField() {
			$this->type = self::TYPE_PASSWORD;
			return $this;
		}

		public function renderInput() : string {
			return sprintf('
				<input type="%s" name="%s" value="%s" class="form-control%s">
				',
				$this->type, 
				$this->attribute,
				$this->model->{$this->attribute},
				$this->model->hasError($this->attribute) ? ' is-invalid' : ''
		 	);
		}

	}