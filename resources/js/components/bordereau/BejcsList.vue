<template>
    <div class="card-block table-border-style">
        <div class="row mb-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-success mb-1" @click="createSlip" v-if="editer">
                    <i class="fa fa-plus-circle"></i> Nouveau bordereau
                </button>
            </div>
            <div class="col-md-4 offset-md-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="validationTooltipUsernamePrepend">
                            <span class="badge badge-pill badge-primary">{{ pagination.total }}</span>
                        </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Tapez votre recherche" aria-label="Recipient's groupname"
                           aria-describedby="basic-addon2" v-model="keyword" v-on:keyup="search">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="feather icon-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-border-style">
            <div class="d-flex justify-content-center mb-3" v-if="spinner">
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example1">
                    <thead>
                    <tr style="text-align: center;">
                        <th>N° bordereau</th>
                        <th>Nature</th>
                        <th>Chapitre</th>
                        <th>Nbre ordonnances</th>
                        <th>Montant total ordonnancé</th>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="slips.length <= 0">
                        <td colspan="8" class="text-center">Aucun bordereau trouvé</td>
                    </tr>
                    <tr v-for="(slip, index) in slips" v-bind:key="slip.id">
                        <td class="text-center">{{ slip.id }}</td>
                        <td>{{ slip.nature }}</td>
                        <td>{{ slip.chapitre.n_chap }} - {{ slip.chapitre.l_chap }}</td>
                        <td class="text-center">{{ slip.echelons.length }}</td>
                        <td class="text-center">{{ slip.m_ordonnance }}</td>
                        <td class="text-center">{{ slip.created_at|moment('DD/MM/YYYY') }}</td>
                        <td class="text-center" style="text-align: center; horiz-align: center">
                            <span :title="slip.user.name+' '+slip.user.firstname" class="rounded-circle avatar text-center">{{ slip.user.avatar }}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-xs btn-info mr-1 mb-1" title="Détails" @click="showDetails(slip)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-xs btn-secondary mr-1 mb-1" title="Imprimer" @click="print(slip)">
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>N° bordereau</th>
                        <th>Nature</th>
                        <th>Chapitre</th>
                        <th>Nbre ordonnances</th>
                        <th>Montant total ordonnancé</th>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                            <a class="page-link" href="javascript:" tabindex="-1" @click="fetchSlips(pagination.prev_page_url+'&api_token='+api_token)">Précédent</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                        <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                        <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                            <a class="page-link" href="javascript:" @click="fetchSlips(pagination.next_page_url+'&api_token='+api_token)">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal pour les details du bordereau -->
        <div class="modal fade" id="modal-details">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Détails du bordereau N°{{ details.id }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive p-0 col-md-12">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>N° engagement</th>
                                    <th>Imputation</th>
                                    <th>Montant engagé</th>
                                    <th>N° ordonnance</th>
                                    <th>Fournisseur</th>
                                    <th>Objet dépense</th>
                                    <th>Montant Ordonnancé</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in details.echelons">
                                    <td>{{ index + 1}}</td>
                                    <td>{{ item.engagement.n_engage }}</td>
                                    <td>{{ item.engagement.c_dest }}</td>
                                    <td>{{ item.engagement.m_engage }}</td>
                                    <td>{{ item.n_ordonnance }}</td>
                                    <td>{{ item.engagement.l_nmtir }}</td>
                                    <td>{{ item.engagement.l_dep }}</td>
                                    <td>{{ item.m_paye }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Modal pour les details du bordereau -->

    </div>
</template>

<script>
    import { required} from 'vuelidate/lib/validators';

    export default {
        mounted() {
            // console.log('Component mounted.')
        },

        props: ['editer'],

        data(){
            return{
                slips: [],
                engagements: [],
                chapitres: [],
                details: {
                    id: null,
                    chapitre: {},
                    echelons: [],

                },
                keyword: '',
                spinner: false,
                api_token: '',
                pagination: {
                    current_page: 1,
                    total: 0
                },
                btnLoading: false,

            }
        },
        validations: {
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.fetchSlips()
                this.fetchChapitres()
            }

        },

        methods: {
            fetchSlips(page_url) {
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/bordereau/bejcs?api_token=${this.api_token}&keyword=${this.keyword}`
                    +`&limit=10`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.slips = res.data
                        vm.makePagination(res.meta, res.links)
                    })
                    .catch(error => {
                        console.log(error)
                        this.spinner = false
                    });
            },
            fetchChapitres(){
                let url_parameters = `api_token=${this.api_token}`

                let page_url = `/api/parametres/chapitres?${url_parameters}`

                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.chapitres = res.data
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
                this.fetchSlips();
            },
            openDetailsModal(){
                $('#modal-details').modal({
                    show: true,
                })
            },
            createSlip(){
                window.location = '/bordereau/bejcs/create'
                // this.openSlipForm()
            },
            showDetails(slip){
                this.details = {...slip}
                console.log(this.details)
                this.openDetailsModal()
            },
            print(slip){
                window.open(`/bordereau/bejcs/pdf/${slip.id}`)
            }

        }

    }
</script>
