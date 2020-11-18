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
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" placeholder="Tapez votre recherche, raison sociale ou NIF" v-model="filter.keyword" v-on:keyup="search">
            </div>
        </div>

        <div class="table-border-style mt-3">
            <div class="d-flex justify-content-center mb-3" v-if="spinner">
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped" id="example1">
                    <thead>
                    <tr class="text-center">
                        <th></th>
                        <th>N° Facture</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Client</th>
                        <th>Facture initiale</th>
                        <th>Dates</th>
                        <th>Documents</th>
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
                                    <a class="dropdown-item text-success text-sm" href="javascript:void(0);" v-if="facture.state == 'waiting'" @click="validate(facture)">
                                        <i class="fas fa-check mr-1"></i> Valider
                                    </a>
                                    <a class="dropdown-item text-warning text-sm" href="javascript:void(0);">
                                        <i class="fas fa-edit mr-1"></i> Modifier
                                    </a>
                                    <a class="dropdown-item text-indigo text-sm" href="javascript:void(0);" v-if="facture.state == 'validated'">
                                        <i class="fas fa-exclamation mr-1"></i> Litige
                                    </a>
                                    <a class="dropdown-item text-sm" href="javascript:void(0);" v-if="facture.state == 'validated'">
                                        <i class="fas fa-exchange-alt mr-1"></i> Convertir en avoir
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-gray-dark text-sm" href="javascript:void(0);" v-if="facture.state == 'waiting'" @click="cancel(facture)">
                                        <i class="fas fa-times mr-1"></i> Annuler
                                    </a>
                                    <a class="dropdown-item text-danger text-sm" href="javascript:void(0);">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="vertical-align">
                            <i class="fas fa-check-circle text-success mr-1" v-if="facture.state=='validated'"></i>
                            <i class="fas fa-times-circle text-danger mr-1" v-if="facture.state=='cancelled'"></i>
                            {{ facture.num_facture }}
                        </td>
                        <td class="vertical-align">{{ facture.type.libelle }}</td>
                        <td class="vertical-align">{{ facture.montant|numFormat }}</td>
                        <td class="vertical-align">{{ facture.client.raison_sociale }}</td>
                        <td class="vertical-align">
                            <template v-if="facture.parent">
                                {{ facture.parent.num_facture }} - {{ facture.client.raison_sociale }}
                            </template>
                        </td>
                        <td class="vertical-align">
                            Création: {{ facture.date_creation | moment("DD/MM/YYYY") }} <br>
                            Dépot: {{ facture.date_depot | moment("DD/MM/YYYY") }} <br>
                            Echéance: {{ facture.date_echeance | moment("DD/MM/YYYY") }}<br>
                            Paiement: {{ facture.paiement | moment("DD/MM/YYYY") }}
                        </td>
                        <td class="vertical-align"></td>
                        <td class="vertical-align">{{ facture.statut }}</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="text-center">
                        <th></th>
                        <th>N° Facture</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Client</th>
                        <th>Facture initiale</th>
                        <th>Dates</th>
                        <th>Documents</th>
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

    </div>
</template>

<script>
    import Facture from '../../models/facture'

    export default {

        props : [],

        data(){
            return{
                factures: [],
                filter: {
                    keyword: '',
                },
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

                this.fetchFactures()
            }

        },

        methods: {
            fetchFactures(page) {
                let vm = this;
                this.spinner = true;

                let url_parameters = `api_token=${this.api_token}&keyword=${this.filter.keyword}&limit=10`
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
            search(){
                this.fetchFactures();
            },
            deleteFacture(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`/api/factures/${id}?api_token=${this.api_token}`, { method: 'delete' })
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
                        toastr.warning('Suppression terminée!.')
                        vm.fetchClients();
                    }
                })
            },
            validate(facture){
                let copy = {...facture}
                copy.state = 'validated'
                this.purge(copy)

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir valider cette facture?',
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    confirmButtonColor: '#28a745',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.patch("/api/factures/"+copy.id+"/validate", copy)
                            .then(function (response)
                            {
                                // if (!response.ok) {
                                //     throw new Error(response.statusText)
                                //     console.log(0)
                                // }
                                // return response.json()
                                console.log(0)
                            })
                            .catch(function (error) {
                                // console.log(error.response.data.message)
                                Swal.showValidationMessage(
                                    `Erreur validation: ${error.response.data.message}`
                                )
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        facture.state = 'validated'
                        toastr.success('Facture validée!')
                    }
                    console.log(result)
                })
            },
            cancel(facture){
                let copy = {...facture}
                copy.state = 'validated'
                this.purge(copy)

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir annuler cette facture?',
                    showCancelButton: true,
                    confirmButtonText: 'Annuler',
                    confirmButtonColor: '#dc3545',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.patch("/api/factures/"+copy.id+"/cancel", copy)
                            .then(function (response)
                            {
                                // if (!response.ok) {
                                //     throw new Error(response.statusText)
                                //     console.log(0)
                                // }
                                // return response.json()
                                console.log(0)
                            })
                            .catch(function (error) {
                                // console.log(error.response.data.message)
                                Swal.showValidationMessage(
                                    `Erreur validation: ${error.response.data.message}`
                                )
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        facture.state = 'cancelled'
                        toastr.warning('Facture annulée!')
                    }
                    console.log(result)
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
            }
        }

    }
</script>

<style scoped>
.vertical-align{
    vertical-align: middle;
}
</style>
