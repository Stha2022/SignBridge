<?php
// SignBridge authentication API — PHP session + MySQL only.
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'secure' => $secure,
  'httponly' => true,
  'samesite' => 'Lax'
]);
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if (!file_exists(__DIR__.'/config.php')) { http_response_code(503); echo json_encode(['success'=>false,'message'=>'PHP/MySQL backend not configured.']); exit; }
require __DIR__.'/config.php';
$allowedLanguages = ['en','zu','ve','st','tn','af'];
try {
  $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
  $data=json_decode(file_get_contents('php://input'),true) ?: [];
  $action=$data['action']??'';
  if($action==='health'){echo json_encode(['success'=>true,'message'=>'PHP + MySQL backend connected','database'=>$DB_NAME]);exit;}
  if($action==='register'){
    $name=trim($data['name']??'');$email=strtolower(trim($data['email']??''));$password=$data['password']??'';$language=$data['language']??'en';$privacyConsent=!empty($data['privacyConsent']);$trainingConsent=!empty($data['trainingConsent']);$marketingConsent=!empty($data['marketingConsent']);
    if($name===''||mb_strlen($name)>60||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<6||!in_array($language,$allowedLanguages,true)||!$privacyConsent){http_response_code(422);echo json_encode(['success'=>false,'message'=>'Please provide valid details.']);exit;}
    $s=$pdo->prepare('SELECT id FROM users WHERE email=?');$s->execute([$email]);if($s->fetch()){http_response_code(409);echo json_encode(['success'=>false,'message'=>'Email already registered.']);exit;}
    $hash=password_hash($password,PASSWORD_DEFAULT);$s=$pdo->prepare('INSERT INTO users(name,email,password_hash,language,privacy_consent,training_consent,marketing_consent,consent_at) VALUES(?,?,?,?,?,?,?,NOW())');$s->execute([$name,$email,$hash,$language,1,$trainingConsent?1:0,$marketingConsent?1:0]);$id=(int)$pdo->lastInsertId();session_regenerate_id(true);$_SESSION['user_id']=$id;
    echo json_encode(['success'=>true,'user'=>['id'=>$id,'name'=>$name,'email'=>$email,'language'=>$language]]);exit;
  }
  if($action==='login'){
    $email=strtolower(trim($data['email']??''));$password=$data['password']??'';$s=$pdo->prepare('SELECT id,name,email,password_hash,language FROM users WHERE email=?');$s->execute([$email]);$u=$s->fetch();
    if(!$u||!password_verify($password,$u['password_hash'])){http_response_code(401);echo json_encode(['success'=>false,'message'=>'Invalid email or password.']);exit;}
    session_regenerate_id(true);$_SESSION['user_id']=(int)$u['id'];unset($u['password_hash']);echo json_encode(['success'=>true,'user'=>$u]);exit;
  }
  if($action==='me'){
    if(empty($_SESSION['user_id'])){http_response_code(401);echo json_encode(['success'=>false,'message'=>'Not signed in.']);exit;}
    $s=$pdo->prepare('SELECT id,name,email,language FROM users WHERE id=?');$s->execute([$_SESSION['user_id']]);$u=$s->fetch();if(!$u){$_SESSION=[];session_destroy();http_response_code(401);echo json_encode(['success'=>false,'message'=>'Session expired.']);exit;}echo json_encode(['success'=>true,'user'=>$u]);exit;
  }
  if($action==='update_profile'){
    if(empty($_SESSION['user_id'])){http_response_code(401);echo json_encode(['success'=>false,'message'=>'Not signed in.']);exit;}
    $name=trim($data['name']??'');$language=$data['language']??'en';if($name===''||mb_strlen($name)>60||!in_array($language,$allowedLanguages,true)){http_response_code(422);echo json_encode(['success'=>false,'message'=>'Invalid profile details.']);exit;}
    $s=$pdo->prepare('UPDATE users SET name=?,language=? WHERE id=?');$s->execute([$name,$language,$_SESSION['user_id']]);echo json_encode(['success'=>true]);exit;
  }
  if($action==='logout'){$_SESSION=[];if(ini_get('session.use_cookies')){ $p=session_get_cookie_params();setcookie(session_name(),'','time()-42000',$p['path'],$p['domain'],$p['secure'],$p['httponly']); }session_destroy();echo json_encode(['success'=>true]);exit;}
  http_response_code(400);echo json_encode(['success'=>false,'message'=>'Unknown action.']);
} catch(Throwable $e){error_log('SignBridge auth: '.$e->getMessage());http_response_code(500);echo json_encode(['success'=>false,'message'=>'Database service unavailable.']);}
