<?php
/**
 * ÉCOSYSTÈME IMMO+ - API AI Email Generator
 * Proxy sécurisé pour appeler l'API Anthropic
 */

error_reporting(E_ALL);
ini_set('display_errors', 0);

// Headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://ecosystemeimmo.fr');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../config/database.php';

// Authentification (token API ou session admin) et rate limiting
checkRateLimit();
requireApiAuthOrAdmin();

// Vérifier méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données JSON
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['action'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Données invalides']);
    exit;
}

$action = $input['action'];

// =====================================================
// FONCTIONS AI
// =====================================================

function callAnthropicAPI($systemPrompt, $userPrompt, $maxTokens = 2000) {
    $apiKey = defined('ANTHROPIC_API_KEY') ? ANTHROPIC_API_KEY : '';
    $model = defined('ANTHROPIC_MODEL') ? ANTHROPIC_MODEL : 'claude-sonnet-4-20250514';
    
    if (empty($apiKey)) {
        throw new Exception('Clé API Anthropic non configurée');
    }
    
    $data = [
        'model' => $model,
        'max_tokens' => $maxTokens,
        'system' => $systemPrompt,
        'messages' => [
            ['role' => 'user', 'content' => $userPrompt]
        ]
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
        CURLOPT_TIMEOUT => 60
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
// TRAITEMENT DES ACTIONS
// =====================================================

try {
    switch ($action) {
        
        // Générer un email complet
        case 'generate_email':
            $prompt = trim($input['prompt'] ?? '');
            $sequenceType = trim($input['sequence_type'] ?? 'ressource');
            $stepNumber = intval($input['step_number'] ?? 1);
            
            if (empty($prompt)) {
                throw new Exception('Le prompt est requis');
            }
            
            $systemPrompt = "Tu es un expert en email marketing pour l'immobilier en France. 
Tu rédiges des emails professionnels, engageants et persuasifs pour des conseillers immobiliers indépendants.

Règles importantes :
- Utilise un ton professionnel mais chaleureux
- Les emails doivent être concis (150-300 mots max)
- Utilise les variables disponibles : {{firstname}}, {{email}}, {{resource}}, {{city}}
- Structure : accroche, valeur, call-to-action
- Écris en HTML simple (balises <p>, <strong>, <em>, <ul>, <li>)
- Ne mets PAS de balise <html>, <head>, <body> - juste le contenu
- Adapte le ton selon le type de séquence et l'étape

Types de séquences :
- ressource : Lead a téléchargé une ressource gratuite
- offre : Lead a téléchargé l'offre commerciale
- demo : Lead a demandé une démo
- newsletter : Inscription newsletter
- contact : Demande de contact

L'email doit correspondre à l'étape {$stepNumber} de la séquence.";

            $userPrompt = "Génère un email pour une séquence de type '{$sequenceType}', étape {$stepNumber}.

Contexte/Instructions : {$prompt}

Réponds UNIQUEMENT avec le contenu HTML de l'email (sans objet, sans explications).";

            $emailContent = callAnthropicAPI($systemPrompt, $userPrompt, 1500);
            
            echo json_encode([
                'success' => true,
                'content' => $emailContent
            ]);
            break;
        
        // Générer des suggestions de sujets
        case 'suggest_subjects':
            $context = trim($input['context'] ?? '');
            $sequenceType = trim($input['sequence_type'] ?? 'ressource');
            $emailContent = trim($input['email_content'] ?? '');
            
            $systemPrompt = "Tu es un expert en email marketing. Tu génères des objets d'emails accrocheurs et efficaces.

Règles :
- Objets courts (50 caractères max idéalement)
- Créer de la curiosité ou de l'urgence
- Personnalisation avec {{firstname}} si pertinent
- Éviter les mots spam (gratuit, urgent, etc.)
- Adapter au contexte immobilier français";

            $userPrompt = "Génère 5 suggestions d'objets d'email pour :
- Type de séquence : {$sequenceType}
- Contexte : " . ($context ?: 'Pas de contexte spécifique') . "
- Contenu de l'email : " . (substr(strip_tags($emailContent), 0, 500) ?: 'Non fourni') . "

Réponds UNIQUEMENT avec une liste JSON de 5 objets, format :
[\"Objet 1\", \"Objet 2\", \"Objet 3\", \"Objet 4\", \"Objet 5\"]";

            $suggestions = callAnthropicAPI($systemPrompt, $userPrompt, 500);
            
            // Parser le JSON
            $suggestionsArray = json_decode($suggestions, true);
            if (!is_array($suggestionsArray)) {
                // Essayer d'extraire les suggestions du texte
                preg_match_all('/"([^"]+)"/', $suggestions, $matches);
                $suggestionsArray = $matches[1] ?? ['Suggestion indisponible'];
            }
            
            echo json_encode([
                'success' => true,
                'subjects' => array_slice($suggestionsArray, 0, 5)
            ]);
            break;
        
        // Améliorer un email existant
        case 'improve_email':
            $content = trim($input['content'] ?? '');
            $instruction = trim($input['instruction'] ?? 'Améliore cet email');
            
            if (empty($content)) {
                throw new Exception('Le contenu est requis');
            }
            
            $systemPrompt = "Tu es un expert en copywriting email. Tu améliores les emails existants tout en gardant leur structure.

Règles :
- Conserve les variables {{firstname}}, {{email}}, etc.
- Garde le HTML simple
- Améliore la clarté, l'engagement et la persuasion
- Ne change pas radicalement le message, améliore-le";

            $userPrompt = "Améliore cet email selon cette instruction : {$instruction}

Email actuel :
{$content}

Réponds UNIQUEMENT avec le contenu HTML amélioré.";

            $improvedContent = callAnthropicAPI($systemPrompt, $userPrompt, 1500);
            
            echo json_encode([
                'success' => true,
                'content' => $improvedContent
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