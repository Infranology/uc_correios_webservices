$(document).ready(function() {
    contract         = $('#edit-uc-correios-webservices-contract');
    contract_value   = contract.val();
    without_contract = $('#edit-uc-correios-webservices-username-wrapper, #edit-uc-correios-webservices-password-wrapper, #edit-uc-correios-webservices-password-wrapper + div');
    with_contract    = $('#edit-uc-correios-webservices-contract-wrapper + div');
    
    if (contract_value == 1) {
        without_contract.show();
        with_contract.hide();
    }
    
    contract.change(function(){
        var key = $(this).val();
        
        if (key == 0) {
            without_contract.hide();
            with_contract.show();
        }
        
        if (key == 1) {
            without_contract.show();
            with_contract.hide();
        }
    });
});