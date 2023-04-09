const AppConfig = {
    alertsEnabled: true
};

$(function () {
    readAppConfig();
    updateRequestCounter();
    initTooltips();
    initGlobalAlertToggleSwitch();

    setInterval(updateRequestCounter, 1000 * 10);
});

function initGlobalAlertToggleSwitch() {
    let alertSwitch = $('a#alert-switch');

    let updateState = (newValue) => {
        let offIcon = $('#alerts-off-icon', alertSwitch);
        let onIcon = $('#alerts-on-icon', alertSwitch);

        changeAppConfig('alertsEnabled', newValue);

        if (newValue) {
            offIcon.addClass('d-none');
            onIcon.removeClass('d-none');

            alertSwitch.addClass('text-success');
        } else {
            offIcon.removeClass('d-none');
            onIcon.addClass('d-none');

            alertSwitch.removeClass('text-success');
        }
    }

    alertSwitch.click(() => updateState(!AppConfig.alertsEnabled));
    updateState(AppConfig.alertsEnabled);
}

function readAppConfig() {
    for (const setting in AppConfig) {
        let savedValue = window.localStorage.getItem(setting);

        if (savedValue === null) {
            continue;
        }

        if (typeof AppConfig[setting] === 'boolean') {
            AppConfig[setting] = savedValue === 'true';
        } else {
            AppConfig[setting] = savedValue;
        }

    }

    return AppConfig;
}

function changeAppConfig(setting, value) {
    AppConfig[setting] = value;

    saveAppConfig();
}

function saveAppConfig() {
    for (const setting in AppConfig) {
        window.localStorage.setItem(setting, AppConfig[setting]);
    }
}

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
