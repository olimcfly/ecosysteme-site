// BURGER MENU
document.addEventListener('DOMContentLoaded', function () {
    // Le header principal gère déjà #navMobile en inline.
    // On évite de doubler les handlers (comportement instable mobile).
    if (document.getElementById('navMobile')) return;

    const toggle = document.querySelector('.nav-toggle');
    const menu   = document.querySelector('.nav-menu');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', function () {
        menu.classList.toggle('active');
        toggle.classList.toggle('active');
    });

    // Fermer en cliquant sur un lien
    document.querySelectorAll('.nav-link, .nav-cta').forEach(function (link) {
        link.addEventListener('click', function () {
            menu.classList.remove('active');
            toggle.classList.remove('active');
        });
    });

    // Fermer en cliquant en dehors
    document.addEventListener('click', function (e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('active');
            toggle.classList.remove('active');
        }
    });
});
