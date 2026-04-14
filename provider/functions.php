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
