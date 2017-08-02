<?php 

class User {

	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;

	public static function find_all_users(){

		return self::find_this_query("SELECT * FROM users");

	}

	public static function find_user_by_id($id){
		global $database;

		$the_result_array = self::find_this_query("SELECT * from users WHERE id = $id LIMIT 1");

		// if(!empty($the_result_array)){
		// 	$first_item = array_shift($the_result_array);
		// } else {
		// 	return false;
		// }

		return !empty($the_result_array) ? array_shift($the_result_array) : false;
	}

	public static function find_this_query($sql) {
		global $database;

		$result_set = $database->query($sql);

		$the_object_array = array();

		while ($row = mysqli_fetch_array($result_set)) {
			$the_object_array[] = self::instantiation($row);
		}

		return $the_object_array;
	}

	public static function instantiation($the_record){

		$the_object = new self;

        foreach ($the_record as $key => $value) {
        	if($the_object->has_the_key($key)){
        		$the_object -> $key = $value;
        	}
        }

        return $the_object;
	}

	private function has_the_key($key){

		$object_keys = get_object_vars($this);

		return array_key_exists($key, $object_keys);
	}

}

?>