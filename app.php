<?php
session_start();
define('BASE_URL','');
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function is_admin(){return isset($_SESSION['admin_id']);}
function require_admin(){if(!is_admin()){header('Location: ../login.php');exit;}}
function flash($key,$msg=null){if($msg!==null){$_SESSION['flash'][$key]=$msg;return;} $m=$_SESSION['flash'][$key]??null;unset($_SESSION['flash'][$key]);return $m;}
function upload_file($field,$folder='uploads',$allowed=['jpg','jpeg','png','webp','pdf','mp4']){
 if(empty($_FILES[$field]['name'])) return null; $f=$_FILES[$field]; if($f['error']!==UPLOAD_ERR_OK) return null;
 $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION)); if(!in_array($ext,$allowed)) return null;
 $name=uniqid('desa_',true).'.'.$ext; $dir=__DIR__.'/../assets/'.$folder; if(!is_dir($dir)) mkdir($dir,0755,true);
 if(move_uploaded_file($f['tmp_name'],$dir.'/'.$name)) return 'assets/'.$folder.'/'.$name; return null;
}
