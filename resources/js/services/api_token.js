class ApiTokenService{
    constructor(){

    }

    static getToken(){
        if (window.localStorage.getItem('authUser')) {
            const authUser = JSON.parse(window.localStorage.getItem('authUser'))
            return authUser.api_token
        }else{
            return null
        }
    }


}

export default ApiTokenService;
