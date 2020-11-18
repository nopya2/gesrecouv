<template>
    <div class="card-block table-border-style">
        <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn-secondary btn-sm">
                    <i class="fas fa-print"></i> Imprimer
                </button>
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Exporter excel
                </button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Exercice</label>
                    <select class="form-control form-control-sm" v-model="filter.exercice" @change="search">
                        <option v-for="(year, index) in years" v-bind:value="year">{{ year }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Etat</label>
                    <select class="form-control form-control-sm" v-model="filter.etat" @change="search">
                        <option value="">Tout</option>
                        <option value="cancelled">Annulé</option>
                        <option value="waiting">En attente de validation</option>
                        <option value="validated">Validé</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Recherche</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Engagement, Fournisseur, Devis"
                           v-model="filter.keyword" v-on:keyup="search">
                </div>
            </div>
        </div>
        <div class="table-border-style">
            <div class="d-flex justify-content-center mb-3" v-if="spinner">
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ pagination.total }} paiement(s)
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example1">
                    <thead>
                    <tr style="text-align: center;">
                        <th>#</th>
                        <th>Etat</th>
                        <th>N&deg; engagement</th>
                        <th>N&deg; ordonnance</th>
                        <th>Fournisseur</th>
                        <th>N&deg; devis</th>
                        <th>Nature dépense</th>
                        <th>Destination</th>
                        <th>Intitulé dépense</th>
                        <th>Date paiement</th>
                        <th>Montant payé</th>
                        <th>Pièces jointes</th>
                        <th>Utilisateur</th>
                    </tr>
                    </thead>
                    <tbody style="font-size: 14px">
                    <tr>
                        <td colspan="12" v-if="echelons.length <= 0">
                            Aucun engagement trouvé
                        </td>
                    </tr>
                    <tr v-for="(echelon, index) in echelons">
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item text-secondary" href="#" v-if="echelon.etat == 'validated' || echelon.etat == 'cancelled'">Aucune action</a>
                                    <a class="dropdown-item text-success" href="#" @click="openValidateForm(echelon)" v-if="echelon.etat == 'waiting'">Valider</a>
                                    <a class="dropdown-item text-danger" href="#" @click="annulerPaiement(echelon)" v-if="echelon.etat == 'waiting'">Annuler</a>
                                    <!--<a class="dropdown-item" href="#">Something else here</a>-->
                                </div>
                            </div>
                            <!--{{ echelon.id }}-->
                        </td>
                        <td>
                            <span v-if="echelon.etat == 'waiting'" class="right badge badge-secondary">En attente <br>de validation</span>
                            <span v-if="echelon.etat == 'validated'" class="right badge badge-success">Validé</span>
                            <span v-if="echelon.etat == 'cancelled'" class="right badge badge-danger">Annulé</span>
                        </td>
                        <td><a v-bind:href="'/engagements/'+echelon.engagement.id" target="_top">{{ echelon.n_engage }}</a></td>
                        <td>{{ echelon.n_ordonnance }}</td>
                        <td>{{ echelon.engagement.l_nmtir }}</td>
                        <td>{{ echelon.engagement.n_devis }}</td>
                        <td>{{ echelon.engagement.nat_dep }}</td>
                        <td>{{ echelon.engagement.l_dep }}</td>
                        <td>{{ echelon.engagement.l_depeng }}</td>
                        <td>{{ echelon.date_paiement }}</td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ echelon.m_paye|numFormat }}</span>
                        </td>
                        <td>
                            <ul>
                                <li v-for="document in echelon.documents">
                                    {{ document.filename }}
                                    <a :href="`/uploads/documents/${document.filename}`" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                        <td class="text-center">
                            <span :title="echelon.user.name+' '+echelon.user.firstname" class="rounded-circle avatar text-center">{{ echelon.user.avatar }}</span>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>#</th>
                        <th>Etat</th>
                        <th>N&deg; engagement</th>
                        <th>N&deg; ordonnance</th>
                        <th>Fournisseur</th>
                        <th>N&deg; devis</th>
                        <th>Nature dépense</th>
                        <th>Destination</th>
                        <th>Intitulé dépense</th>
                        <th>Date</th>
                        <th>Montant payé</th>
                        <th>Pièces jointes</th>
                        <th>Utilisateur</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a class="page-link" href="javascript:" tabindex="-1" @click="fetchEchelons(pagination.prev_page_url)">Précédent</a>
                    </li>
                    <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                    <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                    <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="javascript:" @click="fetchEchelons(pagination.next_page_url)">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="modal fade" id="modal-validate-paiement">
            <div class="modal-dialog">
                <div class="modal-content modal-">
                    <div class="modal-header">
                        <h4 class="modal-title">Valider Paiement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>N° engagement</label>
                            <input type="text" class="form-control" :value="selected_echelon.n_engage" readonly>
                        </div>
                        <div class="form-group">
                            <label>N° ordonnance</label>
                            <input type="text" class="form-control" :value="selected_echelon.n_ordonnance" readonly>
                        </div>
                        <div class="form-group">
                            <label>Date de paiement <small class="text-danger">(obligatoire)</small></label>
                            <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask ref="date_paiement">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="selected_echelon == ''" @click="validerPaiement" v-if="!btnLoading">Valider</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Validation en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { required, minLength, maxLength, between, email, sameAs, maxValue } from 'vuelidate/lib/validators';

    export default {
        mounted() {
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()
        },

        props : [],

        data(){
            return{
                echelons: [],
                filter: {
                    keyword: '',
                    exercice: '',
                    etat: '',
                },
                selected_echelon: {
                    date_paiement: null,
                    n_ordonnance: '',
                    n_engage: ''
                },
                spinner: false,
                api_token: '',
                pagination: {
                    current_page: 1,
                    total: 0
                },
                btnLoading: false,
                years: [],
                exercice: 0

            }
        },
        validations: {
            selected_echelon: {
                date_paiement: {
                    required
                }
            },
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.loadYears()
                this.fetchEchelons()
            }

        },

        methods: {
            fetchEchelons(page) {
                let vm = this;
                this.spinner = true;

                let url_parameters = `api_token=${this.api_token}&keyword=${this.filter.keyword}&exercice=${this.filter.exercice}`
                    +`&etat=${this.filter.etat}`
                let page_url = `/api/echelons?${url_parameters}`
                if(page) page_url = `${page}&${url_parameters}`

                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.echelons = res.data
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
                }

                this.pagination = pagination;
            },
            search(){
                this.fetchEchelons();
            },
            loadYears(){
                var dt = new Date();
                let start = parseInt(dt.getFullYear())
                this.filter.exercice = parseInt(dt.getFullYear())
                this.exercice = parseInt(dt.getFullYear())
                for(var i=0; i <= parseInt(dt.getFullYear()); i++){
                    this.years[i] = start
                    start --
                    if(start < 2010) break
                }
            },
            openValidateForm(echelon){
                this.selected_echelon = {...echelon}
                $('#modal-validate-paiement').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            validerPaiement(){
                this.selected_echelon.date_paiement =  this.$refs.date_paiement.value
                let vm = this;

                fetch(`/api/echelon/valider?api_token=${this.api_token}`, {
                    method: 'post',
                    body: JSON.stringify(this.selected_echelon),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        vm.btnLoading = false
                        toastr.success('Paiement validé!')
                        let index = vm.echelons.findIndex(x => x.id === vm.selected_echelon.id)
                        if(index !== -1){
                            vm.echelons.splice(index, 1, res.data)
                        }
                        $('#modal-validate-paiement').modal('hide')

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur validation!.')
                    });

                // Swal.fire({
                //     title: 'Insérer la date de paiement',
                //     // text: 'Insérer la date de paiement',
                //     input: 'text',
                //     inputAttributes: {
                //         autocapitalize: 'off',
                //         id: 'date-paiement',
                //         'data-inputmask-alias': 'datetime',
                //         'data-inputmask-inputformat': "dd/mm/yyyy",
                //         'data-mask': 'data-mask',
                //         ref: 'date_paiement'
                //     },
                //     showCancelButton: true,
                //     confirmButtonText: 'Valider',
                //     cancelButtonText: 'Fermer',
                //     confirmButtonColor: '#27A444',
                //     showLoaderOnConfirm: true,
                //     preConfirm: (login) => {
                //         return fetch(`/api/echelon/valider?api_token=${this.api_token}`, {
                //             method: 'post',
                //             body: JSON.stringify(echelon),
                //             headers: {
                //                 'content-type': 'application/json'
                //             }
                //         })
                //             .then(response => {
                //                 if (!response.ok) {
                //                     throw new Error(response.statusText)
                //                 }
                //                 return response.json()
                //             })
                //             .catch(error => {
                //                 Swal.showValidationMessage(
                //                     `Request failed: ${error}`
                //                 )
                //             })
                //     },
                //     allowOutsideClick: () => !Swal.isLoading()
                // }).then((result) => {
                //     if (result.value) {
                //         toastr.success('Paiement validé!')
                //         let index = vm.echelons.findIndex(x => x.id === echelon.id)
                //         if(index !== -1){
                //             console.log(index)
                //             vm.echelons.splice(index, 1, result.value.data)
                //         }
                //     }
                // })
            },
            annulerPaiement(echelon){
                let vm = this;

                Swal.fire({
                    title: 'Annuler',
                    text: 'Etes-vous sur de vouloir annuler ce paiement?',
                    showCancelButton: true,
                    confirmButtonText: 'Annuler paiement',
                    cancelButtonText: 'Fermer',
                    confirmButtonColor: '#DC3545',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`/api/echelon/annuler?api_token=${this.api_token}`, {
                            method: 'post',
                            body: JSON.stringify(echelon),
                            headers: {
                                'content-type': 'application/json'
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
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
                        toastr.error('Paiement annulé!')
                        let index = vm.echelons.findIndex(x => x.id === echelon.id)
                        if(index !== -1){
                            console.log(index)
                            vm.echelons.splice(index, 1, result.value.data)
                        }
                    }
                })
            }
        }

    }
</script>
