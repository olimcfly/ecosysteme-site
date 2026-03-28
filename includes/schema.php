<?php
/**
 * Données structurées Schema.org (JSON-LD)
 *
 * Génère les schemas : Organization, LocalBusiness, WebSite (avec SearchAction),
 * et FAQPage (si $schemaFAQ est défini).
 *
 * Variables acceptées :
 *   $schemaFAQ — tableau de questions/réponses [['question' => '...', 'answer' => '...'], ...]
 */

$siteUrl  = 'https://ecosystemeimmo.fr';
$siteName = 'ÉCOSYSTÈME IMMO LOCAL+';

// ── Organization ──
$organization = [
    '@type'       => 'Organization',
    '@id'         => $siteUrl . '/#organization',
    'name'        => $siteName,
    'url'         => $siteUrl,
    'logo'        => $siteUrl . '/assets/img/logo.png',
    'email'       => 'contact@ecosystemeimmo.fr',
    'description' => 'Plateforme SaaS tout-en-un pour les agents immobiliers indépendants : site, SEO local, CRM, IA et méthode guidée.',
    'sameAs'      => []
];

// ── LocalBusiness ──
$localBusiness = [
    '@type'       => 'LocalBusiness',
    '@id'         => $siteUrl . '/#localbusiness',
    'name'        => $siteName,
    'url'         => $siteUrl,
    'email'       => 'contact@ecosystemeimmo.fr',
    'description' => 'Plateforme digitale complète avec exclusivité territoriale pour les professionnels de l\'immobilier.',
    'priceRange'  => '€€',
    'address'     => [
        '@type'          => 'PostalAddress',
        'addressCountry' => 'FR'
    ]
];

// ── WebSite avec SearchAction ──
$webSite = [
    '@type'          => 'WebSite',
    '@id'            => $siteUrl . '/#website',
    'name'           => $siteName,
    'url'            => $siteUrl,
    'publisher'      => ['@id' => $siteUrl . '/#organization'],
    'potentialAction' => [
        '@type'       => 'SearchAction',
        'target'      => $siteUrl . '/blog?q={search_term_string}',
        'query-input' => 'required name=search_term_string'
    ]
];

// ── Graph principal ──
$graph = [$organization, $localBusiness, $webSite];

// ── FAQPage (conditionnel) ──
if (isset($schemaFAQ) && is_array($schemaFAQ) && count($schemaFAQ) > 0) {
    $faqEntries = [];
    foreach ($schemaFAQ as $item) {
        $faqEntries[] = [
            '@type'          => 'Question',
            'name'           => $item['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $item['answer']
            ]
        ];
    }
    $graph[] = [
        '@type'      => 'FAQPage',
        'mainEntity' => $faqEntries
    ];
}

$schema = [
    '@context' => 'https://schema.org',
    '@graph'   => $graph
];
?>
<script type="application/ld+json">
<?php echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

</script>
