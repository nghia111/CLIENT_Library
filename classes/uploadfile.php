<?
    // để gọi phương thức error ở dòng 14
    include "errorfileupload.php";

    class Uploadfile{
        public static function process()
        {
            try {
                if (empty($_FILES)) {
                    Dialog::show('Can not upload files');
                    return null;
                }
        
                $rs = Errorfileupload::err($_FILES['file']['error']);
                if ($rs != 'OK') {
                    Dialog::show($rs);
                    return null;
                }
        
                $fileMaxSize = FILE_MAX_SIZE;
                if ($_FILES['file']['size'] > $fileMaxSize) {
                    Dialog::show('File too large, must smaller than: ' .  $fileMaxSize);
                    return null;
                }
        
                // limit file image type
                $mime_types = FILE_TYPE;
                // check if image
                $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
                // file upload will store in tmp_name
                $file_mime_type = finfo_file($fileinfo, $_FILES['file']['tmp_name']);
                if (!in_array($file_mime_type, $mime_types)) {
                    Dialog::show('Invalid file type, file must be an image');
                    return null;
                }
        
                // standardize image before upload to server
                $pathinfo = pathinfo($_FILES['file']['name']);
                $filename = $pathinfo['filename'];
                $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
        
                // Handle override file exist in uploads folder
                $fullname = $filename . '.' . $pathinfo['extension'];
                // create path to uploads folder in server
                $fileToHost = 'uploads/' . $fullname;
                $i = 1;
                while (file_exists($fileToHost)) {
                    $fullname = $filename . "-$i." . $pathinfo['extension'];
                    $fileToHost = 'uploads/' . $fullname;
                    $i++;
                }
        
                $fileTmp = $_FILES['file']['tmp_name'];
                if (move_uploaded_file($fileTmp, $fileToHost)) {
                    return $fullname;
                } else {
                    Dialog::show("Error uploading!");
                    return null;
                }
            } catch (Exception $e) {
                Dialog::show($e->getMessage());
                return null;
            }
        }
    }
    
?>