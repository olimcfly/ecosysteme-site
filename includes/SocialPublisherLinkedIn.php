<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Publisher LinkedIn
 * Publication via LinkedIn Marketing API v2
 *
 * Prérequis :
 * - App LinkedIn avec produit "Share on LinkedIn" ou "Marketing Developer Platform"
 * - Permissions : w_member_social (profil perso) ou w_organization_social (page entreprise)
 * - access_token = OAuth2 Bearer Token
 * - platform_user_id = URN de l'auteur (ex: "urn:li:person:xxx" ou "urn:li:organization:xxx")
 */

require_once __DIR__ . '/SocialPublisherInterface.php';

class SocialPublisherLinkedIn implements SocialPublisherInterface
{
    private string $baseUrl = 'https://api.linkedin.com/v2';

    public function getPlatformName(): string
    {
        return 'linkedin';
    }

    public function publish(array $post, array $channel): array
    {
        $accessToken = $channel['access_token'] ?? '';
        $authorUrn = $channel['platform_user_id'] ?? '';

        if (empty($accessToken) || empty($authorUrn)) {
            return ['success' => false, 'post_id' => null, 'error' => 'Access Token ou Author URN manquant'];
        }

        $text = '';
        if (!empty($post['title'])) {
            $text = $post['title'] . "\n\n";
        }
        $text .= $post['content'];

        $payload = [
            'author' => $authorUrn,
            'lifecycleState' => 'PUBLISHED',
            'specificContent' => [
                'com.linkedin.ugc.ShareContent' => [
                    'shareCommentary' => [
                        'text' => $text,
                    ],
                    'shareMediaCategory' => 'NONE',
                ],
            ],
            'visibility' => [
                'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
            ],
        ];

        // Ajouter un article/lien si URL fournie
        if (!empty($post['link_url'])) {
            $media = [
                'status' => 'READY',
                'originalUrl' => $post['link_url'],
            ];
            if (!empty($post['title'])) {
                $media['title'] = ['text' => $post['title']];
            }
            if (!empty($post['image_url'])) {
                $media['thumbnails'] = [['url' => $post['image_url']]];
            }
            $payload['specificContent']['com.linkedin.ugc.ShareContent']['shareMediaCategory'] = 'ARTICLE';
            $payload['specificContent']['com.linkedin.ugc.ShareContent']['media'] = [$media];
        } elseif (!empty($post['image_url'])) {
            // Image sans lien : mentionner l'URL dans le texte
            $payload['specificContent']['com.linkedin.ugc.ShareContent']['shareCommentary']['text'] .= "\n\n" . $post['image_url'];
        }

        return $this->callApi($accessToken, $payload);
    }

    private function callApi(string $token, array $payload): array
    {
        $url = $this->baseUrl . '/ugcPosts';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'X-Restli-Protocol-Version: 2.0.0',
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

        if ($httpCode === 201 && isset($data['id'])) {
            return ['success' => true, 'post_id' => $data['id'], 'error' => null];
        }

        $errorMsg = $data['message'] ?? "HTTP {$httpCode} - Erreur LinkedIn";
        return ['success' => false, 'post_id' => null, 'error' => $errorMsg];
    }
}
