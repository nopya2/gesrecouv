import ApiTokenService from './api_token'

class FactureService{

    constructor(){
    }

    static getFactures(parameters){

        let page_url = '/api/factures?api_token='+ApiTokenService.getToken()+'&'+parameters

        return fetch(page_url);
    }

    static getFacture(id){
        return fetch('/api/factures/'+id+'?api_token='+ApiTokenService.getToken())
    }

    static createFacture(facture){
        return fetch('/api/factures?api_token='+ApiTokenService.getToken(), {
            method: 'post',
            body: JSON.stringify(facture),
            headers: {
                'content-type': 'application/json'
            }
        })
    }

    static updateFacture(){

    }

    static deleteFacture(){

    }
}

export default FactureService;
