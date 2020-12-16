import VueCookies from 'vue-cookies'
Vue.use(VueCookies)


class Configuration{
    constructor(){
    }

    static getCNF(){
        return $cookies.get('CNF')
    }

}

export default Configuration;
