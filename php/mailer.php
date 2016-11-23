<?php
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $exampleEmailInput = strip_tags(trim($_POST["exampleEmailInput"]));
				$exampleEmailInput = str_replace(array("\r","\n"),array(" "," "),$exampleEmailInput);
        $exampleRecipientInput = filter_var(trim($_POST["exampleRecipientInput"]), FILTER_SANITIZE_EMAIL);
        $exampleMessage = trim($_POST["exampleMessage"]);

        // Check that data was sent to the mailer.
        if ( empty($exampleEmailInput) OR empty($exampleMessage) OR !filter_var($exampleRecipientInput, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "hello@example.com";

        // Set the email subject.
        $subject = "New contact from $exampleEmailInput";

        // Build the email content.
        $exampleRecipientInput_content = "Name: $exampleEmailInput\n";
        $exampleRecipientInput_content .= "Email: $exampleRecipientInput\n\n";
        $exampleRecipientInput_content .= "Message:\n$exampleMessage\n";

        // Build the email headers.
        $exampleRecipientInput_headers = "From: $exampleEmailInput <$exampleRecipientInput>";

        // Send the email.
        if (mail($recipient, $subject, $exampleRecipientInput_content, $exampleRecipientInput_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
