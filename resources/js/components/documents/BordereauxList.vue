<template>
    <div class="card-block table-border-style">
        <div class="row mb-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-sm" @click="UploadFile">
                    <i class="fa fa-upload"></i> Uploader bordereau
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
                            <th>Fichier</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="files.length <= 0">
                            <td colspan="5" class="text-center">Aucun fichier trouvé</td>
                        </tr>
                        <tr v-for="(file, index) in files" v-bind:key="file.id">
                            <!-- <td>{{ group.id }}</td> -->
                            <td>{{ file.name }}</td>
                            <td>{{ file.description }}</td>
                            <td><a :href="'/uploads/documents/'+file.documents[0].filename" target="_blank">Test</a></td>
                            <td class="text-center">{{ file.uploaded_at|moment('DD/MM/YYYY') }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-icon btn-danger btn-xs" title="Supprimer" @click="deleteFile(file.id)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Fichier</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                            <a class="page-link" href="javascript:" tabindex="-1" @click="fetchFiles(pagination.prev_page_url+'&api_token='+api_token)">Précédent</a>
                        </li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                        <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                        <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                            <a class="page-link" href="javascript:" @click="fetchFiles(pagination.next_page_url+'&api_token='+api_token)">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal Creer groupe -->
        <div class="modal fade" id="modal-file-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Uploader Fichier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeFileForm">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" class="dropzone" id="my-awesome-dropzone" action="/file-upload">
                            <div class="form-group">
                                <label for="name">Nom <small class="text-danger">(obligatoire)</small></label>
                                <input type="text" class="form-control" id="name" placeholder="Entrez le nom" v-model.trim="$v.file_form.name.$model">
                            </div>
                            <div class="form-group">
                                <label>Date <small class="text-danger">(obligatoire)</small></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control float-right calendrier">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" ref="doc" @change="handleFileUpload">
                                    <label class="custom-file-label" for="customFile">{{ file_form.filename }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Entrez la description" v-model.trim="$v.file_form.description.$model"></textarea>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeFileForm">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.file_form.$invalid || !file_form.doc" @click="saveFile" v-if="!btnLoading">Créer</button>
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
            let vm = this
            setTimeout(function () {
                $('.calendrier').daterangepicker({
                    singleDatePicker: true,
                    startDate:moment(),
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                })

                $('.calendrier').on('apply.daterangepicker', function(ev, picker) {
                    // vm.filter.start = picker.startDate.format('YYYY-MM-DD');
                    // vm.filter.end = picker.endDate.format('YYYY-MM-DD');
                    vm.file_form.uploaded_at = moment().format('YYYY-MM-DD')
                });
            }, 100)
        },

        data(){
            return{
                files: [],
                file_form: {
                    id: null,
                    name: '',
                    description: '',
                    uploaded_at: '',
                    doc: null,
                    filename: 'Sélecionnez un fichier'
                },
                title: '',
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
            file_form: {
                name: {
                    required,
                },
                uploaded_at: {
                    required
                }
                ,description: {

                }
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.fetchFiles()
                this.file_form.uploaded_at = moment().format('YYYY-MM-DD')
            }

        },

        methods: {
            fetchFiles(page_url) {
                let vm = this;
                this.spinner = true;

                page_url = page_url || `/api/documents/bordereaux?api_token=${this.api_token}&keyword=${this.keyword}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.files = res.data
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
                this.fetchFiles();
            },
            handleFileUpload(){
                if(this.$refs['doc'].files[0]){
                    this.file_form.filename = this.$refs['doc'].files[0].name
                    this.file_form.doc = this.$refs['doc'].files[0]
                    this.$forceUpdate();
                }
            },
            deleteFile(id){
                let vm = this;

                Swal.fire({
                    title: 'Supprimer',
                    text: 'Etes-vous sur de vouloir supprimer?',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(`/api/documents/bordereaux/${id}?api_token=${this.api_token}`, { method: 'delete' })
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
                        toastr.error('Suppression terminée!')
                        vm.fetchFiles();
                    }
                })
            },
            UploadFile(){
                $('#modal-file-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeFileForm(){
                this.file_form = {
                    id: null,
                    name: '',
                    description: '',
                    uploaded_at: '',
                    doc: null,
                    filename: 'Sélecionnez un fichier'
                }
                this.$forceUpdate();
            },
            saveFile(){
                this.btnLoading = true
                let formData = new FormData()
                formData.append('document', this.file_form.doc)
                formData.append('name', this.file_form.name)
                formData.append('uploaded_at', this.file_form.uploaded_at)
                formData.append('description', this.file_form.description)

                fetch(`/api/documents/bordereaux?api_token=${this.api_token}`, {
                    method: 'post',
                    body: formData
                })
                    .then(res => res.json())
                    .then(res => {

                        this.btnLoading = false
                        $('#modal-file-form').modal('hide')
                        this.closeFileForm()
                        toastr.success('Document uploadé!')
                        this.fetchFiles()

                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur chargement du document!')
                    });
            }
        }

    }
</script>
