<?php
// Check if form is submitted
if (isset($_POST['email'])) {
    // Email address to receive the form submission
    $email_to = "hamnairfan@gmail.com";
    // Subject of the email
    $email_subject = "You've got a new submission";

    // Function to handle errors
    function problem($error)
    {
        echo "Oh looks like there is some problem with your form data: <br><br>";
        echo $error . "<br><br>";
        echo "Please fix those to proceed.<br><br>";
        die();
    }

    // Check if required fields are set
    if (
        !isset($_POST['fullName']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])
    ) {
        problem('Oh looks like there is some problem with your form data.');
    }

    // Get form data
    $name = $_POST['fullName']; // required
    $email = $_POST['email']; // required
    $message = $_POST['message']; // required

    // Initialize error message
    $error_message = "";
    // Regular expression for validating email format
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    // Validate email format
    if (!preg_match($email_exp, $email)) {
        $error_message .= 'Email address does not seem valid.<br>';
    }

    // Regular expression for validating name format
    $string_exp = "/^[A-Za-z .'-]+$/";

    // Validate name format
    if (!preg_match($string_exp, $name)) {
        $error_message .= 'Name does not seem valid.<br>';
    }

    // Validate message length
    if (strlen($message) < 2) {
        $error_message .= 'Message should not be less than 2 characters<br>';
    }

    // If there are errors, display them and stop execution
    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    // Construct email message
    $email_message = "Form details following:\n\n";
    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";

    // Function to clean strings
    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    // Create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    
    // Send the email
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- Replace this as your success message -->

    Thanks for contacting us, we will get back to you as soon as possible.

<?php
}
?>
