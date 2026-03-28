<?php
/**
 * ÉCOSYSTÈME IMMO+ - API AI Générateur d'Offres
 * Chat IA guidé pour construire une offre immobilière complète
 * Utilise l'API Anthropic pour guider l'utilisateur étape par étape
 */

error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/rate-limiter.php';
require_once __DIR__ . '/../includes/api-auth.php';

checkRateLimit();
requireApiAuthOrAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['action'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
    exit;
}

// =====================================================
// Créer la table si elle n'existe pas
// =====================================================
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS offres (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titre VARCHAR(255) NOT NULL,
            persona TEXT NULL,
            probleme TEXT NULL,
            motivation TEXT NULL,
            promesse TEXT NULL,
            methode TEXT NULL,
            contenu_offre TEXT NULL,
            prix_valeur TEXT NULL,
            preuves TEXT NULL,
            resume_offre TEXT NULL,
            conversation JSON NULL,
            statut ENUM('brouillon', 'validee', 'active', 'archivee') NOT NULL DEFAULT 'brouillon',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_statut (statut),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
} catch (PDOException $e) {
    // Table already exists or other non-critical error
}

$action = $input['action'];

// =====================================================
// Appel API Anthropic avec historique de conversation
// =====================================================
function callAnthropicChat($systemPrompt, $messages, $maxTokens = 2000) {
    $apiKey = defined('ANTHROPIC_API_KEY') ? ANTHROPIC_API_KEY : '';
    $model = defined('ANTHROPIC_MODEL') ? ANTHROPIC_MODEL : 'claude-sonnet-4-20250514';

    if (empty($apiKey)) {
        throw new Exception('Clé API Anthropic non configurée');
    }

    $data = [
        'model' => $model,
        'max_tokens' => $maxTokens,
        'system' => $systemPrompt,
        'messages' => $messages
    ];

    $ch = curl_init('https://api.anthropic.com/v1/messages');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'x-api-key: ' . $apiKey,
            'anthropic-version: 2023-06-01'
        ],
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_TIMEOUT => 90
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        throw new Exception('Erreur cURL: ' . $error);
    }

    if ($httpCode !== 200) {
        $errorData = json_decode($response, true);
        $errorMsg = $errorData['error']['message'] ?? 'Erreur API (code ' . $httpCode . ')';
        throw new Exception($errorMsg);
    }

    $result = json_decode($response, true);

    if (!isset($result['content'][0]['text'])) {
        throw new Exception('Réponse API invalide');
    }

    return $result['content'][0]['text'];
}

// =====================================================
// System prompt du coach offre immobilière
// =====================================================
function getOffreSystemPrompt() {
    return <<<'PROMPT'
Tu es un coach expert en création d'offres immobilières. Tu guides les conseillers immobiliers pour construire leur OFFRE SIGNATURE complète et irrésistible.

Tu travailles pour ÉCOSYSTÈME IMMO LOCAL+, une plateforme qui aide les professionnels de l'immobilier à structurer leur business.

🎯 TON OBJECTIF : Guider l'utilisateur étape par étape pour construire une offre qui convertit, basée sur 8 composantes clés.

📋 LES 8 COMPOSANTES D'UNE OFFRE :
1️⃣ Le Persona (à qui tu t'adresses)
2️⃣ Le Problème principal (la douleur urgente)
3️⃣ La Motivation profonde (l'émotion : sécurité, liberté, reconnaissance, contrôle)
4️⃣ La Promesse (le résultat concret, en combien de temps, avec quelle méthode)
5️⃣ La Méthode / Approche unique (pourquoi toi et pas un autre)
6️⃣ Le Contenu de l'offre (ce que le client reçoit concrètement)
7️⃣ Le Prix + la valeur (combien et pourquoi ça vaut ce prix)
8️⃣ Les Preuves + Réassurance (avis, résultats, garanties)

📌 TON PROCESS DE COACHING :

ÉTAPE 1 — POSITIONNEMENT (Questions 1-3)
- Quel est ton métier exact ?
- Sur quelle zone tu travailles ?
- Tu veux cibler plutôt : vendeurs, acheteurs, ou investisseurs ?

ÉTAPE 2 — PERSONA (Questions 4-6)
- Qui veux-tu attirer en priorité ? (ex : vendeur senior, jeune couple…)
- Quel est son problème principal aujourd'hui ?
- Qu'est-ce qu'il veut vraiment au fond ? (sécurité, liberté, gain…)

ÉTAPE 3 — PROMESSE (Questions 7-9)
- Quel résultat tu peux lui garantir ?
- En combien de temps ?
- Qu'est-ce qui te rend différent des autres agents ?

ÉTAPE 4 — OFFRE (Questions 10-12)
- Qu'est-ce que tu proposes concrètement ? (liste tes services)
- Quelle est ta méthode ?
- As-tu une offre "signature" ?

ÉTAPE 5 — VALEUR (Questions 13-14)
- Combien tu fais payer ?
- Pourquoi ton offre vaut ce prix ?

ÉTAPE 6 — CONFIANCE (Questions 15-17)
- As-tu des résultats clients ?
- Peux-tu proposer une garantie ?
- Quelles preuves peux-tu montrer ?

⚙️ RÈGLES IMPORTANTES :
- Pose les questions PAR ÉTAPE (2-3 questions maximum à la fois)
- Reformule et valide les réponses avec l'utilisateur avant de passer à l'étape suivante
- Sois encourageant et donne des exemples concrets pour aider
- Utilise un ton professionnel mais chaleureux et motivant
- Quand tu as toutes les infos, propose un RÉSUMÉ STRUCTURÉ de l'offre complète
- À la fin, demande à l'utilisateur de valider son offre

📝 FORMAT DU RÉSUMÉ FINAL :
Quand tu as toutes les informations, génère un résumé structuré dans ce format EXACT (en incluant le marqueur) :

---OFFRE_COMPLETE---
{
  "titre": "Nom de l'offre signature",
  "persona": "Description du client idéal",
  "probleme": "Le problème principal identifié",
  "motivation": "La motivation profonde",
  "promesse": "La promesse de résultat",
  "methode": "La méthode/approche unique",
  "contenu_offre": "Liste détaillée des services inclus",
  "prix_valeur": "Prix et justification de la valeur",
  "preuves": "Preuves et réassurances",
  "resume_offre": "Résumé marketing complet de l'offre en 3-5 paragraphes"
}
---FIN_OFFRE---

IMPORTANT : N'inclus le bloc ---OFFRE_COMPLETE--- que lorsque tu as TOUTES les informations et que l'utilisateur a validé. Avant cela, continue le coaching question par question.

Commence TOUJOURS par te présenter brièvement et poser les 3 premières questions (Étape 1 - Positionnement).
PROMPT;
}

// =====================================================
// TRAITEMENT DES ACTIONS
// =====================================================

try {
    switch ($action) {

        // Envoyer un message dans le chat et recevoir la réponse IA
        case 'chat':
            $messages = $input['messages'] ?? [];

            if (empty($messages)) {
                throw new Exception('Les messages sont requis');
            }

            // Valider le format des messages
            $validMessages = [];
            foreach ($messages as $msg) {
                if (!isset($msg['role']) || !isset($msg['content'])) {
                    continue;
                }
                if (!in_array($msg['role'], ['user', 'assistant'])) {
                    continue;
                }
                $validMessages[] = [
                    'role' => $msg['role'],
                    'content' => trim($msg['content'])
                ];
            }

            if (empty($validMessages)) {
                throw new Exception('Aucun message valide');
            }

            $systemPrompt = getOffreSystemPrompt();
            $response = callAnthropicChat($systemPrompt, $validMessages, 2000);

            // Vérifier si l'offre complète est incluse dans la réponse
            $offreData = null;
            if (preg_match('/---OFFRE_COMPLETE---\s*(\{[\s\S]*?\})\s*---FIN_OFFRE---/', $response, $matches)) {
                $offreData = json_decode($matches[1], true);
            }

            echo json_encode([
                'success' => true,
                'response' => $response,
                'offre_data' => $offreData
            ]);
            break;

        // Démarrer une nouvelle conversation (premier message de l'IA)
        case 'start':
            $systemPrompt = getOffreSystemPrompt();
            $messages = [
                ['role' => 'user', 'content' => 'Bonjour, je veux créer mon offre immobilière.']
            ];

            $response = callAnthropicChat($systemPrompt, $messages, 1500);

            echo json_encode([
                'success' => true,
                'response' => $response
            ]);
            break;

        // Sauvegarder l'offre validée en base de données
        case 'save_offre':
            $offreData = $input['offre_data'] ?? null;
            $conversation = $input['conversation'] ?? [];

            if (!$offreData || empty($offreData['titre'])) {
                throw new Exception('Les données de l\'offre sont requises');
            }

            $stmt = $pdo->prepare("
                INSERT INTO offres (titre, persona, probleme, motivation, promesse, methode, contenu_offre, prix_valeur, preuves, resume_offre, conversation, statut)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'brouillon')
            ");

            $stmt->execute([
                $offreData['titre'] ?? 'Offre sans titre',
                $offreData['persona'] ?? null,
                $offreData['probleme'] ?? null,
                $offreData['motivation'] ?? null,
                $offreData['promesse'] ?? null,
                $offreData['methode'] ?? null,
                $offreData['contenu_offre'] ?? null,
                $offreData['prix_valeur'] ?? null,
                $offreData['preuves'] ?? null,
                $offreData['resume_offre'] ?? null,
                json_encode($conversation, JSON_UNESCAPED_UNICODE)
            ]);

            $offreId = $pdo->lastInsertId();

            echo json_encode([
                'success' => true,
                'offre_id' => $offreId,
                'message' => 'Offre sauvegardée avec succès'
            ]);
            break;

        // Lister les offres
        case 'list_offres':
            $statut = $input['statut'] ?? null;
            $sql = "SELECT id, titre, statut, created_at, updated_at FROM offres";
            $params = [];

            if ($statut) {
                $sql .= " WHERE statut = ?";
                $params[] = $statut;
            }

            $sql .= " ORDER BY created_at DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $offres = $stmt->fetchAll();

            echo json_encode([
                'success' => true,
                'offres' => $offres
            ]);
            break;

        // Récupérer une offre par ID
        case 'get_offre':
            $id = intval($input['id'] ?? 0);
            if ($id <= 0) {
                throw new Exception('ID invalide');
            }

            $stmt = $pdo->prepare("SELECT * FROM offres WHERE id = ?");
            $stmt->execute([$id]);
            $offre = $stmt->fetch();

            if (!$offre) {
                throw new Exception('Offre non trouvée');
            }

            echo json_encode([
                'success' => true,
                'offre' => $offre
            ]);
            break;

        // Mettre à jour le statut d'une offre
        case 'update_statut':
            $id = intval($input['id'] ?? 0);
            $statut = $input['statut'] ?? '';

            if ($id <= 0) {
                throw new Exception('ID invalide');
            }

            if (!in_array($statut, ['brouillon', 'validee', 'active', 'archivee'])) {
                throw new Exception('Statut invalide');
            }

            $stmt = $pdo->prepare("UPDATE offres SET statut = ? WHERE id = ?");
            $stmt->execute([$statut, $id]);

            echo json_encode([
                'success' => true,
                'message' => 'Statut mis à jour'
            ]);
            break;

        // Supprimer une offre
        case 'delete_offre':
            $id = intval($input['id'] ?? 0);
            if ($id <= 0) {
                throw new Exception('ID invalide');
            }

            $stmt = $pdo->prepare("DELETE FROM offres WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode([
                'success' => true,
                'message' => 'Offre supprimée'
            ]);
            break;

        default:
            throw new Exception('Action non reconnue');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
