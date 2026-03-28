<?php
$pageTitle = 'Demande re&ccedil;ue &mdash; Nous v&eacute;rifions votre ville';
$pageDescription = 'Votre demande de v&eacute;rification de disponibilit&eacute; a bien &eacute;t&eacute; re&ccedil;ue.';
$currentPage = 'villes';

session_start();

$prenom = $_SESSION['demande_ville']['prenom'] ?? 'vous';
$ville = $_SESSION['demande_ville']['ville'] ?? 'votre ville';
$email = $_SESSION['demande_ville']['email'] ?? '';
unset($_SESSION['demande_ville']);

include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
@keyframes checkPop { 0%{transform:scale(0)} 70%{transform:scale(1.15)} 100%{transform:scale(1)} }
</style>

<section style="padding:100px 0; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); text-align:center; min-height:60vh; display:flex; align-items:center;">
 <div class="container" style="animation:fadeUp 0.6s ease both;">

 <!-- Ic&ocirc;ne check -->
 <div style="width:80px;height:80px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 28px;animation:checkPop 0.5s ease 0.2s both;">
 <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
 <polyline points="20 6 9 17 4 12"/>
 </svg>
 </div>

 <div style="color:white; max-width:620px; margin:0 auto;">
 <h1 style="font-size:2.4rem; font-weight:800; color:white; margin-bottom:16px; line-height:1.25;">
 Demande re&ccedil;ue, <?= h($prenom) ?>&nbsp;!
 </h1>
 <p style="font-size:1.15rem; opacity:0.95; line-height:1.75; margin-bottom:40px;">
 Nous avons bien enregistr&eacute; votre demande pour <strong><?= h($ville) ?></strong>.<br>
 Prochaine &eacute;tape : r&eacute;servez votre appel d&eacute;couverte pour finaliser votre qualification.<br>
 <strong>Redirection automatique dans quelques secondes.</strong>
 </p>

 <!-- &Eacute;tapes -->
 <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:16px; margin-bottom:40px;">
 <?php
 $steps = [
 ['1', 'Validation', 'Votre demande est enregistr&eacute;e et votre zone est analys&eacute;e'],
 ['2', 'Appel d&eacute;couverte', 'Vous choisissez un cr&eacute;neau de 20 min'],
 ['3', 'Plan d&eacute;ploiement', 'Nous cadrons la meilleure option pour votre secteur'],
 ];
 foreach ($steps as $s):
 ?>
 <div style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:12px;padding:20px 16px;">
 <div style="width:32px;height:32px;background:rgba(255,255,255,0.25);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;color:white;margin:0 auto 10px;"><?= $s[0] ?></div>
 <strong style="color:white;display:block;margin-bottom:6px;font-size:0.9rem;"><?= $s[1] ?></strong>
 <p style="color:rgba(255,255,255,0.8);margin:0;font-size:0.82rem;line-height:1.5;"><?= $s[2] ?></p>
 </div>
 <?php endforeach; ?>
 </div>

 <?php
 $rdvLink = '/front/pages/rdv.php?ville=' . urlencode($ville);
 if ($email !== '') {
 $rdvLink .= '&email=' . urlencode($email);
 }
 ?>
 <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
 <a href="<?= h($rdvLink) ?>" style="background:white;color:#667eea;font-weight:700;font-size:0.97rem;padding:13px 28px;border-radius:11px;text-decoration:none;display:inline-flex;align-items:center;gap:7px;box-shadow:0 6px 20px rgba(0,0,0,0.15);">
 R&eacute;server mon appel d&eacute;couverte
 </a>
 <a href="/" style="background:transparent;border:2px solid rgba(255,255,255,0.8);color:white;font-weight:600;font-size:0.97rem;padding:11px 26px;border-radius:11px;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
 Retour &agrave; l'accueil
 </a>
 </div>
 <p style="margin-top:14px;font-size:0.85rem;opacity:0.78;">Si vous n'&ecirc;tes pas redirig&eacute;, utilisez le bouton principal.</p>
 </div>

 </div>
</section>

<script>
setTimeout(function () {
 window.location.href = <?= json_encode($rdvLink, JSON_UNESCAPED_SLASHES) ?>;
}, 7000);
</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
