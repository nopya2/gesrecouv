<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3">
                            Information
                        </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item dropdown">
                                <a class="btn dropdown-toggle btn-info btn-sm" data-toggle="dropdown" href="#" aria-expanded="true">
                                Actions <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(-5px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
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
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Montant facturé</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ facture.montant|numFormat }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Montant payé</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ facture.m_paid|numFormat }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Reste à recouvrer</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ facture.m_not_paid|numFormat }}<span></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-muted">
                            <div class="col-md-4">
                                <p class="">Statut
                                    <b class="d-block">
                                        <span class="badge badge-dark" v-if="facture.statut == 'credit_note'">Avoir</span>
                                        <span class="badge badge-success" v-if="facture.statut == 'paid'">Payé</span>
                                        <span class="badge badge-warning" v-if="facture.state == 'waiting'">A valider</span>
                                        <span class="badge badge-info" v-if="facture.statut == 'in_progress' && facture.state != 'waiting'">En cours</span>
                                        <span class="badge badge-danger" v-if="facture.statut == 'cancelled'">Annulé</span>
                                        <span class="badge badge-danger" v-if="facture.statut == 'litigation'">Litige</span>
                                    </b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Client
                                    <b class="d-block" v-if="facture.client != null">
                                        <a :href="'/clients/'+facture.client.id" class="text-info">{{ facture.client.raison_sociale }}</a>
                                    </b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Facture parent
                                    <b class="d-block" v-if="facture.parent != null">{{ facture.parent.num_facture }}</b>
                                    <b class="d-block" v-if="facture.parent == null">N/A</b>
                                </p>
                            </div>
                        </div>
                        <div class="row text-muted">
                            <div class="col-md-4">
                                <p class="">Type de facture
                                    <b class="d-block" v-if="facture.type != null">{{ facture.type.libelle}}</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">N° Dossier
                                    <b class="d-block">{{ facture.num_dossier}}</b>
                                    <b class="d-block" v-if="facture.num_dossier == null">N/A</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Date de création
                                    <b class="d-block">{{ facture.date_creation | moment("DD/MM/YYYY") }}</b>
                                </p>
                            </div>
                        </div>
                        <div class="row text-muted">
                            <div class="col-md-4">
                                <p class="">Date de dépot
                                    <b class="d-block">{{ facture.date_depot | moment("DD/MM/YYYY") }}</b>
                                    <b class="d-block" v-if="facture.date_depot == null">N/A</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Date de paiement
                                    <b class="d-block">{{ facture.date_paiement | moment("DD/MM/YYYY") }}</b>
                                    <b class="d-block" v-if="facture.date_paiement == null">N/A</b>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="">Date d'échéance
                                    <b class="d-block">{{ facture.date_echeance | moment("DD/MM/YYYY") }}</b>
                                    <b class="d-block" v-if="facture.date_echeance == null">N/A</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title">Documents <span class="badge badge-dark">{{ documents.length }}</span></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" @click="showUploadForm()">
                                <i class="fas fa-upload mr-1"></i> Uploader document
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0 scrollable">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Titre du document</th>
                                    <th>Taille</th>
                                    <th>Date</th>
                                    <!-- <th></th> -->
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="documents.length <=0">
                                    <td colspan="5" class="text-center text-muted">Aucun document</td>
                                </tr>
                                <tr v-for="item in documents" :key="item.id">
                                    <td>
                                        <a :href="'/uploads/documents/'+item.filename" target="_blank" class="text-muted">
                                            {{item.filename}} <i class="fas fa-search-plus"></i>
                                        </a>
                                    </td>
                                    <td>{{item.size}}</td>
                                    <td>{{item.created_at|moment("DD/MM/YYYY")}}</td>
                                    <!-- <td></td> -->
                                    <td class="text-center">
                                        <!-- <button class="btn btn-primary btn-sm" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button> -->
                                        <button class="btn btn-danger btn-xs" type="button" @click="deleteDocument(item)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            
            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title">
                            Historique des paiements 
                            <span class="badge badge-dark">{{ paiements.length }}</span>
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success btn-sm" @click="showPaiementForm()" 
                                v-if="facture.m_not_paid > 0 && facture.state == 'validated' && facture.statut != 'credit_note'"><i class="fas fa-plus mr-1"></i> Ajouter</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0 scrollable">
                        <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap projects">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Montant</th>
                                    <th>Mode paiement</th>
                                    <th>Date paiement</th>
                                    <th>Pièces jointes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <table></table>
                                <tr v-if="paiements.length <=0" class="text-center">
                                    <td colspan="5" class="text-muted">Aucun paiement</td>
                                </tr>
                                <tr v-for="(item, index) in paiements" :key="index">
                                    <td class="vertical-align">
                                        <i class="fas fa-check text-success text-lg" v-show="item.state=='validated'"></i>
                                        <i class="fas fa-times text-danger text-lg" v-show="item.state=='cancelled'"></i>
                                        <div class="dropdown text-center" v-show="item.state=='waiting'">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" 
                                                type="button" id="dropdownMenuButton" 
                                                data-toggle="dropdown" 
                                                aria-haspopup="true" 
                                                aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item text-success text-sm" href="javascript:void(0);" 
                                                    @click="updateStatePaiement(item, 'validate')">
                                                    <i class="fas fa-check mr-1"></i> Valider
                                                </a>
                                                <a class="dropdown-item text-gray-dark text-sm" href="javascript:void(0);"
                                                    @click="updateStatePaiement(item, 'cancel')">
                                                    <i class="fas fa-times mr-1"></i> Annuler
                                                </a>
                                                <!-- <a class="dropdown-item text-danger text-sm" href="javascript:void(0);"
                                                    @click="deleteFacture(facture)">
                                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                                </a> -->
                                            </div>
                                        </div>
                                    </td>
                                    <td class="vertical-align">{{ item.montant }}</td>
                                    <td class="vertical-align">{{ item.mode_paiement }}</td>
                                    <td class="vertical-align">{{ item.date_paiement }}</td>
                                    <td class="vertical-align">
                                        <ul>
                                            <li v-for="(document, index) in item.documents" :key="index">
                                                <a :href="`/uploads/documents/${document.filename}`" target="_blank">Document {{index+1}}</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <relances-facture :facture_id="facture_id"></relances-facture>
                
                <div class="card card-gray" v-if="activities.length">
                    <div class="card-header">
                        <h3 class="card-title">
                            Activités
                            <span class="badge badge-dark">{{ activities.length }}</span>
                        </h3>
                        <!-- <div class="card-tools">
                            <button type="button" class="btn btn-success btn-sm" @click="showPaiementForm()" 
                                v-if="facture.m_not_paid > 0 && facture.state == 'validated' && facture.statut != 'credit_note'"><i class="fas fa-plus mr-1"></i> Ajouter</button>
                        </div> -->
                    </div>
                    <div class="card-footer card-comments scrollable">
                        <div class="card-comment" v-for="activity in activities" :key="activity.id">
                            <!-- User image -->
                            <!-- <img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image"> -->

                            <div class="comment-text">
                                <span class="username">
                                <!-- Maria Gonzales -->
                                <span class="text-muted float-right" >{{ formatDate(activity.updated_at) }}</span>
                                </span><!-- /.username -->
                                <span v-html="activity.description"></span>
                            </div>
                            <!-- /.comment-text -->
                        </div>
                        <!-- /.card-comment -->
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="modal-paiement-form">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter un paiement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="libelle">Montant</label>
                                        <input type="number" class="form-control" v-model="$v.paiement.montant.$model">
                                        <small class="form-text text-danger" v-if="!$v.paiement.montant.required">Champs requis.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="libelle">Mode de paiement</label>
                                        <select class="form-control" v-model="$v.paiement.mode_paiement.$model">
                                            <option v-for="(item, index) in modes_paiement" :value="item.libelle" :key="index">{{ item.libelle }}</option>
                                            <small class="form-text text-danger" v-if="!$v.paiement.mode_paiement.required">Champs requis.</small>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="date_paiement">Date de paiement</label><br>
                                <date-picker
                                    v-model="$v.paiement.date_paiement.$model"
                                    value-type="format"
                                    format="YYYY-MM-DD"
                                    type="date"
                                    placeholder="Selectionnez une date"></date-picker>
                                <small class="form-text text-danger" v-if="!$v.paiement.date_paiement.required">Champs requis.</small>
                            </div>

                            <div class="form-group">
                                <label>Pièces jointes</label>
                                <div class="row mt-1" v-for="(document, index) in documentsPaiementForm" :key="index">
                                    <div class="col-md-11">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" :ref="'file'+index" @change="handleFileUpload(document, index)">
                                            <label class="custom-file-label" for="customFile">{{ document.name }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1" v-if="documentsPaiementForm.length > 1">
                                        <button type="button" class="btn btn-outline-danger btn-xs" @click="removeDocument(document)">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-xs" @click="addDocument" v-if="documents.length <= 5">
                                    Ajouter une pièce jointe
                                </button>
                            </div>

                            <div class="form-group">
                                <label for="commentaire">Commentaire</label>
                                <textarea class="form-control" id="commentaire" placeholder="Entrez un commentaire" v-model="$v.paiement.commentaire.$model"></textarea>
                                <small class="form-text text-danger" v-if="!$v.paiement.commentaire.required">Champs requis.</small>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal" @click="closePaiementForm">Annuler</button>
                        <button type="button" class="btn btn-success" :disabled="$v.paiement.$invalid" @click="savePaiement(paiement)" v-if="!btnLoading">Enregistrer</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-upload-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Uploader un document</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">

                            <div class="form-group">
                                <label>Pièces jointes</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" :ref="'upload'" @change="handleFileUpload(document, null)">
                                    <label class="custom-file-label" for="customFile">{{ document.name }}</label>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
                        <button type="button"
                            class="btn btn-success"
                            @click="uploadDocument()"
                            :disabled="document.size<=0"
                            v-if="!btnUploadForm">
                            <i class="fas fa-upload"></i> Uploader
                        </button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnUploadForm">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Upload du document en cours...
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Facture from './../../models/facture'
    import Paiement from './../../models/paiement'
    import FactureService from './../../services/factures'
    import ModePaiementService from './../../services/mode-paiement'
    import PaiementService from './../../services/paiement'
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import { required, minLength, maxLength, between, email, sameAs } from 'vuelidate/lib/validators';
    import RelancesFactures from './RelancesFacture'
    import RelancesFacture from './RelancesFacture.vue'

    export default {
  components: { RelancesFacture },

        props : ['facture_id'],
        mounted(){
            let vm = this
            $('#modal-paiement-form').on('hidden.bs.modal', function (e) {
                vm.paiement = new Paiement();
                vm.documentsPaiementForm = [];
            })
            $('#modal-paiement-form').on('show.bs.modal', function (e) {
                vm.paiement.montant = vm.facture.m_not_paid
                vm.addDocument()
            })
            $('#modal-upload-form').on('hidden.bs.modal', function (e) {
                vm.document = {
                    name: "Sélectionnez un fichier",
                    size: 0
                }
            })
        },
        data(){
            return{
                facture: new Facture(),
                paiements: [],
                paiement: new Paiement(),
                modes_paiement: [],
                documentsPaiementForm: [],
                documents: [],
                activities: [],
                document: {
                    name: "Sélectionnez un fichier",
                    size: 0
                },
                btnLoading: false,
                btnUploadForm: false
            }
        },
        validations: {
            paiement: {
                montant: {
                    required
                },
                mode_paiement: {
                    required
                },
                date_paiement: {
                    required
                },
                commentaire: {
                    required
                }
            }
        },
        created(){

            this.fetchFacture()
            this.fetchModes()
            // this.addDocument()

        },

        methods: {

            fetchFacture(){
                let vm = this

                FactureService.getFacture(this.facture_id)
                    .then(res => res.json())
                    .then(res => {
                        vm.facture = res.data
                        vm.paiements = vm.facture.paiements
                        vm.activities = vm.facture.activities
                        vm.documents = vm.facture.documents

                    })
                    .catch(error => {
                        toastr.error('Erreur chargement de la facture!')
                    });
            },
            fetchModes() {
                let vm = this;

                ModePaiementService.getModes('')
                    .then(res => res.json())
                    .then(res => {
                        vm.modes_paiement = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des modes de paiement!')
                    });
            },
            showPaiementForm(){
                $('#modal-paiement-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closePaiementForm(){
                $('#modal-paiement-form').modal('hide')
            },
            savePaiement(paiement){
                let vm = this
                paiement.facture_id = this.facture.id
                paiement.facture = this.facture
                vm.btnLoading = true
                let formData = new FormData()
                formData.append('mode_paiement', paiement.mode_paiement)
                formData.append('date_paiement', paiement.date_paiement)
                formData.append('commentaire', paiement.commentaire)
                formData.append('facture_id', paiement.facture_id)
                formData.append('montant', paiement.montant)
                if(vm.documentsPaiementForm[0].size > 0){
                    $.each(vm.documentsPaiementForm, function(key, document){
                        if(document.size > 0) formData.append(`documents[${key}]`, document)
                    });
                }

                PaiementService.createPaiement(formData)
                    .then(res => res.json())
                    .then(res => {

                        vm.btnLoading = false
                        vm.closePaiementForm()
                        toastr.success('Paiement ajouté!')
                        this.fetchFacture()
                        this.$forceUpdate();

                    })
                    .catch(error => {
                        vm.btnLoading = false
                        toastr.error("Erreur enregistrement du paiement!")
                    });
            },
            addDocument(){
                this.documentsPaiementForm.push(new File([""], "Veuillez sélectionnez un fichier"))
            },
            removeDocument(document){
                // this.documents.splice(index, 1)
                let index = this.documentsPaiementForm.findIndex(x => x.name === document.name)
                this.documentsPaiementForm.splice(index, 1);
                this.$forceUpdate();
            },
            handleFileUpload(document, index){
                if(index !== null){
                    if(this.$refs['file'+index][0].files[0]){
                        this.documentsPaiementForm[index] = this.$refs['file'+index][0].files[0];
                        this.$forceUpdate();
                    }
                }else{
                    if(this.$refs['upload'].files[0]){
                        this.document = this.$refs['upload'].files[0]
                        this.$forceUpdate();
                    }
                }
                
            },
            formatDate(date){
                let text = ""
                let formatDate = moment(date).format('YYYY-MM-DD hh:mm:ss');
                let value = moment(date).startOf('hour').fromNow()
                    return value;  

                if(now == value) {
                    return text = moment(date).calendar()
                }
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
                        window.location = "/factures"
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
                        // let value = result.value.data.data
                        // vm.facture = {...value}
                        this.fetchFacture()
                        this.$forceUpdate();
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
                        // let value = result.value.data.data
                        // vm.facture = {...value}
                        this.fetchFacture()
                        this.$forceUpdate();
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
                        // let value = result.value.data.data
                        // vm.facture = {...value}
                        this.fetchFacture()
                        this.$forceUpdate();
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
                        // let value = result.value.data.data
                        // vm.facture = {...value}
                        this.fetchFacture()
                        this.$forceUpdate();
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
            showUploadForm(){
                $('#modal-upload-form').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeUploadForm(){
                $('#modal-upload-form').modal('hide')
            },
            uploadDocument(){
                let vm = this
                vm.btnUploadForm = true
                let formData = new FormData()
                formData.append('facture_id', vm.facture.id)
                formData.append('document', vm.document)

                axios.post(`/api/factures/${vm.facture.id}/add-document`, formData, {headers: {'Content-Type': 'multipart/form-data' }})
                    .then(res => {
                        vm.btnUploadForm = false
                        vm.fetchFacture()
                        vm.closeUploadForm()
                        toastr.success('Document uploadé!')
                    })
                    .catch(error => {
                        vm.btnUploadForm = false
                        toastr.error("Erreur enregistrement upload du fichier!")
                    });
            },
            deleteDocument(document){
                let vm = this;

                Swal.fire({
                    title: 'Suppression document',
                    text: 'Voulez-vous supprimer ce document?',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    confirmButtonColor: '#C82333',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.delete(`/api/factures/${vm.facture.id}/remove-document?id=${document.id}`)
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
                        toastr.warning('Document supprimé!')
                        vm.fetchFacture()
                    }
                })
            },
            updateStatePaiement(paiement, action){
                let vm = this
                let title = ''
                let text = ''
                let btnConfirm = ''
                let colorBtnConfirm = ''
                if(action == 'validate') {
                    title = 'Validation du paiment'
                    text = 'Etes-vous sur de vouloir valider ce paiement?'
                    colorBtnConfirm = '#28a745'
                }
                if(action == 'cancel') {
                    title = 'Annulation du paiment'
                    text = 'Etes-vous sur de vouloir annuler ce paiement?'
                    colorBtnConfirm = '#C82333'
                } 

                Swal.fire({
                    title: title,
                    text: text,
                    showCancelButton: true,
                    confirmButtonText: 'Confirmer',
                    confirmButtonColor: colorBtnConfirm,
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return axios.patch(`/api/paiements/${paiement.id}/update-state?action=${action}`, paiement)
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
                        this.fetchFacture()
                        this.$forceUpdate()
                        if(action == 'validate')
                            toastr.success('Paiement validé!')
                        if(action == 'cancel')
                            toastr.error('Paiement annulé!')
                    }
                })
            }
        }

    }
</script>

<style scoped>
    .scrollable{
        overflow-y: auto; 
        max-height: 300px;
        min-height: 150px;
    }
</style>