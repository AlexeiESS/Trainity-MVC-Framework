<?php
namespace App\Http\Models;

use App\Core\Model;
if(!defined(SECURITY)){exit();}
class IndexModel extends Model {

	public function sign_up($login, $password){
		$this->conn->query("INSERT INTO users(id, login, password) VALUES (NULL, '$login', '$password')");
		return 1;
	}
}