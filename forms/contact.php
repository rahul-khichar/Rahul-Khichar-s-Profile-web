<?php
  // Replace with your actual email address
  $receiving_email_address = 'raskprive@gmail.com';  // Update this to your real email

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form inputs and sanitize them
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($subject) && !empty($message)) {
      
      // Prepare email headers and content
      $to = $receiving_email_address;
      $email_subject = "Contact Form Submission: $subject";
      $email_body = "You have received a new message from $name.\n\n".
                    "Email: $email\n\n".
                    "Message:\n$message\n";
      $headers = "From: $email\r\n".
                 "Reply-To: $email\r\n";

      // Send the email using the native mail() function
      if (mail($to, $email_subject, $email_body, $headers)) {
        // Email sent successfully
        echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully!']);
      } else {
        // Error in sending email
        echo json_encode(['success' => false, 'message' => 'There was a problem sending your message. Please try again later.']);
      }

    } else {
      // Input validation failed
      echo json_encode(['success' => false, 'message' => 'Please complete all required fields and provide a valid email address.']);
    }
  } else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
  }
?>
