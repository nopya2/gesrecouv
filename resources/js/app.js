require('./bootstrap');

window.Vue = require('vue');
import Vuelidate from 'vuelidate';
import VueContext from 'vue-context';
import Swatches from 'vue-swatches';
import VueFilterDateFormat from 'vue-filter-date-format';
import numeral from 'numeral';
import numFormat from 'vue-filter-number-format';
import { VuejsDatatableFactory } from 'vuejs-datatable';
// import JsonExcel from 'vue-json-excel'
import VueTruncate from 'vue-truncate-filter'
import axios from 'axios'
import VueAxios from 'vue-axios'
window.axios = require('axios');
import vSelect from 'vue-select'
import VModal from 'vue-js-modal/dist/index.nocss.js'

Vue.use(Vuelidate);
//vee validate
import { ValidationProvider,ValidationObserver } from 'vee-validate';
Vue.component('ValidationProvider', ValidationProvider);

Vue.use(VueContext);
Vue.use(Swatches);
Vue.use(VueFilterDateFormat);
Vue.config.productionTip = false;
// load a locale
numeral.register('locale', 'fr', {
    delimiters: {
        thousands: ' ',
        decimal: ','
    },
    abbreviations: {
        thousand: 'k',
        million: 'm',
        billion: 'b',
        trillion: 't'
    },
    ordinal : function (number) {
        return number === 1 ? 'er' : 'ème';
    },
    currency: {
        symbol: 'XAF'
    }
});
// switch between locales
numeral.locale('fr');
Vue.filter('numFormat', numFormat(numeral));
Vue.use( VuejsDatatableFactory );
Vue.use(VueTruncate);
Vue.use(require('vue-moment'));
Vue.use(VueAxios, axios)
Vue.component('v-select', vSelect)

import  'vue-context/dist/css/vue-context.css';
import "vue-swatches/dist/vue-swatches.min.css"

require('./components/users/users');
require('./components/engagements/engagements');
require('./components/echelons/echelons');
require('./components/dashboard/dashboard');
require('./components/providers/providers');
require('./components/groups/groups');
require('./components/statistics/statistics');
require('./components/chapitres/chapitres');
require('./components/bordereau/bordereau');
require('./components/documents/documents');
require('./components/clients/clients');
require('./components/factures/factures')
require('./components/passport/passport');
require('./components/types/types');
require('./components/modes-paiement/mode-paiement');
require('./components/modules/modules');
require('./components/secteur-activite/secteur-activite');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('vue-context', require('vue-context').default);
Vue.component('swatches', require('vue-swatches').default);
// Vue.component('downloadExcel', JsonExcel)

function updateFunction (el, binding) {
    // get options from binding value.
    // v-select="THIS-IS-THE-BINDING-VALUE"
    let options = binding.value || {};

    // set up select2
    $(el).select2(options).on("select2:select", (e) => {
        // v-model looks for
        //  - an event named "change"
        //  - a value with property path "$event.target.value"
        el.dispatchEvent(new Event('change', { target: e.target }));
    });
}
Vue.directive('select', {
    inserted: updateFunction ,
    componentUpdated: updateFunction,
});


const app = new Vue({
    components: {
        VueContext,
        Swatches
    },
    el: '#app',
});

// const login = new Vue({
//     el: '#login-page'
// });

// const header = new Vue({
//     el: '#header'
// })
