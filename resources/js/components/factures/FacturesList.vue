<template>
    <div class="card-block table-border-style">
        <div class="row">
            <div class="col-md-6">
                <a v-bind:href="'/factures/create'">
                    <button class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Créer une facture
                    </button>
                </a>
                <button class="btn btn-secondary btn-sm">
                    <i class="fas fa-print"></i> Imprimer
                </button>
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Exporter excel
                </button>
            </div>
            <div class="col-md-4 offset-md-2">
                <!-- <input type="text" class="form-control form-control-sm" 
                    placeholder="Tapez votre recherche, raison sociale ou NIF" 
                    v-model="filter.keyword" v-on:keyup="search"> -->
                

                <div class="input-group input-group-sm">
                    <input type="text" class="form-control mr-1" placeholder="Tapez le n° de la facture"
                        v-model="filter.keyword" v-on:keyup="search">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-dark btn-flat mr-1"
                            @click="openFilter"
                            v-if="!hasFilter(filter)"
                            data-toggle="tooltip" data-placement="bottom" title="Filtrer">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-info btn-flat mr-1"
                            @click="openFilter"
                            v-if="hasFilter(filter)"
                            data-toggle="tooltip" data-placement="bottom" title="Filtrer">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-flat" @click="resetFilter"
                            data-toggle="tooltip" data-placement="bottom" title="Annuler les filtres">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                </div>

            </div>
        </div>

        <div class="table-border-style mt-3">
            <div class="d-flex justify-content-center mb-3" v-if="spinner">
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered projects table-striped" id="example1">
                    <thead>
                    <tr class="text-center">
                        <th></th>
                        <th style="width: 255px">Facture no.</th>
                        <th>Facture initiale</th>
                        <th>Client</th>
                        <th>Type</th>
                        <th>Paiement attendu</th>
                        <th>Réglé</th>
                        <th>Reste à payer</th>
                        <th>Dates</th>
                        <!-- <th>Documents</th> -->
                        <th>Statut</th>
                    </tr>
                    </thead>
                    <tbody style="font-size: 14px">
                    <tr>
                        <td colspan="9" v-if="factures.length <= 0">
                            Aucune facture trouvée
                        </td>
                    </tr>
                    <tr v-for="facture in factures" :key="facture.id">
                        <td class="vertical-align">
                            <div class="dropdown text-center">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item text-info text-sm" :href="'/factures/'+facture.id">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </a>
                                    <a class="dropdown-item text-secondary text-sm" href="javascript:void(0);" >
                                        <i class="fas fa-print mr-1"></i> Imprimer
                                    </a>
                                    <a class="dropdown-item text-success text-sm" href="javascript:void(0);" 
                                        v-if="facture.state == 'waiting'"
                                        @click="validate(facture)">
                                        <i class="fas fa-check mr-1"></i> Valider
                                    </a>
                                    <a class="dropdown-item text-warning text-sm"
                                        :href="`/factures/${facture.id}/edit`"
                                        v-if="facture.state == 'waiting' && facture.statut == 'in_progress' && facture.m_paid==0">
                                        <i class="fas fa-edit mr-1"></i> Modifier
                                    </a>
                                    <a class="dropdown-item text-indigo text-sm" href="javascript:void(0);" 
                                        v-if="facture.state == 'validated' && facture.statut != 'litigation' && facture.statut != 'credit_note' && facture.statut != 'paid'"
                                        @click="litigate(facture)">
                                        <i class="fas fa-exclamation mr-1"></i> Litige
                                    </a>
                                    <a class="dropdown-item text-sm" href="javascript:void(0);" 
                                        v-if="facture.state == 'validated' && facture.statut != 'credit_note' && facture.statut != 'paid'"
                                        @click="transformToCreditNote(facture)">
                                        <i class="fas fa-exchange-alt mr-1"></i> Convertir en avoir
                                    </a>
                                    <div class="dropdown-divider" v-if="facture.m_paid <= 0 && facture.statut != 'credit_note'"></div>
                                    <a class="dropdown-item text-gray-dark text-sm" href="javascript:void(0);" 
                                        v-if="facture.state == 'waiting' && facture.statut != 'credit_note'" 
                                        @click="cancel(facture)">
                                        <i class="fas fa-times mr-1"></i> Annuler
                                    </a>
                                    <a class="dropdown-item text-danger text-sm" href="javascript:void(0);"
                                        v-if="facture.m_paid <= 0 && facture.statut != 'credit_note'"
                                        @click="deleteFacture(facture)">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="vertical-align text-center">
                            <!-- <i class="fas fa-check-circle text-success mr-1" v-if="facture.statut=='is_paid'"></i> -->
                            <!-- <i class="fas fa-times-circle text-danger mr-1" 
                                v-if="facture.statut=='cancelled' && facture.state=='cancelled'"></i> -->
                            {{ facture.num_facture }}
                        </td>
                        <td class="vertical-align">
                            <template v-if="facture.parent">
                                {{ facture.parent.num_facture }}
                            </template>
                        </td>
                        <td class="vertical-align">
                            <a :href="'/clients/'+facture.client.id">{{ facture.client.raison_sociale }}</a>
                        </td>
                        <td class="vertical-align">
                            {{ facture.type.libelle }}
                        </td>
                        <td class="vertical-align text-center">
                            <b>{{ facture.montant|numFormat }}</b>
                        </td>
                        <td class="vertical-align text-center">
                            <div class="progress progress-xs">
                                <div :class="'progress-bar '+progressBarColor(percent(facture))" :style="'width: '+percent(facture)+'%'">
                                </div>
                            </div>
                            <b class="text-xs">{{ facture.m_paid|numFormat }}</b>
                        </td>
                        <td class="vertical-align text-center">
                            <b class="text-xs">{{ facture.m_not_paid|numFormat }}</b>
                        </td>
                        <td class="vertical-align">
                            <p v-if="facture.date_creation && !facture.date_paiement" class="p-0 m-0"><b>Facturé le:</b> {{ facture.date_creation | moment("DD/MM/YYYY") }}</p>
                            <p v-if="facture.date_depot && !facture.date_paiement" class="p-0 m-0"><b>Déposé le:</b> {{ facture.date_depot | moment("DD/MM/YYYY") }}</p>
                            <p v-if="!facture.date_paiement && !facture.date_paiement" class="p-0 m-0"><b>Echéance le:</b> {{ facture.date_echeance | moment("DD/MM/YYYY") }}</p>
                            <p v-if="facture.date_paiement" class="p-0 m-0"><b>Payé le:</b> {{ facture.date_paiement | moment("DD/MM/YYYY") }}</p>
                        </td>
                        <!-- <td class="vertical-align"></td> -->
                        <td class="vertical-align text-center">
                            <span class="badge badge-dark" v-if="facture.statut == 'credit_note'">Avoir</span>
                            <span class="badge badge-success" v-if="facture.statut == 'paid'">Payé</span>
                            <span class="badge badge-warning" v-if="facture.state == 'waiting'">A valider</span>
                            <span class="badge badge-info" v-if="facture.statut == 'in_progress' && facture.state != 'waiting'">En cours</span>
                            <span class="badge badge-danger" v-if="facture.statut == 'cancelled'">Annulé</span>
                            <span class="badge badge-danger" v-if="facture.statut == 'litigation'">Litige</span>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="text-center">
                        <th></th>
                        <th style="width: 255px">Facture no.</th>
                        <th>Facture initiale</th>
                        <th>Client</th>
                        <th>Type</th>
                        <th>Paiement attendu</th>
                        <th>Réglé</th>
                        <th>Reste à payer</th>
                        <th>Dates</th>
                        <!-- <th>Documents</th> -->
                        <th>Statut</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row" v-if="factures.length > 0">
                <div class="col-md-6">
                    De {{ pagination.from }} à {{ pagination.to }} sur {{ pagination.total }} Facture(s)
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                                <a class="page-link" href="javascript:" tabindex="-1" @click="fetchFactures(pagination.prev_page_url)">Précédent</a>
                            </li>
                            <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                            <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                            <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                            <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                                <a class="page-link" href="javascript:" @click="fetchFactures(pagination.next_page_url)">Suivant</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-filter">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Filtre</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Type de facture</label>
                                <select class="form-control" v-model="filter.type">
                                    <option value="">Tout</option>
                                    <option v-for="item in types" :key="item.id" :value="item.id">{{item.libelle}}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Statut</label>
                                <select class="form-control" v-model="filter.statut">
                                    <option value="">Tout</option>
                                    <option value="to_validate">A valider</option>
                                    <option value="later">En retard</option>
                                    <option value="cancelled">Annulé</option>
                                    <option value="paid">Payé</option>
                                    <option value="waiting">En attente</option>
                                    <option value="litigation">Litige</option>
                                    <option value="credit_note">Avoir</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Client</label>
                                <v-select :options="clients" label="raison_sociale"
                                    :filterable="false"
                                    v-model="filter.client"
                                    @search="onSearchClients">
                                    <template slot="no-options">
                                        Sélectionnez un client
                                    </template>
                                    <template slot="option" slot-scope="option">
                                        {{ option.raison_sociale }}
                                    </template>
                                    <template slot="selected-option" slot-scope="option">
                                        {{ option.raison_sociale }}
                                    </template>
                                </v-select>
                            </div>
                            <div class="col-md-6">
                                <label>Période</label>
                                <date-picker
                                    v-model="filter.range"
                                    type="date" 
                                    @input="selectRange"
                                    range
                                    placeholder="Select date range"
                                    value-type="format"
                                    format="YYYY-MM-DD"></date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            @click="processFilter"
                            v-if="hasFilter(this.filter)">
                            <i class="fas fa-filter mr-1"></i>Filtrer
                        </button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"
                            @click="processFilter"
                            v-if="!hasFilter(this.filter)">
                            <i class="fas fa-filter mr-1"></i>Filtrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Facture from '../../models/facture'
    import ClientService from './../../services/clients'
    import 'vue-select/dist/vue-select.css';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {

        props : [],
        mounted() {
            $('[data-toggle="tooltip"]').tooltip()
        },

        data(){
            return{
                factures: [],
                filter: {
                    keyword: '',
                    type: '',
                    statut: '',
                    // state: '',
                    client: '',
                    range: [],
                    start: '',
                    end: ''
                },
                types: [],
                clients: [],
                api_token: '',
                pagination: {
                    current_page: 1,
                    total: 0
                },
                spinner: true,

            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token 
            }
            this.fetchFactures()
            this.fetchTypes()

        },

        methods: {
            fetchFactures(page) {
                let vm = this;
                this.spinner = true;
                let client_id = ''
                if(this.filter.client != '' && this.filter.client != null) 
                    client_id = this.filter.client.id
                else
                    client_id = ''
                    
                let url_parameters = `api_token=${this.api_token}&keyword=${this.filter.keyword}&limit=10`
                    +`&client_id=${client_id}&statut=${this.filter.statut}&start=${this.filter.start}&end=${this.filter.end}`
                    +`&type=${this.filter.type}`
                let page_url = `/api/factures?${url_parameters}`
                if(page) page_url = `${page}&${url_parameters}`

                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        vm.spinner = false
                        vm.factures = res.data
                        vm.makePagination(res.meta, res.links)
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinner = false
                    });
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    total: meta.total,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    from: meta.from,
                    to: meta.to
                }

                this.pagination = pagination;
            },
            fetchTypes(){
                let vm = this;

                axios.get('/api/types-facture')
                    .then(response => {
                        vm.types = response.data.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                    });
            },
            fetchClients: _.debounce((loading, search, vm) => {
                let parameters = `keyword=${escape(search)}&limit=15`

                ClientService.getClients(parameters)
                    .then(res => res.json())
                    .then(res => {
                        loading(false)
                        vm.clients = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des clients!')
                    });
            }, 350),
            onSearchClients(search, loading){
                loading(true);
                this.fetchClients(loading, search, this)
            },
            search(){
                this.fetchFactures();
            },
            deleteFacture(facture){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer cette facture?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.delete(`/api/factures/${facture.id}?`)
                            .then(response => {
                                return response
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        toastr.warning('Suppression terminée!.')
                        vm.fetchFactures();
                    }
                })
            },
            validate(facture){
                let vm = this
                let copy = {...facture}
                this.purge(copy)

                Swal.fire({
                    title: 'Valider la facture',
                    text: 'Etes-vous sur de vouloir valider cette facture?',
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    confirmButtonColor: '#28a745',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.patch("/api/factures/"+copy.id+"/validate", copy)
                            .then(function (response)
                            {
                                return response
                                
                            })
                            .catch(function (error) {
                                Swal.showValidationMessage(
                                    `Erreur validation: ${error.response.data.message}`
                                )
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        let value = result.value.data.data
                        let index = vm.factures.findIndex(x => x.id == value.id)
                        if(index !== -1){
                            vm.factures[index] = value
                            this.$forceUpdate();
                        }
                        
                        vm.factures[index] = {...facture}
                        toastr.success('Facture validée!')
                    }
                })
            },
            cancel(facture){
                let vm = this
                let copy = {...facture}
                this.purge(copy)

                Swal.fire({
                    title: 'Annuler la facture',
                    text: 'Etes-vous sur de vouloir annuler cette facture?',
                    showCancelButton: true,
                    confirmButtonText: 'Annuler',
                    confirmButtonColor: '#dc3545',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.patch("/api/factures/"+copy.id+"/cancel", copy)
                            .then(function (response)
                            {
                            })
                            .catch(function (error) {
                                Swal.showValidationMessage(
                                    `Erreur validation: ${error.response.data.message}`
                                )
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        let value = result.value.data.data
                        let index = vm.factures.findIndex(x => x.id == value.id)
                        if(index !== -1){
                            vm.factures[index] = value
                            this.$forceUpdate();
                        }
                        toastr.warning('Facture annulée!')
                    }
                })
            },
            litigate(facture){
                let vm = this
                let copy = {...facture}
                this.purge(copy)

                Swal.fire({
                    title: 'Modifier le statut',
                    text: 'Etes-vous sur de vouloir modifier le statut de cette facture en litige?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmer',
                    confirmButtonColor: '#dc3545',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.patch("/api/factures/"+copy.id+"/litigate", copy)
                            .then(function (response)
                            {
                                return response
                            })
                            .catch(function (error) {
                                Swal.showValidationMessage(
                                    `Erreur validation: ${error.response.data.message}`
                                )
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        let value = result.value.data.data
                        let index = vm.factures.findIndex(x => x.id == value.id)
                        if(index !== -1){
                            vm.factures[index] = value
                            this.$forceUpdate();
                        }
                        toastr.warning('Statut de la facture modifiée!')
                    }
                })
            },
            transformToCreditNote(facture){
                let vm = this

                Swal.fire({
                    title: 'Facture d\'avoir',
                    text: 'Etes-vous sur de vouloir transformer cette facture en avoir?',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmer',
                    confirmButtonColor: '#dc3545',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.patch("/api/factures/"+facture.id+"/make-credit-note", facture)
                            .then(function (response)
                            {
                                return response
                            })
                            .catch(function (error) {
                                Swal.showValidationMessage(
                                    `Erreur validation: ${error.response.data.message}`
                                )
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        vm.fetchFactures()
                        toastr.success('Facture convertie en avoir!')
                    }
                })
            },
            purge(facture){
                delete facture.client
                delete facture.utilisateur
                delete facture.parent
                delete facture.type
                delete facture.paiements
                delete facture.m_paid
                delete facture.m_not_paid
            },
            percent(facture){
                return (facture.m_paid/facture.montant)*100
            },
            progressBarColor(value){
                if(value>=0 && value < 50) return 'bg-danger'
                if(value>=50 && value < 70) return 'bg-info'
                if(value>=70 && value < 90) return 'bg-warning'
                if(value>=90 && value <= 100) return 'bg-success'
            },
            openFilter(){
                $('#modal-filter').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            processFilter(){
                this.fetchFactures()
            },
            selectRange(e){
                this.filter.start = e[0]
                this.filter.end = e[1]
            },
            hasFilter(){
                if(this.filter.keyword != '') return true
                if(this.filter.type != '') return true
                if(this.filter.statut != '') return true
                if(this.filter.client != '' && this.filter.client != null) return true
                if(this.filter.start != '') return true
                if(this.filter.end != '') return true

                return false
            },
            resetFilter(){
                this.filter = {
                    keyword: '',
                    type: '',
                    statut: '',
                    // state: '',
                    client: '',
                    range: [],
                    start: '',
                    end: ''
                }
                this.search()
            }
        }

    }
</script>

<style scoped>
.vertical-align{
    vertical-align: middle;
}
</style>
