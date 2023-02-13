<?php

session_start();

print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $txtMsg = $_POST['message'];
    
    $secret = "6LcrgXgkAAAAAFQzMkuujSqegpIuILKcL7K_dI9u";
    $token = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$token."&remoteip=".$remoteip;
    $request = file_get_contents($url);
    $response = json_decode($request, true);

    print_r($response);
    
    if ($response["success"] == true && $response["score"] >= 0.8) {
        echo "
            <h2>Contact Details</h2>
            <p>
                <b>Full Name : </b>".$fname." ".$lname."<br>
                <b>Email Address : </b>".$email."<br>
                <b>Phone Number : </b>".$number."<br>
                <b>Gender : </b>".$gender."<br>
                <b>Country : </b>".$country."<br>
                <b>Additional Information : </b>".$txtMsg."<br>
            </p>
        ";

        $to = "shreyamoghe20@gmail.com";
        $subject = "Contact Data Submission";
        $sendmessage = "Name: $fname $lname\n
                    Email: $email\n
                    Phone number: $number\n
                    Gender: $gender\n
                    Country: $country\n
                    Message: $message\n
        ";
        
        $headers = "From: $email" . "\r\n";

        if (mail($to, $subject, $sendmessage, $header)) {
            echo "Email send Successfully!!";
        }
        else{
            echo "Failed to send email";
        }
    } 
    else {
        echo "reCAPTCHA Verification failed. Please try again.";
    }
}

?>




