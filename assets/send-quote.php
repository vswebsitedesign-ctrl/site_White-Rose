<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}
// Honeypot check
if (!empty($_POST['_honeypot'])) {
    http_response_code(200);
    exit;
}
$first_name    = htmlspecialchars(trim($_POST['first_name'] ?? ''));
$surname       = htmlspecialchars(trim($_POST['surname'] ?? ''));
$telephone     = htmlspecialchars(trim($_POST['telephone'] ?? ''));
$email         = htmlspecialchars(trim($_POST['email'] ?? ''));
$postcode      = htmlspecialchars(trim($_POST['postcode'] ?? ''));
$property_type = htmlspecialchars(trim($_POST['property_type'] ?? ''));
$message       = htmlspecialchars(trim($_POST['message'] ?? ''));
if (empty($first_name) || empty($telephone) || empty($postcode) || empty($property_type)) {
    http_response_code(400);
    echo 'Missing required fields.';
    exit;
}
$to      = 'info@whiterosehouseclearance.co.uk';
$subject = "New Clearance Quote Request — $postcode";
$body    = "Name: $first_name $surname\n"
         . "Telephone: $telephone\n"
         . "Email: $email\n"
         . "Postcode: $postcode\n"
         . "Type: $property_type\n"
         . "Message:\n$message\n";
$headers = "From: info@whiterosehouseclearance.co.uk\r\n"
         . "Reply-To: $email\r\n"
         . "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = mail($to, $subject, $body, $headers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You — White Rose House Clearance</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: sans-serif; background: #f4f4f4; color: #333; }
    .topbar { background: #002D62; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
    .topbar a { color: white; text-decoration: none; font-weight: bold; font-size: 0.95rem; }
    .topbar .call-btn { background: #ffcc00; color: #002D62; padding: 8px 16px; border-radius: 5px; font-weight: bold; font-size: 0.9rem; }
    .hero { background: linear-gradient(to right, rgba(0,0,0,0.2) 30%, rgba(0,0,0,0.85) 80%), url("/assets/images/Mel.webp") center/cover; padding: 60px 20px; text-align: center; color: white; }
    .hero h1 { font-size: 2.4rem; margin-bottom: 12px; }
    .hero p { font-size: 1.2rem; opacity: 0.9; }
    .card { background: white; max-width: 640px; margin: 40px auto; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); padding: 40px 36px; text-align: center; }
    .tick { font-size: 4rem; margin-bottom: 16px; }
    .card h2 { color: #002D62; font-size: 1.8rem; margin-bottom: 12px; }
    .card p { color: #555; font-size: 1.05rem; line-height: 1.7; margin-bottom: 16px; }
    .summary { background: #f8f9fa; border-left: 4px solid #ffcc00; border-radius: 6px; padding: 16px 20px; text-align: left; margin: 24px 0; font-size: 0.95rem; line-height: 1.8; color: #333; }
    .summary strong { color: #002D62; }
    .btn-call { display: inline-block; background: #002D62; color: #ffcc00; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 1.1rem; margin: 8px; }
    .btn-home { display: inline-block; background: #f4f4f4; color: #002D62; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 1rem; margin: 8px; border: 2px solid #002D62; }
    .reassurance { display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; margin-top: 32px; padding-top: 24px; border-top: 1px solid #eee; }
    .reassurance div { text-align: center; font-size: 0.9rem; color: #555; max-width: 120px; }
    .reassurance div span { display: block; font-size: 1.8rem; margin-bottom: 6px; }
    footer { background: #111; color: white; text-align: center; padding: 24px 20px; font-size: 0.9rem; margin-top: 40px; border-top: 4px solid #ffcc00; }
    footer a { color: #ffcc00; text-decoration: none; }
  </style>
</head>
<body>

<div class="topbar">
  <a href="/">White Rose House Clearance</a>
  <a href="tel:07881530713" class="call-btn">📞 Call Mel: 07881 530 713</a>
</div>

<div class="hero">
  <h1>Mel Will Be In Touch Shortly!</h1>
  <p>Your free quote request has been passed straight to Mel</p>
</div>

<div class="card">
  <div class="tick">🏠</div>
  <h2>Mel Has Your Request!</h2>
  <p>Thank you for contacting White Rose House Clearance. Mel personally handles every enquiry and will be in touch as soon as possible — usually the same day.</p>

  <div class="summary">
    <strong>Your enquiry summary:</strong><br>
    Name: <?php echo $first_name . ' ' . $surname; ?><br>
    Phone: <?php echo $telephone; ?><br>
    Postcode: <?php echo $postcode; ?><br>
    Type: <?php echo $property_type; ?>
    <?php if ($message): ?>
    <br>Details: <?php echo nl2br($message); ?>
    <?php endif; ?>
  </div>

  <p>Can't wait? Call Mel directly for an instant response:</p>
  <a href="tel:07881530713" class="btn-call">📞 Call Mel Now: 07881 530 713</a>
  <br>
  <a href="/" class="btn-home">← Back to Homepage</a>

  <div class="reassurance">
    <div><span>🏆</span>30+ Years Experience</div>
    <div><span>⚡</span>Same-Day Quotes</div>
    <div><span>♻️</span>Eco-Friendly Disposal</div>
    <div><span>✅</span>Fully Licensed & Insured</div>
  </div>
</div>

<footer>
  <p>&copy; <?php echo date('Y'); ?> White Rose House Clearance &nbsp;|&nbsp;
  <a href="/privacy-policy/">Privacy Policy</a> &nbsp;|&nbsp;
  <a href="/contact/">Contact</a></p>
</footer>

</body>
</html>
