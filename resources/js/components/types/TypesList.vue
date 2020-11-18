<template>
    <div class="card-block table-border-style">
        <div class="row mb-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-sm" @click="createType">
                    <i class="fa fa-plus-circle"></i> Ajouter un type
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
                        <th>Libellé</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="types.length <= 0">
                        <td colspan="4" class="text-center">Aucun type trouvé</td>
                    </tr>
                    <tr v-for="type in types" v-bind:key="type.id">
                        <!-- <td>{{ group.id }}</td> -->
                        <td>{{ type.libelle }}</td>
                        <td>{{ type.code }}</td>
                        <td>{{ type.description }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-icon mr-1 mb-1" title="Modifier" @click="editType(type)">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-danger mr-1 mb-1" title="Supprimer" @click="deleteType(type.id)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>Libellé</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                            <a class="page-link" href="javascript:" tabindex="-1" @click="fetchTypes(pagination.prev_page_url+'&api_token='+api_token)">Précédent</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                        <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                        <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                            <a class="page-link" href="javascript:" @click="fetchTypes(pagination.next_page_url+'&api_token='+api_token)">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal Créer et modifier un type -->
        <div class="modal fade" id="modal-type-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ type_form.title }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeTypeForm">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="libelle">Libellé</label>
                                <input type="text" class="form-control" id="libelle" placeholder="Entrez le libellé" v-model.trim="$v.type_form.libelle.$model">
                            </div>
                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" id="code" placeholder="Entrez le code" v-model.trim="$v.type_form.code.$model">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Entrez la description" v-model.trim="$v.type_form.description.$model"></textarea>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeTypeForm">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.type_form.$invalid" @click="saveType" v-if="!btnLoading && type_form.action =='create'">Créer</button>
                        <button type="button" class="btn btn-warning" :disabled="$v.type_form.$invalid" @click="updateType" v-if="!btnLoading && type_form.action =='update'">Modifier</button>
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
    import TypeService from '../../services/types'

    export default {
        mounted() {
            // console.log('Component mounted.')
        },

        data(){
            return{
                types: [],
                type_form: {
                    id: null,
                    libelle: '',
                    code: '',
                    description: '',
                    action: 'create',
                    title: '',
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
            type_form: {
                libelle: {
                    required,
                    minLength: minLength(3)
                },
                code: {
                    required,
                },
                description: {}
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.fetchTypes()
            }

        },

        methods: {
            fetchTypes(page_url) {
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/parametres/types-facture?api_token=${this.api_token}&keyword=${this.keyword}`
                    +`&limit=10`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.types = res.data
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
            deleteType(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return TypeService.deleteType(id)
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
                        vm.fetchTypes();
                    }
                })
            },
            openTypeForm(){
                $('#modal-type-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeTypeForm(){
                this.type_form = {
                    id: '',
                    libelle: '',
                    code: '',
                    description: '',
                    title: '',
                    action: '',
                }
            },
            createType(){
                this.type_form.title = `Créer un type`
                this.type_form.action = `create`
                this.openTypeForm()
            },
            saveType(){
                this.btnLoading = true

                TypeService.createType(this.type_form)
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-type-form').modal('hide')
                        this.closeTypeForm()
                        toastr.success('Type créé!')
                        this.fetchTypes()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error("Erreur création du type!")
                    });
            },
            updateType(){
                this.btnLoading = true

                TypeService.updateType(this.type_form)
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-type-form').modal('hide')
                        this.closeTypeForm()
                        toastr.warning('Modifications engregistrées!')
                        this.fetchTypes()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur modificaion du type!.')
                    });
            },
            editType(type){
                this.type_form = {...type}
                this.type_form.title = `Modifier le type [${type.id}]`
                this.type_form.action = "update"
                this.openTypeForm()
            },

        }

    }
</script>
