<?php
//はじめに
#http://www.spankyjpn.com/phpmailer-install-troubleshooting/
#google側で安全性の低いアプリのアクセスを許可してやる
//formは別で作っておくこと
?>
<?php 
$title      = $_POST["title"];          //タイトル
$namae		= $_POST["namae"];		    //お名前
$mailaddress= $_POST["mailaddress"];	//メールアドレス
$content	= $_POST["content"];		//お問合せ内容

//危険な文字列を入力された場合にそのまま利用しない対策
$title		= htmlspecialchars($title, ENT_QUOTES);
$namae		= htmlspecialchars($namae, ENT_QUOTES);
$mailaddress= htmlspecialchars($mailaddress, ENT_QUOTES);
$naiyou		= htmlspecialchars($naiyou, ENT_QUOTES);?>
<?php
$errmsg = '';	//エラーメッセージを空にしておく
if ($title == '') {
	$errmsg = $errmsg.'<p>件名が入力されていません。</p>';
    echo $errmsg;
}
if ($namae == '') {
	$errmsg = $errmsg.'<p>お名前が入力されていません。</p>';
    echo $errmsg;
}
if ($mailaddress == '') {
	$errmsg = $errmsg.'<p>メールアドレスが入力されていません。</p>';
    echo $errmsg;
}
if ($content == '') {
	$errmsg = $errmsg.'<p>お問合せ内容が入力されていません。</p>';
    echo $errmsg;
}
?>
<?php if($errmsg === ''){?>
<?php
    require_once("vendor/autoload.php");
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $subject = $title;
    $body.="内容:".$content;
    $body.="-----";
    $body.="mailaddress:".$mailaddress;
    $from_name = $namae;
    $from_addr = "test@gmail.com";#送信元
    $smtp_user = "test@gmail.com";#ユーザー名
    $smtp_password = "pass";　#パスワード
    $to_address = "test@gmail.com";#送信先
     
    $mail->IsSMTP();
    $mail->SMTPDebug = 0; 
    $mail->SMTPAuth = true;
    $mail->CharSet = 'utf-8';
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;

    $mail->IsHTML(false);
    $mail->Username = $smtp_user;
    $mail->Password = $smtp_password; 
    $mail->SetFrom($from_addr,$from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to_address);
     
    if( !$mail -> Send() ){
        $result_message  = "Email send failure.Error Message: " . $mail->ErrorInfo;
    } else {
        $result_message  = "Email Sent Successful";
    }
    echo $result_message ;
?>
<?php }else{ echo "送信失敗";}?>