<?php

declare(strict_types=1);

/**
 * Simule le comportement d'un traitement de formulaire "capture" sans base de données.
 * Retourne un tableau contenant le statut, le message et la redirection éventuelle.
 */
function simulateCaptureTraitement(array $post, array $session): array
{
    if (empty($post['csrf_token']) || empty($session['csrf_token']) || !hash_equals($session['csrf_token'], (string) $post['csrf_token'])) {
        return [
            'status' => 'error',
            'message' => 'Token CSRF invalide',
            'redirect' => '/pages/capture/index.php',
        ];
    }

    $email = trim((string) ($post['email'] ?? ''));
    $nom = trim((string) ($post['nom'] ?? ''));

    if ($email === '' || $nom === '') {
        return [
            'status' => 'error',
            'message' => 'Champ obligatoire manquant',
            'redirect' => '/pages/capture/index.php',
        ];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'status' => 'error',
            'message' => 'Email invalide',
            'redirect' => '/pages/capture/index.php',
        ];
    }

    // Protection XSS: vérifier que les sorties seraient échappées.
    $nomSafe = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');

    return [
        'status' => 'success',
        'message' => 'Soumission valide',
        'redirect' => '/pages/capture/succes.php',
        'payload' => [
            'email' => $email,
            'nom_safe' => $nomSafe,
        ],
    ];
}

$csrfToken = bin2hex(random_bytes(32));
$baseSession = ['csrf_token' => $csrfToken];

$tests = [
    [
        'name' => 'Email invalide',
        'post' => ['email' => 'test@', 'nom' => 'Jean Dupont', 'csrf_token' => $csrfToken],
        'expected' => ['status' => 'error', 'message' => 'Email invalide'],
        'failure_fix' => 'Ajouter/renforcer la validation email avec filter_var(..., FILTER_VALIDATE_EMAIL).',
    ],
    [
        'name' => 'Champs vides',
        'post' => ['email' => '', 'nom' => '', 'csrf_token' => $csrfToken],
        'expected' => ['status' => 'error', 'message' => 'Champ obligatoire manquant'],
        'failure_fix' => 'Vérifier les champs requis avant toute logique métier et renvoyer une erreur explicite.',
    ],
    [
        'name' => 'Injection SQL dans email',
        'post' => ['email' => "test@test.com' OR '1'='1", 'nom' => 'Attaquant', 'csrf_token' => $csrfToken],
        'expected' => ['status' => 'error', 'message' => 'Email invalide'],
        'failure_fix' => 'Utiliser des requêtes préparées côté persistance et conserver la validation stricte du format email.',
    ],
    [
        'name' => 'XSS dans nom',
        'post' => ['email' => 'valide@example.com', 'nom' => "<script>alert('XSS')</script>", 'csrf_token' => $csrfToken],
        'expected' => ['status' => 'success', 'message' => 'Soumission valide'],
        'extra_assert' => static function (array $result): bool {
            return isset($result['payload']['nom_safe'])
                && $result['payload']['nom_safe'] === '&lt;script&gt;alert(&#039;XSS&#039;)&lt;/script&gt;';
        },
        'failure_fix' => 'Échapper systématiquement toutes les sorties utilisateur avec htmlspecialchars(..., ENT_QUOTES, "UTF-8").',
    ],
    [
        'name' => 'CSRF manquant',
        'post' => ['email' => 'valide@example.com', 'nom' => 'Jean'],
        'expected' => ['status' => 'error', 'message' => 'Token CSRF invalide'],
        'failure_fix' => 'Générer un token en session, l’injecter dans le formulaire et le vérifier côté serveur.',
    ],
    [
        'name' => 'CSRF invalide',
        'post' => ['email' => 'valide@example.com', 'nom' => 'Jean', 'csrf_token' => 'token_invalide'],
        'expected' => ['status' => 'error', 'message' => 'Token CSRF invalide'],
        'failure_fix' => 'Utiliser hash_equals() pour comparer le token soumis avec celui stocké en session.',
    ],
    [
        'name' => 'Soumission valide',
        'post' => ['email' => 'valide@example.com', 'nom' => 'Jean Dupont', 'csrf_token' => $csrfToken],
        'expected' => ['status' => 'success', 'message' => 'Soumission valide'],
        'failure_fix' => 'Vérifier que la redirection de succès et le message utilisateur correspondent au comportement attendu.',
    ],
];

$passed = 0;
$results = [];

foreach ($tests as $test) {
    $result = simulateCaptureTraitement($test['post'], $baseSession);

    $ok = $result['status'] === $test['expected']['status']
        && $result['message'] === $test['expected']['message'];

    if (isset($test['extra_assert']) && is_callable($test['extra_assert'])) {
        $ok = $ok && (bool) $test['extra_assert']($result);
    }

    if ($ok) {
        ++$passed;
    }

    $results[] = [
        'name' => $test['name'],
        'ok' => $ok,
        'expected' => $test['expected'],
        'actual' => ['status' => $result['status'], 'message' => $result['message']],
        'suggestion' => $ok ? null : $test['failure_fix'],
    ];
}

$total = count($tests);

echo "=== Rapport de tests formulaires frontend (sans DB) ===\n";
echo sprintf("Résultat global : %d/%d tests passés\n\n", $passed, $total);

foreach ($results as $item) {
    echo sprintf("[%s] %s\n", $item['ok'] ? 'PASS' : 'FAIL', $item['name']);
    if (!$item['ok']) {
        echo sprintf("  - Attendu : %s / %s\n", $item['expected']['status'], $item['expected']['message']);
        echo sprintf("  - Obtenu  : %s / %s\n", $item['actual']['status'], $item['actual']['message']);
        echo sprintf("  - Correction proposée : %s\n", $item['suggestion']);
    }
}

exit($passed === $total ? 0 : 1);
