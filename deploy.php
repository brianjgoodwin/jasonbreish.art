<?php
// GitHub webhook auto-deploy handler

// Security: Verify webhook secret
$secret = getenv("WEBHOOK_SECRET");
$hub_signature = isset($_SERVER["HTTP_X_HUB_SIGNATURE_256"]) ? $_SERVER["HTTP_X_HUB_SIGNATURE_256"] : "";

$raw_payload = file_get_contents("php://input");
$expected_signature = "sha256=" . hash_hmac("sha256", $raw_payload, $secret);

if (!hash_equals($expected_signature, $hub_signature)) {
    header("HTTP/1.1 403 Forbidden");
    exit("Invalid signature");
}

// Parse payload
$payload = json_decode($raw_payload, true);

// Only deploy on push to main branch
if ($payload["ref"] !== "refs/heads/main") {
    exit("Not main branch, skipping deployment");
}

// Log the deployment
file_put_contents("/var/log/webhook-deploy.log", date("Y-m-d H:i:s") . " - Starting deployment\n", FILE_APPEND);

// Execute deployment script
$output = shell_exec("/usr/local/bin/deploy.sh 2>&1");

// Log output
file_put_contents("/var/log/webhook-deploy.log", $output . "\n", FILE_APPEND);

header("HTTP/1.1 200 OK");
echo "Deployment triggered";
