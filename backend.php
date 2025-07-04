<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";


$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['signin'])) {
    
    $emailid = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM tbl_student WHERE emailid=? and studpassword=? ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $emailid,$password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $retval=[];
    $retval['status']=0;
    $retval['studid']=0;
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $retval['status']=1;
        $retval['studid']=$user['studid'];

        
        
        echo json_encode($retval); 
    } else {
        echo json_encode($retval); 
    }
}

if (isset($_POST['signup'])) {
    
    $studname = $_POST['studname'];
    $emailid = $_POST['email'];
    $password = $_POST['password'];
 

    
    if (empty($studname) || empty($emailid) || empty($password) ) {
        echo json_encode(400); 
        return;
    }

    
    $sql = "SELECT * FROM tbl_student WHERE emailid=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $emailid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(2); 
        return;
    }

    
    

    
    $sql = "INSERT INTO tbl_student (studname, emailid, studpassword) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $studname, $emailid, $password);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(1); 
    } else {
        echo json_encode(500); 
    }
}

if(isset($_POST['accommodation'])){
    $degree=$_POST['degree'];
    $college=$_POST['college'];
    $suggestedCourse=$_POST['suggestedCourse'];
    $ieltsScore=$_POST['ieltsScore'];
    $studid=$_POST['studid'];
    
    if($studid){
        $sql = "SELECT * FROM tbl_stud_detail WHERE studid=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $studid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);



    $sql1 = "SELECT * FROM tbl_student WHERE studid=?";
    $stmt1 = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt1, "s", $studid);
    mysqli_stmt_execute($stmt1);
    $studresult = mysqli_stmt_get_result($stmt1);
    $user = mysqli_fetch_assoc($studresult);
   
    sendmail($user['studname'],$user['emailid'],$suggestedCourse,$college);
    if (mysqli_num_rows($result) > 0) {
        $sql="update tbl_stud_detail set sd_degree=?,sd_course=?,clgname=?,ielts_score=? where studid=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $degree, $college, $suggestedCourse,$ieltsScore,$studid); 
        echo json_encode(1);
        return;
    }


        $sql="INSERT into tbl_stud_detail(sd_degree,sd_course,clgname,ielts_score,studid)
        VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $degree, $college, $suggestedCourse,$ieltsScore,$studid);
    
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(1); 
        } else {
            echo json_encode(500); 
        }
    }



}

if(isset($_POST['sendmail'])){
    $emailid=$_POST['emailid'] ;
    $studname=$_POST['studname'];
    $course=$_POST['course'];
    $clgname=$_POST['clgname'];
send_accept($emailid,$studname,$course,$clgname);

}



function sendmail($name,$email,$course,$college){
    $mail = new PHPMailer(true);
    $email='kavi.laesr@gmail.com';
    try {
    
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                    
        $mail->SMTPAuth = true;                              
        $mail->Username = 'gopalakrishnand28@gmail.com';          
        $mail->Password = 'cubdfzsecwsisxwo';              
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
        $mail->Port = 587;                                    
    
         
        $mail->setFrom('gopalakrishnand28@gmail.com', 'Mailer');   
        $mail->addAddress($email, $name);  
    
         
        $mail->isHTML(true);                                   
        $mail->Subject = 'Letter Of Acceptance';                 
        $mail->Body    = "".$name."
".$course."
".date('d-m-Y')."

Admissions Committee
".$college."

Dear Admissions Committee,

I am pleased to recommend ".$name." for admission to ".$college."  ".$name." has demonstrated strong academic abilities and admirable personal qualities.

".$name." consistently performed at a high level, showing a deep understanding of the material and a strong work ethic. For instance, ".$name." led a successful project on [specific topic], which was particularly impressive for its [specific attribute, e.g., creativity, thoroughness].

Beyond academics, ".$name." is known for integrity, leadership, and commitment to specific domain. I am confident that  will thrive at ".$college." and make a valuable contribution to your community.

Please feel free to contact me if you need further information.

Sincerely,
".$name."
"; 
        $mail->AltBody = ''; 
     
        $mail->send();
        echo 'Message has been sent successfully';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


function send_accept($email,$studname,$course,$clgname){

    $mail = new PHPMailer(true);
    $email='kavi.laesr@gmail.com';
    try {
    
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                    
        $mail->SMTPAuth = true;                              
        $mail->Username = 'gopalakrishnand28@gmail.com';          
        $mail->Password = 'cubdfzsecwsisxwo';              
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
        $mail->Port = 587;                                    
    
         
        $mail->setFrom('gopalakrishnand28@gmail.com', 'Mailer');   
        $mail->addAddress($email, $studname);  
    
         
        $mail->isHTML(true);                                   
        $mail->Subject = 'Letter Of Acceptance';                 
        $mail->Body    = "Hello ".$studname.", we are processed the application and the students matched criteria basic details will send shortly  "; 
        $mail->AltBody = ''; 
     
        $mail->send();
        echo 'Message has been sent successfully';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

mysqli_close($conn);
?>
