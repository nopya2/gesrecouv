<template>
    <div class="card-block table-border-style">
        <div class="row mb-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-sm" @click="createChapitre">
                    <i class="fa fa-plus-circle"></i> Ajouter un chapitre
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
                        <!-- <th>#</th> -->
                        <th>Numéro</th>
                        <th>Libellé</th>
                        <th>Nature</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="chapitres.length <= 0">
                        <td colspan="3" class="text-center">Aucun chapitre trouvé</td>
                    </tr>
                    <tr v-for="(chapitre, index) in chapitres" v-bind:key="chapitre.id">
                        <!-- <td>{{ group.id }}</td> -->
                        <td>{{ chapitre.n_chap }}</td>
                        <td>{{ chapitre.l_chap }}</td>
                        <td>{{ chapitre.nature }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-icon mr-1 mb-1" title="Modifier" @click="editChapitre(chapitre)">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-danger mr-1 mb-1" title="Supprimer" @click="deleteChapitre(chapitre.id)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>Numéro</th>
                        <th>Libellé</th>
                        <th>Nature</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                            <a class="page-link" href="javascript:" tabindex="-1" @click="fetchChapitres(pagination.prev_page_url+'&api_token='+api_token)">Précédent</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                        <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                        <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                            <a class="page-link" href="javascript:" @click="fetchChapitres(pagination.next_page_url+'&api_token='+api_token)">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal Creer chapitre -->
        <div class="modal fade" id="modal-chapitre-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ chapitre_form.title }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeChapitreForm">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="n_chap">Numéro de chapitre</label>
                                <input type="number" class="form-control" id="n_chap" placeholder="Entrez le numéro de chapitre" v-model.trim="$v.chapitre_form.n_chap.$model">
                            </div>
                            <div class="form-group">
                                <label for="l_chap">Libellé du chapitre</label>
                                <textarea class="form-control" id="l_chap" placeholder="Entrez le libellé" v-model.trim="$v.chapitre_form.l_chap.$model"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="nature">Nature</label>
                                <select class="form-control" v-model.trim="$v.chapitre_form.nature.$model">
                                    <option value="">--- Sélectionnez une nature ---</option>
                                    <option value="Fonctionnement">Fonctionnement</option>
                                    <option value="Investissement">Investissement</option>
                                </select>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeChapitreForm">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.chapitre_form.$invalid" @click="saveChapitre" v-if="!btnLoading && chapitre_form.action =='create'">Créer</button>
                        <button type="button" class="btn btn-warning" :disabled="$v.chapitre_form.$invalid" @click="updateChapitre" v-if="!btnLoading && chapitre_form.action =='update'">Modifier</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Modal Creer groupe -->

    </div>
</template>

<script>
    import { required, minLength, maxLength, between, email, sameAs, maxValue } from 'vuelidate/lib/validators';

    export default {
        mounted() {
            // console.log('Component mounted.')
        },

        data(){
            return{
                chapitres: [],
                chapitre_form: {
                    id: null,
                    n_chap: '',
                    l_chap: '',
                    action: 'create',
                    title: '',
                    nature: ''
                },
                // selected_group: {
                //     permissions: []
                // },
                title: '',
                description: '',
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
            chapitre_form: {
                n_chap: {
                    required,
                },
                l_chap: {
                    required
                },
                nature: {
                    required
                }
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.fetchChapitres()
            }

        },

        methods: {
            fetchChapitres(page_url) {
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/parametres/chapitres?api_token=${this.api_token}&keyword=${this.keyword}`
                    +`&limit=10`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.chapitres = res.data
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
                }

                this.pagination = pagination;
            },
            search(){
                this.fetchChapitres();
            },
            deleteChapitre(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`/api/parametres/chapitres/${id}?api_token=${this.api_token}`, { method: 'delete' })
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
                        vm.fetchChapitres();
                    }
                })
            },
            openChapitreForm(){
                $('#modal-chapitre-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeChapitreForm(){
                this.chapitre_form = {
                    id: '',
                    n_chap: '',
                    l_chap: '',
                    title: '',
                    action: '',
                    nature: ''
                }
            },
            createChapitre(){
                this.chapitre_form.title = `Créer un chapitre`
                this.chapitre_form.action = `create`
                this.openChapitreForm()
            },
            saveChapitre(){
                this.btnLoading = true

                fetch(`/api/parametres/chapitres?api_token=${this.api_token}`, {
                    method: 'post',
                    body: JSON.stringify(this.chapitre_form),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-chapitre-form').modal('hide')
                        this.closeChapitreForm()
                        toastr.success('Chapitree créé!')
                        this.fetchChapitres()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur d\'ajout du chapitre!')
                    });
            },
            updateChapitre(){
                this.btnLoading = true

                fetch(`/api/parametres/chapitres?api_token=${this.api_token}`, {
                    method: 'put',
                    body: JSON.stringify(this.chapitre_form),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-chapitre-form').modal('hide')
                        this.closeChapitreForm()
                        toastr.warning('Modifications engregistrées!')
                        this.fetchChapitres()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur modificaion du groupe!.')
                    });
            },
            editChapitre(chapitre){
                this.chapitre_form = {...chapitre}
                this.chapitre_form.title = `Modifier le chapitre [${chapitre.id}]`
                this.chapitre_form.action = "update"
                this.openChapitreForm()
            },

        }

    }
</script>
