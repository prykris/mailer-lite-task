let table;
let alertContainer;

let currentCursor, previousCursor, nextCursor, firstCursor, lastCursor;

$(function () {
    table = initSubscriberTable();
    initSubscriberCreationForm();
    initSubscriberEditForm();
    initCountryPicker('select.countrypicker');
    initCountryPicker($('#subscriber-edit-modal select.countrypicker'));

    alertContainer = $('#alert-container');
});

function alert(type, message) {
    if (AppConfig.alertsEnabled === false) {
        console.log(`alert-${type}: ${message}`);
        return;
    }

    alertContainer.append($(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `));
}

function initCountryPicker(selector, selectedValue) {
    let selectElement = $(selector);
    // Populate selection with countries
    countryList.forEach((country) => {
        selectElement.append(
            `<option value="${country}">${country}</option>`
        );
    });

    if (selectedValue) {
        selectElement.val(selectedValue);
    }

    selectElement.selectpicker();
}

function initSubscriberCreationForm() {
    $('form#create-subscriber-form').submit(function (e) {
        e.preventDefault();

        clearFormErrors(this);

        let data = extractFormData(this);

        $.ajax(this.action, {
            type: 'POST',
            data,
            success: () => {
                table.ajax.reload(null, false);
                $('input[type="email"]', this).val('');

                let countrypicker = $('select', this);

                countrypicker.val('');
                countrypicker.selectpicker('refresh');

                alert('success', `Email address ${data.email} has been added to subscribers list`);
            },
            error: (response) => displayFormErrors(response.responseJSON.errors, this)
        });

        updateRequestCounter();
    })
}

function extractFormData(form) {
    return $(form).serializeArray().reduce(function (obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
}

function initSubscriberTable() {
    return $('table#subscribers-table').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        ajax: {
            url: '/subscribers/data',
            dataSrc: readTableData,
            data: function (data) {
                data.cursor = currentCursor;

                currentCursor = null;
            }
        },
        columns: [
            {
                data: 'email',
                render: (email) =>
                    `<a href='#' onclick="showEditForm(table.row($(this).parents('tr')).data())" class="link-dark">
                        ${email}
                    </a>`
            },
            {
                data: 'name',
            },
            {
                data: 'country'
            },
            {
                data: 'subscribed_at',
                render: (date) => date.format('YYYY/MM/DD')
            },
            {
                data: 'subscribed_at',
                render: (date) => date.format('HH:MM')
            },
            {
                data: 'id',
                render: (id) =>
                    `<div class="d-flex justify-content-center">
                                <button class="btn btn-danger" onclick="deleteSubscriber('${id}', table)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>
                                </button>
                            </div>`,
            }
        ],
        columnDefs: [
            {
                targets: '_all',
                sortable: false
            }
        ],
        pagingType: "simple",
        drawCallback: function () {
            const api = this.api();
            const tableWrapper = $(this).closest('.dataTables_wrapper');
            const nextButton = tableWrapper.find('.paginate_button.next');
            const prevButton = tableWrapper.find('.paginate_button.previous');

            nextButton.off('click').on('click', function () {
                currentCursor = nextCursor;

                api.ajax.reload();
            });

            prevButton.off('click').on('click', function () {
                currentCursor = previousCursor; // Update the current cursor value

                api.ajax.reload();
            });

            nextButton.toggleClass('disabled', !nextCursor);
            prevButton.toggleClass('disabled', !previousCursor);
        }
    });
}

/**
 * Perform modifications on parameter. Table rows are located under "data" key
 *
 * @param response Object response from the api
 */
function readTableData(response) {
    updateRequestCounter();

    nextCursor = response.meta.next_cursor;
    previousCursor = response.meta.prev_cursor;

    return Object.values(response.data).map(prepareRow);
}

/**
 * This is final row structure. Property names can be used to refer columns in columnDefinition option.
 */
function prepareRow(row) {
    return {
        id: row.id,
        email: row.email,
        name: row['fields']['name'],
        country: row['fields']['country'],
        subscribed_at: moment(row['subscribed_at'])
    };
}

function deleteSubscriber(id, table) {
    $.ajax('/subscribers/delete', {
        type: 'DELETE',
        data: {
            id
        },
        success: function (_, message) {
            if (message !== 'success') {
                // TODO: Display alert
                return;
            }

            table.ajax.reload(null, false);

            alert('success', 'Subscriber removed from your email list')
        }
    });
    updateRequestCounter();
}

function showEditForm(row) {
    let modal = $('#subscriber-edit-modal.modal');
    let form = $('form', modal);
    let countryPicker = $('select.countrypicker', form);

    $('input[name=id][type=hidden]').val(row['id']);
    $('input[name=name][type=text]').val(row['name']);

    countryPicker.val(row['country']);
    countryPicker.selectpicker('refresh');

    modal.modal('show');
}

function initSubscriberEditForm() {
    let modal = $('#subscriber-edit-modal.modal');

    $('form#subscriber-edit-form').submit(function (e) {
        e.preventDefault();

        clearFormErrors(this);

        let data = extractFormData(this);

        $.ajax('subscribers/update', {
            type: 'PUT',
            data,

            success: function () {
                table.ajax.reload(null, false);

                modal.modal('hide');
            },
            error: (response) => displayFormErrors(response.responseJSON.errors, this)
        })
    });
}

function displayFormErrors(errors, form) {
    for (const inputName in errors) {
        let inputErrors = errors[inputName];
        let inputElement = $(`input[name="${inputName}"], select[name=${inputName}]`, form);

        console.log(inputErrors);

        // Display error messages
        for (let i = 0; i < inputErrors.length; i++) {
            let message = inputErrors[i];

            let errorTextElement = $(`<small class="form-error-message form-text text-danger">${message}</small>`);

            if (inputElement.is('select')) {
                errorTextElement.insertAfter(inputElement.siblings('button'));
            } else {
                errorTextElement.insertAfter(inputElement)
            }
        }

        // Add red border
        if (inputElement.is('select')) {
            inputElement.siblings('button').addClass('border-danger');
        } else {
            inputElement.addClass('border-danger');
        }
    }
}

function clearFormErrors(form) {
    $('small.form-error-message', form).remove();
    $('input, select').removeClass('border-danger');
    $('select + button', form).removeClass('border-danger');
}
