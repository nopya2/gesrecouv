<template>
    <div class="card-block table-border-style">
        <div class="row mb-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-sm" @click="createGroup">
                    <i class="fa fa-plus-circle"></i> Créer un groupe
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
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Permissions</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="groups.length <= 0">
                            <td colspan="4" class="text-center">Aucun groupe trouvé</td>
                        </tr>
                        <tr v-for="(group, index) in groups" v-bind:key="group.id">
                            <!-- <td>{{ group.id }}</td> -->
                            <td>{{ group.name }}</td>
                            <td>{{ group.description }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm" @click="openPermissions(group)">
                                    <i class="fas fa-key"></i> Permissions
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-icon btn-xs" title="Modifier" @click="editGroup(group)">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-xs" title="Supprimer" @click="deleteGroup(group.id)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Permissions</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                            <a class="page-link" href="javascript:" tabindex="-1" @click="fetchGroups(pagination.prev_page_url+'&api_token='+api_token)">Précédent</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                        <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                        <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                            <a class="page-link" href="javascript:" @click="fetchGroups(pagination.next_page_url+'&api_token='+api_token)">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal Creer groupe -->
        <div class="modal fade" id="modal-group-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ group_form.title }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeGroupForm">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control" id="name" placeholder="Entrez le nom" v-model.trim="$v.group_form.name.$model">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Entrez la description" v-model.trim="$v.group_form.description.$model"></textarea>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeGroupForm">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.group_form.$invalid" @click="saveGroup" v-if="!btnLoading && group_form.action =='create'">Créer</button>
                        <button type="button" class="btn btn-warning" :disabled="$v.group_form.$invalid" @click="updateGroup" v-if="!btnLoading && group_form.action =='update'">Modifier</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Modal Creer groupe -->

        <div class="modal fade" id="modal-permissions">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Permissions</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2" v-for="module in modules">
                            <div class="col-md-12">
                                <h4>{{ module.name }}</h4>
                                <div class="row">
                                    <div class="col-md-3" v-for="permission in module.permissions">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" :checked="hasPermission(permission.id)" value=""  @change="">
                                                <label for="customCheckbox2" class="custom-control-label">{{permission.name}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
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
            // console.log('Component mounted.')
        },

        data(){
            return{
                groups: [],
                group_form: {
                    id: null,
                    name: '',
                    description: '',
                    action: 'create',
                    title: ''
                },
                selected_group: {
                    permissions: []
                },
                title: '',
                description: '',
                keyword: '',
                spinner: false,
                api_token: '',
                pagination: {
                    current_page: 1,
                    total: 0
                },
                modules: [],
                btnLoading: false,

            }
        },
        validations: {
            group_form: {
                name: {
                    required,
                },
                description: {
                    required
                }
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.fetchGroups()
                this.fetchModules()
            }

        },

        methods: {
            fetchGroups(page_url) {
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/groups?api_token=${this.api_token}&keyword=${this.keyword}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.groups = res.data
                        vm.makePagination(res.meta, res.links)
                    })
                    .catch(error => {
                        console.log(error)
                        this.spinner = false
                    });
            },
            fetchModules() {
                let page_url = `/api/modules?api_token=${this.api_token}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.modules = res.data
                    })
                    .catch(error => {
                        console.log(error)
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
            create(){
                window.location = '/group/create';
            },
            search(){
                this.fetchGroups();
            },
            deleteGroup(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`api/groups/${id}?api_token=${this.api_token}`, { method: 'delete' })
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
                        toastr.error('Suppression terminée!.')
                        vm.fetchGroups();
                    }
                })
            },
            openGroupForm(){
                $('#modal-group-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeGroupForm(){
                this.group_form = {
                    id: '',
                    name: '',
                    description: '',
                    title: '',
                    action: ''
                }
            },
            createGroup(){
                this.group_form.title = `Créer un groupe`
                this.group_form.action = `create`
                this.openGroupForm()
            },
            saveGroup(){
                this.btnLoading = true

                fetch(`/api/groups?api_token=${this.api_token}`, {
                    method: 'post',
                    body: JSON.stringify(this.group_form),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-group-form').modal('hide')
                        this.closeGroupForm()
                        toastr.success('Groupe créé!')
                        this.fetchGroups()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur création du groupe!.')
                    });
            },
            updateGroup(){
                this.btnLoading = true

                fetch(`/api/groups?api_token=${this.api_token}`, {
                    method: 'put',
                    body: JSON.stringify(this.group_form),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-group-form').modal('hide')
                        this.closeGroupForm()
                        toastr.warning('Modifications engregistrées!')
                        this.fetchGroups()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur modificaion du groupe!.')
                    });
            },
            editGroup(group){
                this.group_form = {...group}
                this.group_form.title = `Modifier le groupe [${group.id}]`
                this.group_form.action = "update"
                this.openGroupForm()
            },
            openPermissions(group){
                // this.selected_group = group
                // console.log(this.selected_group)
                // $('#modal-permissions').modal({
                //     show: true,
                //     backdrop: 'static'
                // })
                window.location = `/groups/${group.id}/permissions`
            },
            hasPermission(permissionId){
                let index = this.selected_group.permissions.findIndex(x => x.id === permissionId);
                if(index !== -1) {
                    return true;
                }
                else {
                    return false;
                }
            }

        }

    }
</script>
