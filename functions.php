<?php
include 'config.php';

// ------------------------
// Payment Processing
// ------------------------
function processPayment($job_id, $amount, $payment_method){
    global $conn;

    // Admin commission 23%
    $commission = $amount * 0.23;
    $provider_amount = $amount - $commission;

    // Insert into payments table
    $stmt = $conn->prepare("INSERT INTO payments(job_id,amount,admin_commission,payment_method) VALUES(?,?,?,?)");
    $stmt->bind_param("ddds",$job_id,$amount,$commission,$payment_method);
    $stmt->execute();

    // Update job status to completed (simulated)
    $conn->query("UPDATE jobs SET status='completed' WHERE id=$job_id");

    return "Payment of $amount via ".strtoupper($payment_method)." processed. Admin commission: $commission, Provider receives: $provider_amount.";
}

// ------------------------
// Get Average Rating for Provider
// ------------------------
function getProviderRating($provider_id){
    global $conn;
    $res = $conn->query("SELECT AVG(rating) as avg_rating FROM reviews WHERE provider_id=$provider_id")->fetch_assoc();
    return $res['avg_rating'] ?? 0;
}

// ------------------------
// Fetch Provider Services
// ------------------------
function getProviderServices($provider_id){
    global $conn;
    $services = [];
    $result = $conn->query("SELECT * FROM services WHERE provider_id=$provider_id");
    while($row = $result->fetch_assoc()){
        $services[] = $row;
    }
    return $services;
}

// ------------------------
// Fetch User Info
// ------------------------
function getUser($user_id){
    global $conn;
    return $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
}

// ------------------------
// Fetch Client Jobs
// ------------------------
function getClientJobs($client_id){
    global $conn;
    $jobs = $conn->query("SELECT j.*, u.fullname as provider_name, s.service_name FROM jobs j 
                          JOIN users u ON j.provider_id=u.id 
                          JOIN services s ON j.service_id=s.id 
                          WHERE j.client_id=$client_id ORDER BY j.created_at DESC");
    return $jobs;
}

// ------------------------
// Fetch Provider Jobs
// ------------------------
function getProviderJobs($provider_id){
    global $conn;
    $jobs = $conn->query("SELECT j.*, u.fullname as client_name, s.service_name FROM jobs j 
                          JOIN users u ON j.client_id=u.id 
                          JOIN services s ON j.service_id=s.id 
                          WHERE j.provider_id=$provider_id ORDER BY j.created_at DESC");
    return $jobs;
}

// ------------------------
// Fetch All Clients
// ------------------------
function getAllClients(){
    global $conn;
    return $conn->query("SELECT * FROM users WHERE role='client'");
}

// ------------------------
// Fetch All Providers
// ------------------------
function getAllProviders(){
    global $conn;
    return $conn->query("SELECT * FROM users WHERE role='provider'");
}

// ------------------------
// Fetch All Reviews
// ------------------------
function getAllReviews(){
    global $conn;
    return $conn->query("SELECT r.*, c.fullname as client_name, p.fullname as provider_name 
                         FROM reviews r 
                         JOIN users c ON r.client_id=c.id 
                         JOIN users p ON r.provider_id=p.id 
                         ORDER BY r.created_at DESC");
}
function getProviderAverageRating($provider_id, $conn) {
    $res = $conn->query("SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews 
                         FROM reviews 
                         WHERE provider_id=$provider_id");
    if($res->num_rows > 0){
        $data = $res->fetch_assoc();
        return [
            'avg' => round($data['avg_rating'], 1),
            'count' => $data['total_reviews']
        ];
    }
    return ['avg'=>0, 'count'=>0];
}


?>
