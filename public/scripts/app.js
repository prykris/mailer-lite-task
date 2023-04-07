$(function () {
    updateRequestCounter();
    initTooltips();

    setInterval(updateRequestCounter, 1000 * 10);
})

function updateRequestCounter() {
    fetch('/api-key/requests')
        .then((response) => response.json())
        .then(response => {
            document.querySelector('#request-counter').innerHTML = response.count;
        });
}

function initTooltips() {
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        .map(
            (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
        );
}
