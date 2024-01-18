<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data sent from JavaScript
    $postData = json_decode(file_get_contents("php://input"), true);

    // Extract user's email and test results
    $userEmail = $postData['email'];
    $results = $postData['results'];

    // Compose the email content with HTML and CSS styles
    $subject = "Your Test Results";

    $message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                color: #333;
            }

            p {
                color: #555;
            }

            .results {
                margin-top: 20px;
            }

            .footer {
                margin-top: 20px;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Your Test Results</h1>
            <p>Thank you for completing the practice test. Here are your results:</p>

            <div class='results'>
                <p>Completion Time: {$results['completionTime']}</p>
                <p>Correct Answers: {$results['correct']}</p>
                <p>Incorrect Answers: {$results['incorrect']}</p>
                <p>Percentage: {$results['percent']}%</p>
            </div>

            <div class='footer'>
                <p>This email was sent automatically. Do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    // Set additional headers for HTML content
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Send the email
    mail($userEmail, $subject, $message, $headers);

    // Respond to the JavaScript request
    echo json_encode(['status' => 'success']);
} else {
    // Handle invalid requests
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
