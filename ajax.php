<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_folder'){
	$save = $crud->save_folder();
	if($save)
		echo $save;
}
if($action == 'save_folder_template'){
	$save = $crud->save_folder_template();
	if($save)
		echo $save;
}
if($action == 'save_folder_notary'){
	$save = $crud->save_folder_notary();
	if($save)
		echo $save;
}
if($action == 'delete_folder'){
	$delete = $crud->delete_folder();
	if($delete)
		echo $delete;
}
if($action == 'delete_folder_template'){
	$delete = $crud->delete_folder_template();
	if($delete)
		echo $delete;
}
if($action == 'delete_folder_notary'){
	$delete = $crud->delete_folder_notary();
	if($delete)
		echo $delete;
}
if($action == 'delete_file'){
	$delete = $crud->delete_file();
	if($delete)
		echo $delete;
}
if($action == 'delete_file_template'){
	$delete = $crud->delete_file_template();
	if($delete)
		echo $delete;
}
if($action == 'delete_file_notary'){
	$delete = $crud->delete_file_notary();
	if($delete)
		echo $delete;
}
if($action == 'save_files'){
	$save = $crud->save_files();
	if($save)
		echo $save;
}
if($action == 'save_files_template'){
	$save = $crud->save_files_template();
	if($save)
		echo $save;
}
if($action == 'save_files_notary'){
	$save = $crud->save_files_notary();
	if($save)
		echo $save;
}
if($action == 'file_rename'){
	$save = $crud->file_rename();
	if($save)
		echo $save;
}
if($action == 'file_rename_template'){
	$save = $crud->file_rename_template();
	if($save)
		echo $save;
}
if($action == 'file_rename_notary'){
	$save = $crud->file_rename_notary();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$delete = $crud->delete_user();
	if($delete)
		echo $delete;
}