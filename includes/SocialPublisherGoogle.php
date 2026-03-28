<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Publisher Google Business Profile
 * Publication via Google Business Profile API (My Business v4)
 *
 * Prérequis :
 * - Projet Google Cloud avec API "My Business" activée
 * - OAuth2 avec scope : https://www.googleapis.com/auth/business.manage
 * - access_token = OAuth2 Bearer Token
 * - platform_page_id = accounts/{accountId}/locations/{locationId}
 */

require_once __DIR__ . '/SocialPublisherInterface.php';

class SocialPublisherGoogle implements SocialPublisherInterface
{
    private string $baseUrl = 'https://mybusiness.googleapis.com/v4';

    public function getPlatformName(): string
    {
        return 'google_business';
    }

    public function publish(array $post, array $channel): array
    {
        $accessToken = $channel['access_token'] ?? '';
        $locationPath = $channel['platform_page_id'] ?? '';

        if (empty($accessToken) || empty($locationPath)) {
            return ['success' => false, 'post_id' => null, 'error' => 'Access Token ou Location Path manquant'];
        }

        $summary = '';
        if (!empty($post['title'])) {
            $summary = $post['title'] . ' - ';
        }
        $summary .= $post['content'];
        // Google Business limite les posts a 1500 caracteres
        $summary = mb_substr($summary, 0, 1500);

        $payload = [
            'languageCode' => 'fr-FR',
            'summary' => $summary,
            'topicType' => 'STANDARD',
        ];

        // Ajouter un CTA si lien fourni
        if (!empty($post['link_url'])) {
            $payload['callToAction'] = [
                'actionType' => 'LEARN_MORE',
                'url' => $post['link_url'],
            ];
        }

        // Ajouter l'image si fournie
        if (!empty($post['image_url'])) {
            $payload['media'] = [
                [
                    'mediaFormat' => 'PHOTO',
                    'sourceUrl' => $post['image_url'],
                ],
            ];
        }

        return $this->callApi($accessToken, $locationPath, $payload);
    }

    private function callApi(string $token, string $locationPath, array $payload): array
    {
        $url = $this->baseUrl . '/' . $locationPath . '/localPosts';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return ['success' => false, 'post_id' => null, 'error' => 'cURL: ' . $curlError];
        }

        $data = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300 && isset($data['name'])) {
            return ['success' => true, 'post_id' => $data['name'], 'error' => null];
        }

        $errorMsg = $data['error']['message'] ?? "HTTP {$httpCode} - Erreur Google Business";
        return ['success' => false, 'post_id' => null, 'error' => $errorMsg];
    }
}
