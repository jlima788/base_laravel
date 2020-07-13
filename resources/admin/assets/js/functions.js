const atualizarIframe = function (div) {
    $(div).find('iframe').on('load', function () {
        $(this).height($(this).contents().height());
        // loaderAjax("body", "modal", true);
    });
}

function alertSuccess(msg, func = undefined) {
    Swal.fire({
        icon: "success",
        title: "Sucesso",
        html: msg
    }).then(function () {
        if (func) {
            func()
        }
    });
}

function alertErrorValidate(msg) {
    var obj = JSON.parse(msg);

    var html = "";
    var rs = "";
    Object.keys(obj).forEach(function (key) {
        rs = obj[key];
        html += `<div>${rs}</div>`;
    });

    alertError(html);
};

function alertError(msg) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        html: msg
    });
};

const frmDelete = function (id) {
    Swal.fire({
        title: "Tem certeza que deseja excluir este registro?",
        text: "Você não poderá desfazer esta operação.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar"
    }).then(function (result) {
        if (result.value) {
            $(id).submit();
        }
    });
};

const getParameterByName = function (param) {
    var match = RegExp('[?&]' + param + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

var executeFormAjax = function (el) {
    const url = $(el).prop('action');
    var id = getParameterByName('iframe');
    $.ajax({
        url: url,
        data: $(el).serializeArray(),
        method: "POST",
        success: function (json) {
            if (id) {
                window.parent.$(`#modal-${id}`).modal('toggle');
                window.parent.alertSuccess(json.msg)
                window.parent.$(`#modal-${id}`).trigger('success', json);
            } else {
                let func = function () {
                };
                if (json.route) {
                    func = function () {
                        window.location = json.route;
                    }
                }
                alertSuccess(json.msg, func)
            }
        },
        error: function (ret) {
            const json = ret.responseJSON;
            if (id) {
                if (json.errors && Object.keys(json.errors).length) {
                    window.parent.alertErrorValidate(JSON.stringify(json.errors))
                } else {
                    window.parent.alertError(json.message)
                }
            } else {
                if (json.errors && Object.keys(json.errors).length) {
                    alertErrorValidate(JSON.stringify(json.errors))
                } else {
                    alertError(json.message)
                }
            }
        }
    });
}

$(function () {
    $(".btn-frm-remove").on("click", function (event) {
        event.preventDefault();
        var id = $(this).attr("href");
        frmDelete(id);
    });

    $('.ajax form, form.ajax').submit(function (e) {
        e.preventDefault();
        executeFormAjax($(this))
    });

    $('#iframe').on("submit", "form", function (e) {
        e.preventDefault();
        executeFormAjax($(this))
    });
});
