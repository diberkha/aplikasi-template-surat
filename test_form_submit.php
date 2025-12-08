<?php
// Test script untuk submit form via CURL dengan session login

$username = 'admin';
$password = 'admin123';
$baseUrl = 'http://127.0.0.1:8000';

// 1. Login first
echo "1. Logging in...\n";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $baseUrl . '/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_COOKIEJAR => '/tmp/cookies.txt',
    CURLOPT_COOKIEFILE => '/tmp/cookies.txt',
]);
$response = curl_exec($ch);

// Get CSRF token from login page
preg_match('/<input.*?name="_token".*?value="([^"]+)"/', $response, $matches);
$csrfToken = $matches[1] ?? '';
echo "CSRF Token: " . substr($csrfToken, 0, 20) . "...\n";

// Login dengan credentials
echo "2. Submitting login credentials...\n";
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrfToken,
    'username' => $username,
    'password' => $password,
]));
$response = curl_exec($ch);
echo "Login response code: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";

// 2. Get form page to extract CSRF token
echo "3. Getting form page...\n";
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/template-surat/surat-hukum');
curl_setopt($ch, CURLOPT_POST, false);
$response = curl_exec($ch);

// Get NEW CSRF token from form page after login
preg_match('/<input.*?name="_token".*?value="([^"]+)"/', $response, $matches);
$newCsrfToken = $matches[1] ?? $csrfToken;
echo "New CSRF Token after form page: " . substr($newCsrfToken, 0, 20) . "...\n";

// Get API data for regulasi list
echo "4. Getting regulasi keputusan list...\n";
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/regulasi/keputusan-list');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Requested-With: XMLHttpRequest', 'Content-Type: application/json']);
$apiResponse = curl_exec($ch);
$regulasiList = json_decode($apiResponse, true);
echo "Regulasi list count: " . count($regulasiList) . "\n";
if (count($regulasiList) > 0) {
    echo "First regulasi: " . json_encode($regulasiList[0]) . "\n";
    $regulasiId = $regulasiList[0]['id_regulasi'];
    
    // Get regulasi data
    echo "5. Getting regulasi data for ID: $regulasiId\n";
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/regulasi/' . $regulasiId . '/data');
    $dataResponse = curl_exec($ch);
    $regulasiData = json_decode($dataResponse, true);
    echo "Regulasi data: " . json_encode($regulasiData) . "\n";
}

// Get new CSRF token from form page
$newCsrfToken = preg_match('/<input.*?name="_token".*?value="([^"]+)"/', $response, $matches) ? $matches[1] : $csrfToken;
echo "Using CSRF token: " . substr($newCsrfToken, 0, 20) . "...\n";

// 3. Submit form
echo "6. Submitting form...\n";
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/template-surat/hukum/store');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $newCsrfToken,
    'judul_surat' => 'TEST KEPUTUSAN DIREKTUR',
    'nomor_surat' => 'TEST/001/XII/2025',
    'tentang' => 'Test Submission',
    'identitas_penetap' => 'DIREKTUR RSUD',
    'id_regulasi' => $regulasiId ?? 1,
    'menimbang' => 'Test menimbang',
    'mengingat' => 'Test mengingat',
    'memutuskan' => ['Keputusan 1', 'Keputusan 2'],
    'tempat_dibuat' => 'Gemolong',
    'tanggal_dibuat' => '2025-12-08',
    'jabatan_pembuat' => 'Direktur',
    'nama_pembuat' => 'Dr. Test',
    'template_id' => 1,
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Requested-With: XMLHttpRequest', 'Accept: application/json']);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "Form submission response code: $httpCode\n";
echo "Response body:\n";
echo $response . "\n";

curl_close($ch);
echo "\nTest completed!\n";
?>
