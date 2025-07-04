<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Accommodation Form</title>
    <link href="./assets/bootstrap.css" rel="stylesheet">
    <script src="./assets/jquery.js"></script>
    <script src="./assets/htmltopdf.js"></script>
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f8f9fa;
            --accent-color: #2c3e50;
            --success-color: #2ecc71;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            color: white;
            padding: 2rem 0;
            margin-bottom: 3rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2.5rem;
            margin: 0;
            text-align: center;
            font-weight: 300;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto 4rem;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            background: var(--secondary-color);
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .form-section h2 {
            color: var(--accent-color);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.8rem;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: var(--accent-color);
            margin-bottom: 0.5rem;
        }

        .submit-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: block;
            margin: 2rem auto 0;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #357abd;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .letter-container {
            width: 210mm; 
            min-height: 297mm;  
            padding: 10mm;  
            background: white;
            box-sizing: border-box;
        }

        .letter-header {
            margin-bottom: 15mm;
        }

        .letter-header h1 {
            font-size: 24px;
            margin-bottom: 5mm;
        }

        .letter-body {
            font-size: 12px;
            line-height: 1.5;
        }

        .letter-body p {
            margin-bottom: 3mm;
        }

        .letter-body ul {
            margin: 3mm 0;
            padding-left: 5mm;
        }

        .letter-body li {
            margin-bottom: 2mm;
        }

        .signature {
            margin-top: 15mm;
        }

        .signature p {
            margin: 1mm 0;
            font-size: 12px;
        }

        #document {
            background: white;
        }
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .success-message {
            display: none;
            background: var(--success-color);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 1rem;
        }

        /* #document {
            position: fixed;
            top: -9999px;
            left: -9999px;
            visibility: hidden;
        } */
    </style>
</head>
<body>
    <?php
    $studid = 0;
    if(isset($_GET['studid'])) {
        $studid = $_GET['studid'];
    }
    ?>

    <div class="header">
        <h1>Student Recommendation Request</h1>
    </div>

    <div class="form-container">
        <form id="studentForm">
            <div class="form-section">
                <h2>Personal Information</h2>
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your full name" required>
                </div>
                
                <div class="mb-3">
                    <label for="degree" class="form-label">Previous Degree</label>
                    <input type="text" class="form-control" id="degree" placeholder="Enter your previous degree" required>
                </div>
            </div>

            <div class="form-section">
                <h2>Academic Details</h2>
                <div class="mb-3">
                    <label for="suggestedCourse" class="form-label">Desired Program</label>
                    <input type="text" class="form-control" id="suggestedCourse" placeholder="Enter your desired program" required>
                </div>
                
                <div class="mb-3">
                    <label for="college" class="form-label">Institution Name</label>
                    <input type="text" class="form-control" id="college" placeholder="Enter institution name" required>
                </div>
                
                <div class="mb-3">
                    <label for="ieltsScore" class="form-label">GER Score</label>
                    <input type="text" class="form-control" id="ieltsScore" placeholder="Enter your GER score" required>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">Generate Request Letter</button>
        </form>

        <div class="success-message">
            Your accommodation request letter has been generated successfully!
        </div>
    </div>

    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <div id="document">
        <div id="documentContent"></div>
    </div>

    <input type="hidden" id="studid" value="<?php echo $studid; ?>">

    <script>
        $(document).ready(function() {
            $('#studentForm').on('submit', function(e) {
                e.preventDefault();
                
                $('.loading-overlay').css('display', 'flex');
                
                const currentDate = new Date().toLocaleDateString();
                const name = $('#name').val();
                const degree = $('#degree').val();
                const college = $('#college').val();
                const suggestedCourse = $('#suggestedCourse').val();
                const ieltsScore = $('#ieltsScore').val();
                const studid = $("#studid").val();

                // Make document visible for generation
                $('#document').css({
                    'position': 'fixed',
                    'top': '0',
                    'left': '0',
                    'width': '210mm', // A4 width
                    'height': '297mm', // A4 height
                    'background': 'white',
                    'visibility': 'visible',
                    'z-index': '-9999'
                });

                $('#documentContent').html(`
                    <div class="letter-container">
                        <div class="letter-header">
                            <h1>Accommodation Request Letter</h1>
                            <p>For ${degree} Program</p>
                            <p>Issued by ${college}</p>
                        </div>

                        <div class="letter-body">
                            <p>Date: ${currentDate}</p>
                            <p>To,<br>
                            The Admissions Officer<br>
                            Office of Admissions<br>
                            ${college}</p>

                            <p>Subject: Accommodation Request for ${name} in ${suggestedCourse}</p>

                            <p>Dear Sir/Madam,</p>

                            <p>I hope this letter finds you well. I am writing to formally request consideration for ${name}, a prospective student for the ${suggestedCourse} program at ${college}. The candidate has achieved an IELTS score of ${ieltsScore}, demonstrating their English language proficiency.</p>

                            <p>Key Qualifications:</p>
                            <ul>
                                <li>Name: ${name}</li>
                                <li>Previous Degree: ${degree}</li>
                                <li>Desired Program: ${suggestedCourse}</li>
                                <li>IELTS Score: ${ieltsScore}</li>
                            </ul>

                            <p>We believe ${name} would be an excellent addition to your institution and the ${suggestedCourse} program. Please consider this application for the upcoming academic term.</p>

                            <p>Thank you for your time and consideration.</p>

                            <p>Sincerely,</p>
                        </div>

                        <div class="signature">
                            <p>${name}</p>
                            <p>Applicant</p>
                            <p>${college}</p>
                        </div>
                    </div>
                `);

                // Generate PDF with updated settings
                const element = document.getElementById('documentContent');
                const opt = {
                    margin: 0,
                    filename: `${name.toLowerCase().replace(/\s+/g, '-')}-accommodation-letter.pdf`,
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { 
                        scale: 2,
                        useCORS: true,
                        letterRendering: true,
                        width: 794, // A4 width in pixels at 96 DPI
                        height: 1123 // A4 height in pixels at 96 DPI
                    },
                    jsPDF: { 
                        unit: 'mm', 
                        format: 'a4', 
                        orientation: 'portrait'
                    }
                };

                html2pdf()
                    .from(element)
                    .set(opt)
                    .save()
                    .then(() => {
                        $('#document').css({
                            'position': 'fixed',
                            'top': '-9999px',
                            'left': '-9999px',
                            'visibility': 'hidden'
                        });
                        
                        $('.loading-overlay').hide();
                        $('.success-message').fadeIn().delay(3000).fadeOut();
                        $('#studentForm')[0].reset();
                    })
                    .catch(error => {
                        console.error('PDF generation error:', error);
                        $('.loading-overlay').hide();
                        alert('Error generating PDF. Please try again.');
                    });

                // Backend submission code remains the same
                $.ajax({
                    url: 'backend.php',
                    type: 'POST',
                    data: {
                        accommodation: true,
                        degree: degree,
                        college: college,
                        suggestedCourse: suggestedCourse,
                        ieltsScore: ieltsScore,
                        studid: studid
                    },
                    success: function(response) {
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
            });
        });
    </script>
</body>
</html>