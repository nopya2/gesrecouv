import ApiTokenService from './api_token'

class PaiementService{

    constructor(){
    }

    static getPaiements(parameters){

        let page_url = '/api/paiements?api_token='+ApiTokenService.getToken()+'&'+parameters

        return fetch(page_url);
    }

    static getPaiement(){

    }

    static createPaiement(formData){
        return fetch('/api/paiements?api_token='+ApiTokenService.getToken(), {
            method: 'post',
            body: formData
        });
    }

    static updatePaiement(){

    }

    static deletePaiement(){

    }
}

export default PaiementService;
