<?php
// Simple test to submit form tanpa CSRF issue

// Simulate form submission dengan proper session handling
$baseUrl = 'http://127.0.0.1:8000';
$sessionFile = '/tmp/session_test.txt';

// Step 1: Get login page dan CSRF token
echo "Step 1: Getting CSRF token from login page...\n";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $baseUrl . '/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR => $sessionFile,
    CURLOPT_COOKIEFILE => $sessionFile,
]);
$response = curl_exec($ch);
preg_match('/<input.*?name="_token".*?value="([^"]+)"/', $response, $matches);
$csrfToken = $matches[1] ?? null;
echo "CSRF Token: " . substr($csrfToken, 0, 20) . "...\n";

// Step 2: Login
echo "\nStep 2: Login...\n";
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrfToken,
    'username' => 'admin',
    'password' => 'admin123',
]));
$loginResponse = curl_exec($ch);
echo "Login response code: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";

// Step 3: Get form page
echo "\nStep 3: Getting form page...\n";
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/template-surat/surat-hukum');
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, null);
$formPage = curl_exec($ch);

// Step 4: Submit form dengan AJAX header
echo "\nStep 4: Submitting form with AJAX...\n";

$formData = [
    '_token' => $csrfToken,
    'judul_surat' => 'TEST KEPUTUSAN DIREKTUR',
    'nomor_surat' => 'TEST/999/XII/2025',
    'tentang' => 'Test Submission',
    'identitas_penetap' => 'DIREKTUR RSUD',
    'id_regulasi' => '1',
    'menimbang' => 'Test menimbang content',
    'mengingat' => 'Test mengingat content',
    'memutuskan[0]' => 'Keputusan pertama',
    'memutuskan[1]' => 'Keputusan kedua',
    'tempat_dibuat' => 'Gemolong',
    'tanggal_dibuat' => '2025-12-08',
    'jabatan_pembuat' => 'Direktur',
    'nama_pembuat' => 'Dr. Test Name',
    'template_id' => '1',
];

curl_setopt_array($ch, [
    CURLOPT_URL => $baseUrl . '/template-surat/hukum/store',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($formData),
    CURLOPT_HTTPHEADER => [
        'X-Requested-With: XMLHttpRequest',
        'Accept: application/json',
    ],
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "HTTP Code: $httpCode\n";
echo "Response:\n";
echo $response . "\n";

curl_close($ch);
?>
