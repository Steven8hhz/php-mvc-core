<?php 

	namespace steven\phpmvc;

	use steven\phpmvc\db\DbModel;

	abstract class UserModel extends DbModel {

		abstract public function getDisplayName() : string;

	}