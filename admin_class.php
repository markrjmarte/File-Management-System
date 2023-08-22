<?php
session_start();
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			// Update user status to "Login" and store login date and time
			$this->db->query("INSERT INTO users_logs (users, status, dates) VALUES ('".$username."', 'Login', NOW())");
			return 1;
		} else {
			return 2;
		}
	}
	
	function logout(){
		$username = $_SESSION['login_username'];
		$this->db->query("INSERT INTO users_logs (users, status, dates) VALUES ('".$username."', 'Logout', NOW())");
	
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	

	function save_folder(){
		extract($_POST);
		$data = " name ='".$name."' ";
		$data .= ", parent_id ='".$parent_id."' ";
		if(empty($id)){
			$data .= ", user_id ='".$_SESSION['login_id']."' ";
			
			// Check if the folder name exists for the given parent_id
			$check = $this->db->query("SELECT * FROM folders where user_id ='".$_SESSION['login_id']."' and name  ='".$name."' and parent_id ='".$parent_id."'")->num_rows;
			if($check > 0){
				return json_encode(array('status'=>2,'msg'=> 'Folder name already exists for this parent'));
			}else{
				$save = $this->db->query("INSERT INTO folders set ".$data);
				if($save)
					return json_encode(array('status'=>1));
			}
		}else{
			// Check if the folder name exists for the given parent_id, excluding the current folder
			$check = $this->db->query("SELECT * FROM folders where user_id ='".$_SESSION['login_id']."' and name  ='".$name."' and parent_id ='".$parent_id."' and id !=".$id)->num_rows;
			if($check > 0){
				return json_encode(array('status'=>2,'msg'=> 'Folder name already exists for this parent'));
			}else{
				$save = $this->db->query("UPDATE folders set ".$data." where id =".$id);
				if($save)
					return json_encode(array('status'=>1));
			}
		}
	}
	

	function save_folder_template(){
		extract($_POST);
		$data = " name ='".$name."' ";
		$data .= ", parent_id ='".$parent_id."' ";
		if(empty($id)){
			$data .= ", user_id ='".$_SESSION['login_id']."' ";
			
			// Check if the template name exists for the given parent_id
			$check = $this->db->query("SELECT * FROM template where user_id ='".$_SESSION['login_id']."' and name  ='".$name."' and parent_id ='".$parent_id."'")->num_rows;
			if($check > 0){
				return json_encode(array('status'=>2,'msg'=> 'Template name already exists for this parent'));
			}else{
				$save = $this->db->query("INSERT INTO template set ".$data);
				if($save)
					return json_encode(array('status'=>1));
			}
		}else{
			// Check if the template name exists for the given parent_id, excluding the current template
			$check = $this->db->query("SELECT * FROM template where user_id ='".$_SESSION['login_id']."' and name  ='".$name."' and parent_id ='".$parent_id."' and id !=".$id)->num_rows;
			if($check > 0){
				return json_encode(array('status'=>2,'msg'=> 'Template name already exists for this parent'));
			}else{
				$save = $this->db->query("UPDATE template set ".$data." where id =".$id);
				if($save)
					return json_encode(array('status'=>1));
			}
		}
	}
	

	function save_folder_notary(){
		extract($_POST);
		$data = " name ='".$name."' ";
		$data .= ", parent_id ='".$parent_id."' ";
		if(empty($id)){
			$data .= ", user_id ='".$_SESSION['login_id']."' ";
			
			// Check if the notary folder name exists for the given parent_id
			$check = $this->db->query("SELECT * FROM notary where user_id ='".$_SESSION['login_id']."' and name  ='".$name."' and parent_id ='".$parent_id."'")->num_rows;
			if($check > 0){
				return json_encode(array('status'=>2,'msg'=> 'Notary folder name already exists for this parent'));
			}else{
				$save = $this->db->query("INSERT INTO notary set ".$data);
				if($save)
					return json_encode(array('status'=>1));
			}
		}else{
			// Check if the notary folder name exists for the given parent_id, excluding the current notary folder
			$check = $this->db->query("SELECT * FROM notary where user_id ='".$_SESSION['login_id']."' and name  ='".$name."' and parent_id ='".$parent_id."' and id !=".$id)->num_rows;
			if($check > 0){
				return json_encode(array('status'=>2,'msg'=> 'Notary folder name already exists for this parent'));
			}else{
				$save = $this->db->query("UPDATE notary set ".$data." where id =".$id);
				if($save)
					return json_encode(array('status'=>1));
			}
		}
	}
	
	

	function delete_folder(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM folders where id =".$id);
		if($delete)
			echo 1;
	}

	function delete_folder_template(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM template where id =".$id);
		if($delete)
			echo 1;
	}

	function delete_folder_notary(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM notary where id =".$id);
		if($delete)
			echo 1;
	}

	function delete_file(){
		extract($_POST);
		$path = $this->db->query("SELECT file_path from files where id=".$id)->fetch_array()['file_path'];
		$delete = $this->db->query("DELETE FROM files where id =".$id);
		if($delete){
					unlink('assets1/uploads/'.$path);
					return 1;
				}
	}
	function delete_file_template(){
		extract($_POST);
		$path = $this->db->query("SELECT file_path from template_files where id=".$id)->fetch_array()['file_path'];
		$delete = $this->db->query("DELETE FROM template_files where id =".$id);
		if($delete){
					unlink('assets1/uploads/'.$path);
					return 1;
				}
	}

	function delete_file_notary(){
		extract($_POST);
		$path = $this->db->query("SELECT file_path from notary_files where id=".$id)->fetch_array()['file_path'];
		$delete = $this->db->query("DELETE FROM notary_files where id =".$id);
		if($delete){
					unlink('assets1/uploads/'.$path);
					return 1;
				}
	}

	function save_files(){
		extract($_POST);
		if(empty($id)){
		if($_FILES['upload']['tmp_name'] != ''){
					$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['upload']['name'];
					$move = move_uploaded_file($_FILES['upload']['tmp_name'],'assets1/uploads/'. $fname);
		
					if($move){
						$file = $_FILES['upload']['name'];
						$file = explode('.',$file);
						$chk = $this->db->query("SELECT * FROM files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."' ");
						if($chk->num_rows > 0){
							$file[0] = $file[0] .' ||'.($chk->num_rows);
						}
						$data = " name = '".$file[0]."' ";
						$data .= ", folder_id = '".$folder_id."' ";
						$data .= ", description = '".$description."' ";
						$data .= ", user_id = '".$_SESSION['login_id']."' ";
						$data .= ", file_type = '".$file[1]."' ";
						$data .= ", file_path = '".$fname."' ";
						if(isset($is_public) && $is_public == 'on')
						$data .= ", is_public = 1 ";
						else
						$data .= ", is_public = 0 ";

						$save = $this->db->query("INSERT INTO files set ".$data);
						if($save)
						return json_encode(array('status'=>1));
		
					}
		
				}
			}else{
						$data = " description = '".$description."' ";
						if(isset($is_public) && $is_public == 'on')
						$data .= ", is_public = 1 ";
						else
						$data .= ", is_public = 0 ";
						$save = $this->db->query("UPDATE files set ".$data. " where id=".$id);
						if($save)
						return json_encode(array('status'=>1));
			}

	}

	function save_files_template(){
		extract($_POST);
		if(empty($id)){
		if($_FILES['upload']['tmp_name'] != ''){
					$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['upload']['name'];
					$move = move_uploaded_file($_FILES['upload']['tmp_name'],'assets1/uploads/'. $fname);
		
					if($move){
						$file = $_FILES['upload']['name'];
						$file = explode('.',$file);
						$chk = $this->db->query("SELECT * FROM template_files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."' ");
						if($chk->num_rows > 0){
							$file[0] = $file[0] .' ||'.($chk->num_rows);
						}
						$data = " name = '".$file[0]."' ";
						$data .= ", folder_id = '".$folder_id."' ";
						$data .= ", description = '".$description."' ";
						$data .= ", user_id = '".$_SESSION['login_id']."' ";
						$data .= ", file_type = '".$file[1]."' ";
						$data .= ", file_path = '".$fname."' ";
						if(isset($is_public) && $is_public == 'on')
						$data .= ", is_public = 1 ";
						else
						$data .= ", is_public = 0 ";

						$save = $this->db->query("INSERT INTO template_files set ".$data);
						if($save)
						return json_encode(array('status'=>1));
		
					}
		
				}
			}else{
						$data = " description = '".$description."' ";
						if(isset($is_public) && $is_public == 'on')
						$data .= ", is_public = 1 ";
						else
						$data .= ", is_public = 0 ";
						$save = $this->db->query("UPDATE template_files set ".$data. " where id=".$id);
						if($save)
						return json_encode(array('status'=>1));
			}

	}

	function save_files_notary(){
		extract($_POST);
		if(empty($id)){
		if($_FILES['upload']['tmp_name'] != ''){
					$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['upload']['name'];
					$move = move_uploaded_file($_FILES['upload']['tmp_name'],'assets1/uploads/'. $fname);
		
					if($move){
						$file = $_FILES['upload']['name'];
						$file = explode('.',$file);
						$chk = $this->db->query("SELECT * FROM notary_files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."' ");
						if($chk->num_rows > 0){
							$file[0] = $file[0] .' ||'.($chk->num_rows);
						}
						$data = " name = '".$file[0]."' ";
						$data .= ", folder_id = '".$folder_id."' ";
						$data .= ", description = '".$description."' ";
						$data .= ", user_id = '".$_SESSION['login_id']."' ";
						$data .= ", file_type = '".$file[1]."' ";
						$data .= ", file_path = '".$fname."' ";
						if(isset($is_public) && $is_public == 'on')
						$data .= ", is_public = 1 ";
						else
						$data .= ", is_public = 0 ";

						$save = $this->db->query("INSERT INTO notary_files set ".$data);
						if($save)
						return json_encode(array('status'=>1));
		
					}
		
				}
			}else{
						$data = " description = '".$description."' ";
						if(isset($is_public) && $is_public == 'on')
						$data .= ", is_public = 1 ";
						else
						$data .= ", is_public = 0 ";
						$save = $this->db->query("UPDATE notary_files set ".$data. " where id=".$id);
						if($save)
						return json_encode(array('status'=>1));
			}

	}

	function file_rename(){
		extract($_POST);
		$file[0] = $name;
		$file[1] = $type;
		$chk = $this->db->query("SELECT * FROM files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."' and id != ".$id);
		if($chk->num_rows > 0){
			$file[0] = $file[0] .' ||'.($chk->num_rows);
			}
		$save = $this->db->query("UPDATE files set name = '".$name."' where id=".$id);
		if($save){
				return json_encode(array('status'=>1,'new_name'=>$file[0].'.'.$file[1]));
		}
	}

	function file_rename_template(){
		extract($_POST);
		$file[0] = $name;
		$file[1] = $type;
		$chk = $this->db->query("SELECT * FROM template_files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."' and id != ".$id);
		if($chk->num_rows > 0){
			$file[0] = $file[0] .' ||'.($chk->num_rows);
			}
		$save = $this->db->query("UPDATE template_files set name = '".$name."' where id=".$id);
		if($save){
				return json_encode(array('status'=>1,'new_name'=>$file[0].'.'.$file[1]));
		}
	}

	function file_rename_notary(){
		extract($_POST);
		$file[0] = $name;
		$file[1] = $type;
		$chk = $this->db->query("SELECT * FROM notary_files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."' and id != ".$id);
		if($chk->num_rows > 0){
			$file[0] = $file[0] .' ||'.($chk->num_rows);
			}
		$save = $this->db->query("UPDATE notary_files set name = '".$name."' where id=".$id);
		if($save){
				return json_encode(array('status'=>1,'new_name'=>$file[0].'.'.$file[1]));
		}
	}

	function save_user(){
		extract($_POST);
	
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		$data .= ", about = '$about' ";
		$data .= ", phone = '$phone' ";
		$data .= ", job = '$job' ";
		$data .= ", email = '$email' ";
		$data .= ", adress = '$adress' ";
	
		if (!empty($_FILES['profile_image']['name'])) {
			$profile_image = $_FILES['profile_image']['name'];
			$temp_image = $_FILES['profile_image']['tmp_name'];
			$profile_image_path = 'assets/img/profiles/' . $profile_image; // Update this path
			move_uploaded_file($temp_image, $profile_image_path);
			$data .= ", profile_image = '$profile_image'";
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function update_user(){
		extract($_POST);
	
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", about = '$about' ";
		$data .= ", phone = '$phone' ";
		$data .= ", job = '$job' ";
		$data .= ", email = '$email' ";
		$data .= ", adress = '$adress' ";
	
		if (!empty($_FILES['profile_image']['name'])) {
			$profile_image = $_FILES['profile_image']['name'];
			$temp_image = $_FILES['profile_image']['tmp_name'];
			$profile_image_path = 'assets/img/profiles/' . $profile_image; // Update this path
			move_uploaded_file($temp_image, $profile_image_path);
			$data .= ", profile_image = '$profile_image'";
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}

	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id =".$id);
		if($delete)
			echo 1;
	}
}