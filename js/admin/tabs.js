document.addEventListener('DOMContentLoaded', () => {
    const tabLinks = document.querySelectorAll('.tab-link');
    const sections = document.querySelectorAll('.section');

    const activateTab = (link) => {
        tabLinks.forEach(l => l.classList.remove('active'));
        sections.forEach(section => section.classList.remove('active'));

        link.classList.add('active');
        document.querySelector(link.getAttribute('href')).classList.add('active');
    };

    tabLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            activateTab(link);
            history.pushState(null, null, link.getAttribute('href'));
        });
    });

    const hash = window.location.hash;
    if (hash) {
        const activeLink = document.querySelector(`.tab-link[href="${hash}"]`);
        if (activeLink) {
            activateTab(activeLink);
        }
    } else if (tabLinks.length > 0) {
        activateTab(tabLinks[0]);
    }
});
