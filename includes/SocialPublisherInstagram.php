<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Publisher Instagram
 * Publication via Instagram Graph API (Meta)
 *
 * Prérequis :
 * - App Facebook avec permissions : instagram_basic, instagram_content_publish
 * - Instagram Business Account lié à une Page Facebook
 * - platform_page_id = Instagram Business Account ID
 * - access_token = Page Access Token (longue durée)
 *
 * Note : Instagram API requiert obligatoirement une image ou vidéo.
 */

require_once __DIR__ . '/SocialPublisherInterface.php';

class SocialPublisherInstagram implements SocialPublisherInterface
{
    private string $apiVersion = 'v18.0';
    private string $baseUrl = 'https://graph.facebook.com';

    public function getPlatformName(): string
    {
        return 'instagram';
    }

    public function publish(array $post, array $channel): array
    {
        $igUserId = $channel['platform_page_id'] ?? '';
        $accessToken = $channel['access_token'] ?? '';

        if (empty($igUserId) || empty($accessToken)) {
            return ['success' => false, 'post_id' => null, 'error' => 'Instagram User ID ou Access Token manquant'];
        }

        if (empty($post['image_url'])) {
            return ['success' => false, 'post_id' => null, 'error' => 'Instagram requiert une image pour publier'];
        }

        $caption = '';
        if (!empty($post['title'])) {
            $caption = $post['title'] . "\n\n";
        }
        $caption .= $post['content'];
        if (!empty($post['link_url'])) {
            $caption .= "\n\n" . $post['link_url'];
        }

        // Etape 1 : Créer le container media
        $containerId = $this->createMediaContainer($igUserId, $accessToken, $post['image_url'], $caption);
        if (!$containerId) {
            return ['success' => false, 'post_id' => null, 'error' => 'Impossible de créer le container media Instagram'];
        }

        // Etape 2 : Publier le container
        return $this->publishContainer($igUserId, $accessToken, $containerId);
    }

    private function createMediaContainer(string $igUserId, string $token, string $imageUrl, string $caption): ?string
    {
        $url = "{$this->baseUrl}/{$this->apiVersion}/{$igUserId}/media";
        $params = [
            'image_url' => $imageUrl,
            'caption' => $caption,
            'access_token' => $token,
        ];

        $result = $this->callApi($url, $params);
        return $result['id'] ?? null;
    }

    private function publishContainer(string $igUserId, string $token, string $containerId): array
    {
        $url = "{$this->baseUrl}/{$this->apiVersion}/{$igUserId}/media_publish";
        $params = [
            'creation_id' => $containerId,
            'access_token' => $token,
        ];

        $result = $this->callApi($url, $params);

        if (isset($result['id'])) {
            return ['success' => true, 'post_id' => $result['id'], 'error' => null];
        }

        $errorMsg = $result['error']['message'] ?? 'Erreur lors de la publication Instagram';
        return ['success' => false, 'post_id' => null, 'error' => $errorMsg];
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
        curl_close($ch);

        return json_decode($response, true) ?: [];
    }
}
