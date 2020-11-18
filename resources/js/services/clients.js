import ApiTokenService from './api_token'

class ClientService{

    constructor(){
    }

    static getClients(parameters){

        let page_url = '/api/clients?api_token='+ApiTokenService.getToken()+'&'+parameters

        return fetch(page_url);
    }

    static getClient(){

    }

    static createClient(){

    }

    static updateClient(){

    }

    static deleteClient(){

    }
}

export default ClientService;
