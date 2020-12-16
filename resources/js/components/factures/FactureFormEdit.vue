<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Formulaire de modification</h3>
                        <div class="card-tools">
                            <button class="btn btn-info btn-sm" title="Détails">
                                <a :href="'/factures/'+facture.id" class="text-light">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="raison_sociale">Client</label>
                                        <v-select :options="options_clients" label="raison_sociale"
                                            :filterable="false"
                                            v-model="facture.client"
                                            @input="setFactureClient"
                                            @search="onSearchClients">
                                            <template slot="no-options">
                                                Sélectionnez un client
                                            </template>
                                            <!-- <template #option="{ raison_sociale }">
                                                {{ raison_sociale }}
                                            </template> -->
                                            <template slot="option" slot-scope="option">
                                                {{ option.raison_sociale }}
                                            </template>
                                            <template slot="selected-option" slot-scope="option">
                                                {{ option.raison_sociale }}
                                            </template>
                                        </v-select>
                                        <small class="form-text text-danger" v-if="!$v.facture.client.required">Champs requis.</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="raison_sociale">Facture parent</label>
                                        <v-select :options="options_factures" label="num_facture"
                                            :filterable="false"
                                            v-model="facture.parent"
                                            @input="setFactureParent"
                                            @search="onSearchFac">
                                            <template slot="no-options">
                                                Sélectionnez une facture parent
                                            </template>
                                            <template #option="{ num_facture, client }">
                                                {{ num_facture }} - {{ client.raison_sociale }}
                                            </template>
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nif">N° Facture</label>
                                        <input type="text" class="form-control"
                                            placeholder="Entrez le n° de facture"
                                            v-model.trim="$v.facture.num_facture.$model"
                                            name="num_facture"
                                            autocomplete="off">
                                        <small class="form-text text-danger" v-if="!$v.facture.num_facture.required">Champs requis.</small>
                                        <!-- <small class="form-text text-danger" v-if="!$v.facture.num_facture.minLength">{{$v.facture.num_facture.$params.minLength.min}} caractères minimum.</small>
                                        <small class="form-text text-danger" v-if="!$v.facture.num_facture.maxLength">{{$v.facture.num_facture.$params.maxLength.max}} caractères maximum.</small> -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="type_id">Type</label>
                                        <v-select label="libelle" :options="types" v-model="facture.type_id" value="id"
                                            :reduce="type => type.id">
                                        </v-select>
                                        <small class="form-text text-danger" v-if="!$v.facture.type_id.required">Champs requis.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="montant">Montant</label>
                                        <input type="number" class="form-control" placeholder="Entrez le montant" v-model="$v.facture.montant.$model" name="montant">
                                        <small class="form-text text-danger" v-if="!$v.facture.montant.required">Champs requis.</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="num_dossier">N° Dossier</label>
                                        <input type="text" class="form-control"
                                            placeholder="Entrez le n° de dossier"
                                            v-model="$v.facture.num_dossier.$model"
                                            name="num_dossier"
                                            autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="date_creation">Date création</label><br>
                                        <date-picker
                                            v-model="$v.facture.date_creation.$model"
                                            value-type="YYYY-MM-DD"
                                            format="DD/MM/YYYY"
                                            placeholder="Selectionnez une date"></date-picker>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="date_creation">Date dépôt</label><br>
                                        <date-picker
                                            v-model="$v.facture.date_depot.$model"
                                            value-type="YYYY-MM-DD"
                                            format="DD/MM/YYYY"
                                            placeholder="Selectionnez une date"
                                            @input="updateDateEcheance($event)"></date-picker>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="date_creation">Date échéance</label><br>
                                        <date-picker
                                            v-model="$v.facture.date_echeance.$model"
                                            value-type="YYYY-MM-DD"
                                            format="DD/MM/YYYY"
                                            placeholder="Selectionnez une date"></date-picker>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-md-center">
                                <div class="col">
                                    <button class="btn btn-warning" :disabled="$v.facture.$invalid" 
                                        type="button" @click="save()" v-if="!btnLoading">
                                        <i class="fas fa-save mr-1"></i>Enregistrer
                                    </button>
                                    <a :href="'/factures'" v-if="!btnLoading">
                                        <button class="btn btn-danger" type="button">
                                            <i class="fas fa-times mr-1"></i>Annuler
                                        </button>
                                    </a>
                                    <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                                        <span class="spinner-grow spinner-grow-sm" role="status"></span>
                                        Création en cours...
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Facture from './../../models/facture'
    import FactureService from './../../services/factures'
    import TypeService from './../../services/types'
    import ClientService from './../../services/clients'
    import { required, minLength, maxLength, between, email, sameAs } from 'vuelidate/lib/validators';
    import 'vue-select/dist/vue-select.css';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import Client from '../../models/client'
    import _ from 'lodash'
    import Configuration from './../../services/configuration'
    import { addDays, parse, parseISO, toDate, format } from 'date-fns'

    export default {

        props : ['facture_id'],

        mounted() {
            
        },

        data(){
            return{
                facture: {},
                selectedFactureClientId:null,
                options_factures: [],
                options_clients: [],
                types: [],
                btnLoading: false,
                filter: {
                    keywordClient: '',
                    keywordFacture: ''
                },
                configurations: Configuration.getCNF()
            }
        },
        validations: {
            facture: {
                // client_id: { required },
                client: { required },
                // parent_id: {},
                parent: {},
                type_id: { required },
                // type: { required },
                num_facture: {
                    required
                },
                montant: {
                    required
                },
                num_dossier: {},
                date_creation: {
                    required,
                },
                date_depot: {},
                date_echeance: {},
                date_paiement: {},
                commentaire: {}
            }
        },
        created(){

            this.fetchFacture()
            this.fetchTypes()

        },

        methods: {
            fetchFacture(){
                let vm = this

                axios.get('/api/factures/'+vm.facture_id)
                    .then(res => {
                        vm.facture = res.data.data
                        vm.filter.keywordClient = vm.facture.client.raison_sociale
                        if(vm.facture.parent) vm.filter.keywordFacture = vm.facture.parent.num_facture
                        vm.fetchClients()
                        // vm.fetchFactures()
                        
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement de la facture!')
                    });
            },
            fetchClients(loading, search, vm){
                if(!vm) vm = this
                if(!search) search = vm.filter.keywordClient

                axios.get(`/api/clients?keyword=${search}`)
                    .then(res => {
                        if(loading) loading(false)
                        vm.options_clients = res.data.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des clients!')
                    });
            },
            fetchFactures(loading, search, vm){
                if(!vm) vm = this
                if(!search) search = vm.filter.keywordFacture

                axios.get(`/api/factures?keyword=${search}`)
                    .then(res => {
                        if(loading) loading(false)
                        vm.options_factures = res.data.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des factures!')
                    });
            },
            fetchTypes(){
                let vm = this
                axios.get('/api/types-facture')
                    .then(res => {
                        vm.types = res.data.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des types!')
                    });
            },
            save(){

                let vm = this;
                vm.btnLoading = true
                this.facture.parent_id = this.setValue(this.facture.parent_id)
                this.facture.num_dossier = this.setValue(this.facture.num_dossier)
                this.facture.date_depot = this.setValue(this.facture.date_depot)

                let copy = {...vm.facture}
                this.purge(copy)

                

                axios.patch(`/api/factures/${vm.facture.id}`, copy)
                .then(function (response)
                {
                    vm.btnLoading = false
                    vm.facture = response.data.data
                    toastr.warning('Modifications enregistrées!')
                })
                .catch(function (error) {
                    vm.btnLoading = false
                    let errors = error.response.data.errors;
                    if(errors.num_facture){
                        toastr.error(errors.num_facture[0])
                    }
                });

            },
            setSelected(value){
                // this.facture.parent_id = value.id
                // console.log(this.facture)
            },
            setValue(value){
                if(value === undefined){
                    return null
                }
                return value
            },
            searchFactures(search, loading){
                this.filter.facture = search
                this.fetchFactures()
            },
            onSearchClients(search, loading){
                loading(true);
                this.fetchClients(loading, search, this)
            },
            setFactureClient(e)
            {
              if(e != null && e!=undefined)
              {
                 this.facture.client_id = e.id
              }
            },
            onSearchFac(search, loading){
                loading(true);
                this.fetchFactures(loading, search, this)
            },
            setFactureParent(e){
                if(e != null && e!=undefined)
                {
                    this.facture.parent_id = e.id
                }
            },
            purge(facture){
                delete facture.client
                delete facture.utilisateur
                delete facture.parent
                delete facture.type
                delete facture.paiements
                delete facture.m_paid
                delete facture.m_not_paid
                delete facture.documents
                delete facture.activities
            },
            updateDateEcheance(e){
                let date_depot = parseISO(e)
                this.$v.facture.date_echeance.$model = format(addDays(date_depot, this.configurations.duree_echeance), 'Y-MM-dd')
                this.$forceUpdate()
            }
        }

    }
</script>
