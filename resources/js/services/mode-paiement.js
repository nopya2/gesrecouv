import ApiTokenService from './api_token'

class ModePaiementService{

    constructor(){
    }

    static getModes(parameters, page){

        let page_url = '/api/modes-paiement?api_token='+ApiTokenService.getToken()+'&'+parameters

        return fetch(page_url);
    }

    static getMode(){

    }

    static createMode(mode){
        return fetch('/api/modes-paiement?api_token='+ApiTokenService.getToken(), {
            method: 'post',
            body: JSON.stringify(mode),
            headers: {
                'content-type': 'application/json'
            }
        });
    }

    static updateMode(mode){
        return fetch('/api/modes-paiement?api_token='+ApiTokenService.getToken(), {
            method: 'put',
            body: JSON.stringify(mode),
            headers: {
                'content-type': 'application/json'
            }
        });
    }

    static deleteMode(id){
        return fetch('/api/modes-paiement/'+id+'?api_token='+ApiTokenService.getToken(), { method: 'delete' })
    }
}

export default ModePaiementService;
