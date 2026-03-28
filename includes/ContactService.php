<?php
/**
 * ÉCOSYSTÈME IMMO LOCAL+ - ContactService
 * Centralise la logique métier des contacts
 */

require_once __DIR__ . '/../config/database.php';

class ContactService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? getDB();
    }

    /**
     * Récupérer une liste paginée de contacts avec filtres
     * @return array{contacts: array, total: int, totalPages: int}
     */
    public function getContacts(array $filters = [], int $page = 1, int $perPage = 100): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $where = [];
        $params = [];

        $search = trim($filters['search'] ?? '');
        $filterStatus = $filters['status'] ?? '';
        $filterType = $filters['type'] ?? '';

        if ($search) {
            $where[] = "(nom LIKE ? OR email LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if ($filterStatus) {
            $where[] = "status = ?";
            $params[] = $filterStatus;
        }

        if ($filterType) {
            $where[] = "type_demande = ?";
            $params[] = $filterType;
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        // Total
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM contact_messages {$whereClause}");
        $stmt->execute($params);
        $total = (int) $stmt->fetch()['total'];
        $totalPages = (int) ceil($total / $perPage);

        // Liste
        $stmt = $this->pdo->prepare("
            SELECT * FROM contact_messages {$whereClause}
            ORDER BY created_at DESC
            LIMIT ? OFFSET ?
        ");

        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value);
        }
        $stmt->bindValue(count($params) + 1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(count($params) + 2, $offset, PDO::PARAM_INT);

        $stmt->execute();
        $contacts = $stmt->fetchAll();

        return [
            'contacts' => $contacts,
            'total' => $total,
            'totalPages' => $totalPages,
        ];
    }

    /**
     * Récupérer un contact par ID
     */
    public function getContactById(int $id): array
    {
        if ($id <= 0) {
            return ['success' => false, 'error' => 'ID invalide'];
        }

        $stmt = $this->pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$contact) {
            return ['success' => false, 'error' => 'Contact non trouvé'];
        }

        return ['success' => true, 'contact' => $contact];
    }

    /**
     * Créer un contact depuis le formulaire public
     */
    public function createContact(array $data): array
    {
        $firstname = trim($data['firstname'] ?? '');
        $lastname = trim($data['lastname'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $city = trim($data['city'] ?? '');
        $intent = trim($data['intent'] ?? 'cold');
        $message = trim($data['message'] ?? '');

        // Validation
        if (empty($firstname)) {
            return ['success' => false, 'message' => 'Prénom requis'];
        }
        if (empty($lastname)) {
            return ['success' => false, 'message' => 'Nom requis'];
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Email invalide'];
        }
        if (strlen($message) < 10) {
            return ['success' => false, 'message' => 'Message trop court (minimum 10 caractères)'];
        }

        // Mapper intent
        $intentMap = [
            'diagnostic' => 'Diagnostic',
            'demo' => 'Démo',
            'ressource' => 'Ressource',
            'outil' => 'Outil',
            'cold' => 'Autre',
        ];
        $type_demande = $intentMap[$intent] ?? 'Autre';

        $stmt = $this->pdo->prepare("
            INSERT INTO contact_messages (nom, email, telephone, ville, type_demande, message, is_read, is_replied, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 0, 0, NOW())
        ");

        $success = $stmt->execute([
            $firstname . ' ' . $lastname,
            $email,
            $phone,
            $city,
            $type_demande,
            $message,
        ]);

        if (!$success) {
            return ['success' => false, 'message' => 'Erreur BD'];
        }

        $contactId = (int) $this->pdo->lastInsertId();

        // Email de confirmation
        $this->sendConfirmationEmail($firstname, $email, $type_demande);

        // Notification admin
        $this->sendAdminNotification($firstname, $lastname, $email, $phone, $city, $type_demande, $message, $contactId);

        return [
            'success' => true,
            'message' => 'Votre demande a été envoyée',
            'contact_id' => $contactId,
            'redirect_url' => '/contacts/merci?email=' . urlencode($email) . '&intent=' . urlencode($intent),
        ];
    }

    /**
     * Créer un contact via admin (avec champ status)
     */
    public function createContactAdmin(array $data): array
    {
        $firstname = trim($data['firstname'] ?? '');
        $lastname = trim($data['lastname'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $city = trim($data['city'] ?? '');
        $intent = trim($data['intent'] ?? 'cold');
        $message = trim($data['message'] ?? '');

        if (!$firstname || !$lastname || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires'];
        }

        if (strlen($firstname) < 2 || strlen($firstname) > 50) {
            return ['success' => false, 'message' => 'Prénom invalide'];
        }

        if (strlen($message) < 10) {
            return ['success' => false, 'message' => 'Message trop court'];
        }

        $intentMap = [
            'diagnostic' => 'Diagnostic',
            'demo' => 'Démo',
            'ressource' => 'Ressource',
            'outil' => 'Outil',
            'cold' => 'Autre',
        ];
        $type_demande = $intentMap[$intent] ?? 'Autre';

        $stmt = $this->pdo->prepare("
            INSERT INTO contact_messages (nom, email, telephone, ville, type_demande, message, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())
        ");

        $stmt->execute([
            $firstname . ' ' . $lastname,
            $email,
            $phone,
            $city,
            $type_demande,
            $message,
        ]);

        $contactId = (int) $this->pdo->lastInsertId();

        // Email de confirmation
        $this->sendConfirmationEmail($firstname, $email, $type_demande);

        // Notification admin
        $this->sendAdminNotification($firstname, $lastname, $email, $phone, $city, $type_demande, $message, $contactId);

        return [
            'success' => true,
            'message' => 'Votre demande a été envoyée avec succès',
            'contact_id' => $contactId,
            'redirect_url' => '/contacts/thank-you?email=' . urlencode($email) . '&intent=' . urlencode($intent),
        ];
    }

    /**
     * Mettre à jour le statut d'un contact
     */
    public function updateContactStatus(int $id, string $status): array
    {
        if ($id <= 0) {
            return ['success' => false, 'error' => 'ID invalide'];
        }

        $allowedStatuses = ['pending', 'replied', 'closed', 'spam'];
        if (!in_array($status, $allowedStatuses)) {
            return ['success' => false, 'error' => 'Statut invalide'];
        }

        $isReplied = ($status === 'replied') ? 1 : 0;

        $stmt = $this->pdo->prepare("
            UPDATE contact_messages SET status = ?, is_replied = ? WHERE id = ?
        ");
        $stmt->execute([$status, $isReplied, $id]);

        if ($stmt->rowCount() === 0) {
            return ['success' => false, 'error' => 'Contact non trouvé ou aucune modification'];
        }

        return ['success' => true, 'message' => 'Statut mis à jour'];
    }

    /**
     * Statistiques des contacts
     */
    public function getContactStats(): array
    {
        $total = (int) $this->pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
        $pending = (int) $this->pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'pending'")->fetchColumn();
        $replied = (int) $this->pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_replied = 1")->fetchColumn();

        return [
            'total' => $total,
            'pending' => $pending,
            'replied' => $replied,
        ];
    }

    /**
     * Vérifier si un email existe déjà
     */
    public function checkEmailExists(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $stmt = $this->pdo->prepare("SELECT id FROM contact_messages WHERE email = ?");
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    // ============================================
    // MÉTHODES PRIVÉES
    // ============================================

    private function sendConfirmationEmail(string $firstname, string $email, string $type_demande): void
    {
        $subject = 'Merci pour votre demande - ÉCOSYSTÈME IMMO LOCAL+';
        $body = "Bonjour {$firstname},\n\n";
        $body .= "Merci d'avoir pris contact avec ÉCOSYSTÈME IMMO LOCAL+.\n\n";
        $body .= "Nous avons bien reçu votre demande concernant : {$type_demande}\n\n";
        $body .= "Notre équipe étudiera votre dossier et vous recontactera dans les 24 heures.\n\n";
        $body .= "À bientôt,\n";
        $body .= "L'équipe ÉCOSYSTÈME IMMO LOCAL+";

        $from_email = defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : 'admin@ecosystemeimmo.fr';
        $headers = "From: {$from_email}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        @mail($email, $subject, $body, $headers);
    }

    private function sendAdminNotification(
        string $firstname,
        string $lastname,
        string $email,
        string $phone,
        string $city,
        string $type_demande,
        string $message,
        int $contactId
    ): void {
        $admin_email = defined('ADMIN_EMAIL') ? ADMIN_EMAIL : 'admin@ecosystemeimmo.fr';
        $admin_subject = "Nouvelle demande - {$firstname} {$lastname}";
        $admin_body = "Nouvelle demande de contact:\n\n";
        $admin_body .= "Nom: {$firstname} {$lastname}\n";
        $admin_body .= "Email: {$email}\n";
        $admin_body .= "Téléphone: {$phone}\n";
        $admin_body .= "Ville: {$city}\n";
        $admin_body .= "Type: {$type_demande}\n\n";
        $admin_body .= "Message:\n{$message}\n\n";
        $admin_body .= "Voir dans admin: /admin/contacts/?id={$contactId}";

        $from_email = defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : 'admin@ecosystemeimmo.fr';
        $headers = "From: {$from_email}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        @mail($admin_email, $admin_subject, $admin_body, $headers);
    }
}
