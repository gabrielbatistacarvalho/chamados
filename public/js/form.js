function validateDataTeste(button)
{
    if (validateForm("#form") === true) {
        if (submited === false) {
            submited = true;
            if ($(button).attr('preloader')) {
                $(button).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            } else {
                $(button).html('Aguarde...');
            }
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
