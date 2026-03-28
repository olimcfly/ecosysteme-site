<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Publisher Facebook
 * Publication via Facebook Graph API v18.0
 *
 * Prérequis :
 * - App Facebook avec permissions : pages_manage_posts, pages_read_engagement
 * - Page Access Token (longue durée) stocké dans social_channels.access_token
 * - Page ID stocké dans social_channels.platform_page_id
 */

require_once __DIR__ . '/SocialPublisherInterface.php';

class SocialPublisherFacebook implements SocialPublisherInterface
{
    private string $apiVersion = 'v18.0';
    private string $baseUrl = 'https://graph.facebook.com';

    public function getPlatformName(): string
    {
        return 'facebook';
    }

    public function publish(array $post, array $channel): array
    {
        $pageId = $channel['platform_page_id'] ?? '';
        $accessToken = $channel['access_token'] ?? '';

        if (empty($pageId) || empty($accessToken)) {
            return ['success' => false, 'post_id' => null, 'error' => 'Page ID ou Access Token manquant'];
        }

        $message = $post['content'];
        if (!empty($post['title'])) {
            $message = $post['title'] . "\n\n" . $message;
        }

        // Si image : publier une photo avec message
        if (!empty($post['image_url'])) {
            return $this->publishPhoto($pageId, $accessToken, $message, $post['image_url'], $post['link_url'] ?? null);
        }

        // Sinon : publier un post texte (avec lien optionnel)
        return $this->publishPost($pageId, $accessToken, $message, $post['link_url'] ?? null);
    }

    private function publishPost(string $pageId, string $token, string $message, ?string $link): array
    {
        $url = "{$this->baseUrl}/{$this->apiVersion}/{$pageId}/feed";
        $params = [
            'message' => $message,
            'access_token' => $token,
        ];

        if (!empty($link)) {
            $params['link'] = $link;
        }

        return $this->callApi($url, $params);
    }

    private function publishPhoto(string $pageId, string $token, string $message, string $imageUrl, ?string $link): array
    {
        $url = "{$this->baseUrl}/{$this->apiVersion}/{$pageId}/photos";
        $params = [
            'message' => $message . (!empty($link) ? "\n\n" . $link : ''),
            'url' => $imageUrl,
            'access_token' => $token,
        ];

        return $this->callApi($url, $params);
    }

    private function callApi(string $url, array $params): array
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
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

        if ($httpCode >= 200 && $httpCode < 300 && isset($data['id'])) {
            return ['success' => true, 'post_id' => $data['id'], 'error' => null];
        }

        $errorMsg = $data['error']['message'] ?? "HTTP {$httpCode} - Réponse inattendue";
        return ['success' => false, 'post_id' => null, 'error' => $errorMsg];
    }
}
