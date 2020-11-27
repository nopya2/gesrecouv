import ApiTokenService from './api_token'

class TypeService{

    constructor(){
    }

    static getTypes(){

        let page_url = '/api/types-facture?api_token='+ApiTokenService.getToken()

        return fetch(page_url);
    }

    static getType(){

    }

    static createType(type){
        return fetch('/api/types-facture?api_token='+ApiTokenService.getToken(), {
            method: 'post',
            body: JSON.stringify(type),
            headers: {
                'content-type': 'application/json'
            }
        });
    }

    static updateType(type){
        return fetch('/api/types-facture?api_token='+ApiTokenService.getToken(), {
            method: 'put',
            body: JSON.stringify(type),
            headers: {
                'content-type': 'application/json'
            }
        });
    }

    static deleteType(id){
        return fetch('/api/types-facture/'+id+'?api_token='+ApiTokenService.getToken(), { method: 'delete' })
    }
}

export default TypeService;
