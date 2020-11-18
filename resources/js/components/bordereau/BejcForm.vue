<template>
    <div>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <label>Nature</label>
                    <select class="form-control" v-model="$v.slip.nature.$model" @change="fetchChapitres()">
                        <option value="">Sélectionnez une nature</option>
                        <option value="Fonctionnement">Fonctionnement</option>
                        <option value="Investissement">Investissement</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Chapitre</label>
                    <select class="form-control" v-model="$v.slip.chapitre.$model">
                        <option value="">Sélectionnez un chapitre</option>
                        <option v-for="item in chapitres" :value="item.id">{{ item.n_chap }} - {{ item.l_chap }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group mt-4">
                <button type="button" class="btn btn-primary" @click="openModal">
                    <i class="fas fa-plus mr-1"></i> Ajouter Ordonnance
                </button>
            </div>
            <div class="row">
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
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="slip.items.length <= 0">
                            <td colspan="9" class="text-center">
                                Aucun engagment sélectionné
                            </td>
                        </tr>
                        <tr v-for="(item, index) in slip.items">
                            <td>{{ index + 1}}</td>
                            <td>{{ item.n_engage }}</td>
                            <td>{{ item.c_dest }}</td>
                            <td>{{ item.m_engage }}</td>
                            <td>{{ item.num_ordonnance }}</td>
                            <td>{{ item.l_nmtir }}</td>
                            <td>{{ item.l_dep }}</td>
                            <td>{{ item.montant_ordonnance }}</td>
                            <td>
                                <button class="btn btn-danger btn-xs" type="button" @click="removeItem(index)">Retirer</button>
                            </td>
                        </tr>
                        <tr v-if="slip.items.length > 0">
                            <td></td>
                            <td colspan="2">Nombre total d'ordonnances: <span>{{ slip.items.length }}</span></td>
                            <td></td>
                            <td colspan="3"></td>
                            <td>{{ slip.amount }}</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group float-right">
                <button type="button" class="btn btn-success" :disabled="$v.slip.$invalid || slip.items.length <= 0" @click="saveSlip" v-if="!btnLoading">
                    <i class="fas fa-save mr-1"></i>Enregistrer
                </button>
                <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                    <span class="spinner-grow spinner-grow-sm" role="status"></span>
                    Impression en cours...
                </button>
            </div>
        </form>



        <!-- Modal Selection des engagements et saisie des informations d'ordonnace -->
        <div class="modal fade" id="modal-select-engagement">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Sélection de l'engagement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>N° engagement</label>
                                    <input type="text" class="form-control" placeholder="Enter ..."
                                           v-model="$v.item_form.n_engagement.$model" v-on:input="editItem()" v-on:blur="handleBlur"
                                           v-on:focus="editItem()">
                                    <ul class="suggestions" v-if="visible">
                                        <li class="none-suggestion" v-if="engagements.length <= 0">Aucune suggestion</li>
                                        <li class="suggestion" v-for="item in engagements" @click="selectItem(item)">{{ item.n_engage }}</li>
                                    </ul>
                                    <div>
                                        <small>Saissisez les premiers caractères</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>N° ordonnance</label>
                                    <input type="text" class="form-control" v-model="$v.item_form.num_ordonnance.$model"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Montant ordonnancé</label>
                                    <input type="number" class="form-control" v-model="$v.item_form.montant_ordonnance.$model"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date dépot AC</label>
                                    <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask ref="date_depot_ac">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pièces jointes</label>
                            <div class="row mt-1" v-for="(document, index) in item_form.documents" :key="index">
                                <div class="col-md-11">
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="customFile" :ref="'file'+index" @change="handleFileUpload(document, index)">
                                      <label class="custom-file-label" for="customFile">{{ document.name }}</label>
                                    </div>
                                </div>
                                <div class="col-md-1" v-if="item_form.documents.length > 1">
                                    <button class="btn btn-outline-danger btn-xs" @click="removeDocument(document)">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-outline-success btn-xs" @click="addDocument" v-if="item_form.documents.length <= 5">
                                Ajouter une pièce jointe
                            </button>
                        </div>
                        <div class="form-group">
                            <label>Commentaire</label>
                            <textarea rows="4" class="form-control" name="comment" v-model.trim="$v.item_form.comment.$model"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success float-right" :disabled="$v.item_form.$invalid" @click="addItem">
                            <i class="fas fa-check mr-1"></i> Ajouter
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Modal Selection des engagements et saisie des informations d'ordonnace -->
    </div>

</template>

<script>
    import { required, minLength, maxLength, between, email, sameAs, maxValue } from 'vuelidate/lib/validators';

    export default {
        mounted() {
            $('[data-mask]').inputmask()
        },

        data(){
            return{
                slip: {
                    // id: null,
                    nature: '',
                    chapitre: '',
                    items: [],
                    amount: 0
                },
                item_form: {
                    n_engagement: '',
                    num_ordonnance: '',
                    montant_ordonnance: 0,
                    engagement: null,
                    date_depot_ac: null,
                    documents: [],
                    comment: ''

                },
                item: {},
                visible: false,
                engagements: [],
                chapitres: [],
                api_token: '',
                btnLoading: false,
                file: {},
                doc: {},
            }
        },
        validations: {
            slip: {
                nature: {
                    required
                },
                chapitre: {
                    required
                }
            },
            item_form: {
                n_engagement: {
                    // required,
                    // minLength: minLength(16)
                },
                num_ordonnance: {
                    // required,
                },
                montant_ordonnance: {
                    // required
                },
                comment: {
                    // required
                },
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token
                this.fetchChapitres()
                this.addDocument()
            }

        },

        methods: {
            fecthEngagements(){
                let url_parameters = `api_token=${this.api_token}&keyword=${this.item_form.n_engagement}&nature=${this.slip.nature}`
                let page_url = `/api/engagements/ajax/input-fields?${url_parameters}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.engagements = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                    });

            },
            fetchChapitres(){
                let url_parameters = `api_token=${this.api_token}&nature=${this.slip.nature}`
                let page_url = `/api/parametres/chapitres?${url_parameters}`

                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.chapitres = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                    });
            },
            openModal(){
                $('#modal-select-engagement').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            closeModal(){
                this.item_form = {
                    n_engagement: '',
                    num_ordonnance: '',
                    montant_ordonnance: 0,
                    engagement: null,
                    documents: [],
                    comment: ''

                }
                this.$refs.date_depot_ac.value = ''
                this.item = {}
                this.addDocument()
                $('#modal-select-engagement').modal('hide')
            },
            saveSlip(){
                let vm = this
                this.btnLoading = true
                // this.echelon.date_depot_ac =  this.$refs.date_depot_ac.value;

                fetch(`/api/bordereau/bejcs?api_token=${this.api_token}`, {
                    method: 'post',
                    body: JSON.stringify(this.slip),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(res => {

                        let echelons = res.echelons
                        vm.slip.items.forEach(item =>{
                            if(item.documents[0].size > 0){
                                let index = vm.slip.items.findIndex(x => x.num_ordonnance === item.num_ordonnance)
                                //Ensuite on upload les documents pour cette facture
                                let formData = new FormData()
                                $.each(item.documents, function(key, document){
                                    if(document.size > 0) formData.append(`documents[${key}]`, document)
                                });
                                formData.append('echelon', echelons[index].id)

                                fetch(`/api/echelon/upload-files?api_token=${this.api_token}`, {
                                    method: 'post',
                                    body: formData
                                })
                                    .then(res => res.json())
                                    .then(res => {

                                    })
                                    .catch(error => {
                                        toastr.error('Erreur upload de fichiers!.')
                                    });
                            }else{
                            }
                        })

                        this.btnLoading = false
                        toastr.success('Bordereau créé!')
                        window.open(`/bordereau/bejcs/pdf/${res.bejc.id}`)
                        window.location = '/bordereau/bejcs'
                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur Enregistrement du bordereau!')
                    });
            },
            editItem(){
                this.visible = true
                this.fecthEngagements()
            },
            selectItem(el){
                this.item_form.n_engagement = el.n_engage
                this.item = {...el}
            },
            handleBlur(){
                let vm = this
                setTimeout(function () {
                    vm.visible = false;
                }, 200)
            },
            addItem(){
                this.item.num_ordonnance = this.item_form.num_ordonnance
                this.item.montant_ordonnance = this.item_form.montant_ordonnance
                this.item.documents = this.item_form.documents
                this.item.date_depot_ac = this.$refs.date_depot_ac.value
                this.item.comment = this.item_form.comment
                this.slip.items.push(this.item)
                this.closeModal()
                this.calAmount()
            },
            removeItem(index){
                this.slip.items.splice(index, 1)
                this.calAmount()
            },
            calAmount(){
                let vm = this
                vm.slip.amount = 0
                this.slip.items.forEach(el => {
                    vm.slip.amount += parseInt(el.montant_ordonnance)
                })
            },
            addDocument(){
                this.item_form.documents.push(new File([""], "Veuillez sélectionnez un fichier"))
            },
            removeDocument(document){
                // this.documents.splice(index, 1)
                let index = this.item_form.documents.findIndex(x => x.name === document.name)
                this.item_form.documents.splice(index, 1);
                this.$forceUpdate();
            },
            handleFileUpload(document, index){
                if(this.$refs['file'+index][0].files[0]){
                    this.item_form.documents[index] = this.$refs['file'+index][0].files[0];
                    this.$forceUpdate();
                }
            },

        }

    }
</script>
