<?php 

	namespace app\core\db;

	use app\core\Model;
	use app\core\Application;

	abstract class DbModel extends Model {

		abstract public function tableName() : string;

		abstract public function attributes() : array;

		abstract public function primaryKey() : string;

		public function save() {
			$tableName = $this->tableName();
			$attributes = $this->attributes();
			$params = array_map(function($attr) {
				return ":$attr";
			}, $attributes); // :firstname and so on

			$statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(',', $params) . ")");
			
			foreach($attributes as $attribute) {
				$statement->bindValue(":$attribute", $this->{$attribute});
			}

			$statement->execute();
			return true;
		}

		public function findOne($where) { // [email=>steve111@gmail.com, firstname=>Steven]
			$tableName = static::tableName(); // calling back from it extends class
			$attributes = array_keys($where);

			$sql = implode("AND ", array_map(function($attr) {
				return "$attr = :$attr";
			}, $attributes));

			// SELECT * FROM $table WHERE email = :email AND firstname = :firstname
			$statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
			foreach ($where as $key=>$item) {
				$statement->bindValue(":$key", $item);
			}

			$statement->execute();
			return $statement->fetchObject(static::class); // calling back from it extends class
		}

		public static function prepare($sql) {
			return Application::$app->db->pdo->prepare($sql);
		}

	}