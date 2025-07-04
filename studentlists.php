<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";

$conn = mysqli_connect($servername, $username, $password, $dbname);
$studname = '';
$isadminuser = 0;
$studid = 0;
$user = [];

$sql = "SELECT sd_degree, sd_course, clgname, ielts_score, tbl_student.emailid, tbl_student.studname 
        FROM tbl_stud_detail
        INNER JOIN tbl_student ON tbl_student.studid = tbl_stud_detail.studid";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students List</title>
  <link rel="stylesheet" href="./assets/bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="./assets/datatable_bootstrap.css">
  <script src="./assets/jquery.js"></script>
  <script src="./assets/datatable.js"></script>
  <script src="./assets/datatable_bootstrap.js"></script>
</head>
<body>

  <div class="container mt-5">
    <h1 class="text-center">Student List</h1>

    <table id="example" class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Student Name</th>
          <th>Email</th>
          <th>Degree</th>
          <th>Suggested Course</th>
          <th>College</th>
          <th>IELTS Score</th>
          <th>Send</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Loop through the results and display them in the table
        while ($user = mysqli_fetch_assoc($result)) {
          echo '<tr>
                  <td>'.$user['studname'].'</td>
                  <td>'.$user['emailid'].'</td>
                  <td>'.$user['sd_degree'].'</td>
                  <td>'.$user['sd_course'].'</td>
                  <td>'.$user['clgname'].'</td>
                  <td>'.$user['ielts_score'].'</td>
                  <td><Button class="btn"
                  email="'.$user['emailid'].'" 
                  studname="'.$user['studname'].'"
                  course="'.$user['sd_course'].'"
                  clgname="'.$user['clgname'].'"
                  onClick="sendmail(this)" style="background:#B0BEC5">Send</Button></td>
                </tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        paging: true,   
        searching: true,
        ordering: true, 
        info: true      
      });
    });

    function sendmail(e){
      var emailid=$(e).attr('email');
      var studname=$(e).attr('studname');
      var course=$(e).attr('course');
      var clgname=$(e).attr('clgname');
      $.ajax({
                    url: 'backend.php',
                    type: 'POST',
                    data: {
                        sendmail: true,
                        emailid: emailid,
                        studname: studname,
                        course: course,
                        clgname: clgname
                    },
                    success: function(response) {
                      alert(response);
                        try {
                            var data = JSON.parse(response);
                        } catch (e) {
                            console.error('Error parsing response:', e);
                        }
                    },
                    error: function() {
                        console.error('Backend submission failed');
                    }
                });

    }
  </script>

</body>
</html>
