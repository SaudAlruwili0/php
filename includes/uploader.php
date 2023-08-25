<?php
require_once __DIR__ . "/../config/database.php";
$uploadDir = 'uploades';
function filterString($field)
{
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    return $field;
}
function filterEmail($field)
{
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return $field;
    } else {
        return false;
    }
}
function canUpload($file)
{
    // allowed file types
    $allowed = [
        'jbg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif'
    ];
    $fileType = $file['type'];
    $fileMimeType = mime_content_type($file['tmp_name']);

    $maxSize = 35 * 1024;
    $fileSize = $file['size'];

    if (!in_array($fileMimeType, $allowed)) {
        return 'file type is not allowed';
    }

    if ($fileSize > $maxSize) {
        return 'file size bigger than ' . $maxSize;
    }
    return true;

}

$messageError = $documentError = $emailError = $nameError = '';
$message = $email = $name = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filterEmail($_POST['email']);
    if (!$email) {
        $_SESSION['contact_form']['email'] = '';

        $emailError = 'your email is invalid';
    } else {
        $_SESSION['contact_form']['email'] = $email;

    }
    $name = filterString($_POST['name']);
    if (!$name) {
        $_SESSION['contact_form']['name'] = '';
        $nameError = 'your name is required';
    } else {
        $_SESSION['contact_form']['name'] = $name;

    }
    $message = filterString($_POST['message']);
    if (!$message) {
        $_SESSION['contact_form']['message'] = '';
        $messageError = 'message is required';
    } else {
        $_SESSION['contact_form']['message'] = $message;

    }

    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $canUploade = canUpload($_FILES['document']);

        if ($canUploade === true) {

            if (!is_dir($uploadDir)) {
                umask(0);
                mkdir($uploadDir, 0775);
            }
            $fileName = time() . $_FILES['document']['name'];
            if (file_exists($uploadDir . '/' . $fileName)) {
                $documentError = 'File already exists';
            } else {
                move_uploaded_file($_FILES['document']['tmp_name'], $uploadDir . '/' . $fileName);
            }
        } else {
            $documentError = $canUploade;
        }
        $fileName ? $filePath = $uploadDir . '/' . $fileName : $filePath = '';
    }
    if (!$nameError && !$emailError && !$messageError && !$documentError) {
        // unset($_SESSION['contact_form']); 
        $statement = $mysqli->prepare("insert into messages (contact_name,email,document,message,service_id)
        values(?,?,?,?,?)");
        $statement->bind_param('ssssi', $dbContactName, $dbEmail, $dbDocument, $dbMessage, $dbServiceId);


        // );
        //     "values('$name','$email','$fileName','$message'," . $_POST['service_id'] . ");
        // $insertMessage = "insert into messages (contact_name,email,document,message,service_id)" .
        //     "values('$name','$email','$fileName','$message'," . $_POST['service_id'] . ")";
        // $mysqli->query($insertMessage);

        $header = 'MIME-VERSION:1.0' . "\r\n" .
            'Reply-To:' . $email . "\r\n" .
            'X-Mailer:PHP/' . phpversion();

        $htmlMessage = '<html><body>';
        $htmlMessage .= '<p style="color:$ff0000;">' . $message . '</p>';
        $htmlMessage .= '</body></html>';

        if (mail($config['admin_email'], 'you have a new message', $htmlMessage, $header)) {
            // session_destroy();  لحذف السيشن
            header('Location:contact.php');
            die();
        } else {
            echo "error sending your email";
        }

    }
}