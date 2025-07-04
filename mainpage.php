
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";

$homepage='http://localhost:8501/';
$conn = mysqli_connect($servername, $username, $password, $dbname);
$studname='';
$isadminuser=0;
$studid=0;
if(isset($_POST['studid'])){
    $sql = "SELECT * FROM tbl_student WHERE studid=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s",$_POST['studid']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $studid=$_POST['studid'];
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $studname=$user['studname'];
        $isadminuser=$user['isadmin'];
    }
    

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
        }

        body {
            padding-top: 60px;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand, .nav-link {
            color: white !important;
        }

        .nav-link {
            position: relative;
            margin: 0 5px;
            padding: 8px 15px !important;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--accent-color);
            color: white !important;
        }

        .nav-item button.nav-link {
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .navbar-toggler {
            background-color: white;
        }

        #logoutbtn {
            background-color: #e74c3c;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        #logoutbtn:hover {
            background-color: #c0392b;
        }

        .container-fluid {
            padding: 0 20px;
        }

        iframe {
            width: 100%;
            height: 85vh;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white;
        }

        @media (max-width: 768px) {
            #logoutbtn {
                position: relative !important;
                margin-top: 10px;
                width: 100%;
            }

            .navbar-collapse {
                background-color: var(--primary-color);
                padding: 10px;
                border-radius: 0 0 8px 8px;
            }
        }

        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .welcome-text {
            font-weight: 500;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand welcome-text" href="#">
                Welcome, <?php echo htmlspecialchars($studname); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if($isadminuser == 0): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="#" onclick="changeIframe(1)">
                                <i class="bi bi-house-door"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" onclick="changeIframe(2)">
                                <i class="bi bi-file-text"></i> Acceptance Letter
                            </button>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <button class="nav-link" onclick="changeIframe(3)">
                                <i class="bi bi-people"></i> Students List
                            </button>
                        </li>
                    <?php endif; ?>
                </ul>
                <button id="logoutbtn" class="btn">Logout</button>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="position-relative">
            <iframe id="contentFrame" src="<?php echo htmlspecialchars($homepage); ?>">
            </iframe>
            <div class="loading-spinner d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" id="studid" value="<?php echo $studid; ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            
            let activeNav = $('.nav-link.active');
 
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            }); 
            $('#logoutbtn').click(function() {
                location.href = "index.php";
            }); 
            $('#contentFrame').on('load', function() {
                $('.loading-spinner').addClass('d-none');
            });
        });

        function changeIframe(urllist) {
            $('.loading-spinner').removeClass('d-none');
            
            const userid = $("#studid").val();
            let url = 'http://localhost:8501/';
            
            switch(urllist) {
                case 2:
                    url = 'accomdation.php?studid=' + userid;
                    break;
                case 3:
                    url = 'studentlists.php';
                    break;
            }
            
            document.getElementById("contentFrame").src = url;
        }
    </script>
</head>
</body>
</html>