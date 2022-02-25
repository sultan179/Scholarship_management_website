<?php
// connect to the database
//session_start();
//var_dump($_SESSION);die;
$st_id=$_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '', 'scholarships');

$sql = "SELECT * FROM files Where student_id = $st_id";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
//var_dump($files);die;
// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = 'uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else  {
        if((empty($files))){
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (name, size, downloads,student_id) VALUES ('$filename', $size, 0,$st_id)";
            //var_dump($sql);die;
            if (mysqli_query($conn, $sql)) {
                $Message = urlencode("File Upload Successfully");
    
                header("Location: scholarship.php?Message=$Message");
            }
        } else {
            $Message = urlencode("Failed To Upload File");
    
            header("Location: scholarship.php?Message=$Message");
        }
    }
    else{
      
        if (move_uploaded_file($file, $destination)) {
            $sql ="UPDATE files SET name='$filename',size='$size',downloads=0 WHERE student_id='$st_id'";
            //var_dump($sql);die;
            if (mysqli_query($conn, $sql)) {
                $Message = urlencode("File Upload Successfully");
    
                header("Location: scholarship.php?Message=$Message");
            }
        } else {
            $Message = urlencode("Failed To Upload File");
    
            header("Location: scholarship.php?Message=$Message");
        }
    }
    }
}

// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE student_id=$id";
    $result = mysqli_query($conn, $sql);
    //$results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //var_dump($results);die;

    $file = mysqli_fetch_assoc($result);
    if($file==NULL){
        $Message = urlencode("No file Exists For Student:");
    
        header("Location: admindashboard.php?Message=$Message+$id");
    }
    //var_dump($file);die;
    $filepath = 'uploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['name']));
        readfile('uploads/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE student_id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}