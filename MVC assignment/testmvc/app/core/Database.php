<?php 

Trait Database
{

	private function connect()
	{
		$string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
		$con = new PDO($string,DBUSER,DBPASS);
		return $con;
	}

	public function query($query, $data = [])
	{

		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check)
		{
			$result = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($result) && count($result))
			{
				return $result;
			}
		}

		return false;
	}

	public function get_row($query, $data = [])
	{

		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check)
		{
			$result = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($result) && count($result))
			{
				return $result[0];
			}
		}

		return false;
	}
	
}
// Define the Database trait
trait Database {
    // Add your database-related methods here
}

// Define the Model trait
trait Model {
    use Database;

    // Add your Model methods here
}

// Include the Database and Model traits in your main application file
require_once 'path/to/DatabaseTrait.php';
require_once 'path/to/ModelTrait.php';

// Now you can use the Model trait in your Model class
class YourModel {
    use Model;

    // Your model-specific methods and properties go here
}

