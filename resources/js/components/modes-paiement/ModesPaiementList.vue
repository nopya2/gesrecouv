<template>
    <div class="card-block table-border-style">
        <div class="row mb-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-sm" @click="createMode">
                    <i class="fa fa-plus-circle"></i> Ajouter un mode de paiement
                </button>
            </div>
            <div class="col-md-4 offset-md-2">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="validationTooltipUsernamePrepend">
                            <span class="badge badge-pill badge-primary">{{ pagination.total }}</span>
                        </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Tapez votre recherche" aria-label="Recipient's groupname"
                           aria-describedby="basic-addon2" v-model="filter.keyword" v-on:keyup="search">
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
                        <th>Libellé</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="modes.length <= 0">
                        <td colspan="3" class="text-center">Aucun mode de paiement trouvé</td>
                    </tr>
                    <tr v-for="mode in modes" v-bind:key="mode.id">
                        <td>{{ mode.libelle }}</td>
                        <td>{{ mode.description }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-icon mr-1 mb-1" title="Modifier" @click="editMode(mode)">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-danger mr-1 mb-1" title="Supprimer" @click="deleteMode(mode.id)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>Libellé</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                            <a class="page-link" href="javascript:" tabindex="-1" @click="fetchModes(pagination.prev_page_url)">Précédent</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                        <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                        <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                            <a class="page-link" href="javascript:" @click="fetchModes(pagination.next_page_url)">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal Créer et modifier un type -->
        <div class="modal fade" id="modal-mode-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ mode_form.title }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModeForm">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="libelle">Libellé</label>
                                <input type="text" class="form-control" id="libelle" placeholder="Entrez le libellé" v-model.trim="$v.mode_form.libelle.$model">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Entrez la description" v-model.trim="$v.mode_form.description.$model"></textarea>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeModeForm">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.mode_form.$invalid" @click="saveMode" v-if="!btnLoading && mode_form.action =='create'">Créer</button>
                        <button type="button" class="btn btn-warning" :disabled="$v.mode_form.$invalid" @click="updateMode" v-if="!btnLoading && mode_form.action =='update'">Modifier</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Modal Creer mode -->

    </div>
</template>

<script>
    import { required, minLength, maxLength, between, email, sameAs, maxValue } from 'vuelidate/lib/validators';
    import ModePaiement from '../../models/mode-paiement'
    import ModePaiementService from '../../services/mode-paiement'

    export default {
        mounted() {
            // console.log('Component mounted.')
        },

        data(){
            return{
                modes: [],
                mode_form: {
                    id: null,
                    libelle: '',
                    description: '',
                    action: 'create',
                    title: '',
                },
                filter: {
                    keyword: ''
                },
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
            mode_form: {
                libelle: {
                    required,
                    minLength: minLength(3)
                },
                description: {}
            }
        },

        created(){

            this.fetchModes()

        },

        methods: {
            fetchModes(url) {
                let vm = this;
                this.spinner = true;

                let parameters = `keyword=${this.filter.keyword}&limit=10`
                if(url){
                    var url_string = new URL(url)
                    var page = url_string.searchParams.get('page')
                    parameters = `page=${page}&${parameters}`
                }

                ModePaiementService.getModes(parameters)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.modes = res.data
                        vm.makePagination(res.meta, res.links)
                    })
                    .catch(error => {
                        console.log(error)
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
                this.fetchTypes();
            },
            deleteMode(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return ModePaiementService.deleteMode(id)
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
                        vm.fetchModes();
                    }
                })
            },
            openModeForm(){
                $('#modal-mode-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeModeForm(){
                this.mode_form = {
                    id: '',
                    libelle: '',
                    description: '',
                    title: '',
                    action: '',
                }
            },
            createMode(){
                this.mode_form.title = `Créer un mode de paiement`
                this.mode_form.action = `create`
                this.openModeForm()
            },
            saveMode(){
                this.btnLoading = true

                ModePaiementService.createMode(this.mode_form)
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-mode-form').modal('hide')
                        this.closeModeForm()
                        toastr.success('Mode de paiement créé!')
                        this.fetchModes()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error("Erreur création du mode de paiement!")
                    });
            },
            updateMode(){
                this.btnLoading = true

                ModePaiementService.updateMode(this.mode_form)
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-mode-form').modal('hide')
                        this.closeModeForm()
                        toastr.warning('Modifications engregistrées!')
                        this.fetchModes()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur modificaion du mode de paiement!.')
                    });
            },
            editMode(mode){
                this.mode_form = {...mode}
                this.mode_form.title = `Modifier le mode de paiement [${mode.id}]`
                this.mode_form.action = "update"
                this.openModeForm()
            },

        }

    }
</script>
