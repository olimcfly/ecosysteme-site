<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Interface Publisher Social
 * Contrat commun pour tous les canaux de publication
 */

interface SocialPublisherInterface
{
    /**
     * Publier un post sur le canal
     * @param array $post Les données du post (title, content, image_url, link_url)
     * @param array $channel Les infos du canal (access_token, platform_page_id, etc.)
     * @return array ['success' => bool, 'post_id' => string|null, 'error' => string|null]
     */
    public function publish(array $post, array $channel): array;

    /**
     * Nom du canal
     */
    public function getPlatformName(): string;
}
