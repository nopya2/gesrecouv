<template>
    <div class="card-block table-border-style">
        <div class="row mb-3">
            <div class="col-md-3 offset-md-3">
                <div class="info-box mb-3 bg-info">
                    <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total montant engagé</span>
                        <span class="info-box-number">{{ amounts.engage|numFormat }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total montant payé</span>
                        <span class="info-box-number">{{ amounts.paye|numFormat }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box mb-3 bg-danger">
                    <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total montant non payé</span>
                        <span class="info-box-number">{{ amounts.non_paye|numFormat }}</span>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row mb-2">
            <div class="col-md-3">
                <button type="button" class="btn btn-success mr-1 mb-1" @click="openImportForm" v-if="importer">
                    <i class="fa fa-upload"></i> Importer engagements
                </button>
                <button class="btn btn-primary mr-1 mb-1" v-if="exporter">Export excel</button>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Exercice</label>
                            <select class="form-control" v-model="filter.exercice" @change="search">
                                <option value="">Tout</option>
                                <option v-for="(year, index) in years" v-bind:value="year">{{ year }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Mois</label>
                            <select class="form-control" v-model="filter.month" @change="search">
                                <option value="0">Tout</option>
                                <option v-for="month in months" :value="month.value" v-if="filter.exercice != ''">{{ month.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Nature de la dépense</label>
                            <select class="form-control" v-model="filter.nature" @change="search">
                                <option value="">Tout</option>
                                <option value="Fonctionnement">Fonctionnement</option>
                                <option value="Investissement">Investissement</option>
                                <!-- <option v-for="(nature, index) in natures" v-bind:value="nature.nat_dep">{{ nature.nat_dep }}</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tapez n° engagement</label>
                            <input type="text" class="form-control" placeholder="Tapez votre recherche" v-model="filter.keyword" v-on:keyup="search">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p>
                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Plus de filtres
                            </a>
                            <!-- <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Button with data-target
                            </button> -->
                        </p>
                        <div class="collapse" id="collapseExample">
                            <!-- <div class="card card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                            </div> -->
                            <div class="row">
                                <div class="col-md-3">
                                    <!-- <div class="form-group">
                                        <label>Fournisseur</label>
                                        <select class="form-control select2" v-model="filter.provider" @change="search" id="providers">
                                            <option value="">Tout</option>
                                            <option v-for="provider in providers" :value="provider.name">
                                                {{ provider.name }}
                                            </option>
                                        </select>
                                    </div> -->
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Fournisseurs</label><br>
                                        <select @change="search" id="providers" multiple="multiple">
                                            <!-- <option value="">Tout</option> -->
                                            <option v-for="provider in providers" :value="provider.name">
                                                {{ provider.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Statut</label>
                                        <select class="form-control" v-model="filter.status" @change="search">
                                            <option value="">Tout</option>
                                            <option value="non_paye">Non payé</option>
                                            <option value="paye">Payé</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Chapitre</label>
                                        <select class="form-control" v-model="filter.chapitre" @change="search">
                                            <option value="">Tous les chapitres</option>
                                            <option v-for="chapitre in chapitres" :value="chapitre.n_chap">{{ chapitre.n_chap }} - {{ chapitre.l_chap }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Effectivité</label>
                                        <select class="form-control" v-model="filter.realized" @change="search">
                                            <option value="">Tous</option>
                                            <option value="false">Inachevé</option>
                                            <option value="true">Achevé</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="enRetard" v-model="filter.is_late" @change="search">
                                            <label for="enRetard">
                                                En retard
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="reengagement" v-model="filter.reengagement" @change="search">
                                            <label for="reengagement">
                                                Réengagement
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-2">
                        <div class="form-group">
                            <label>Ordre montant engagé</label>
                            <select class="form-control form-control-sm" v-model="filter.order" @change="search">
                                <option value="">Aucun</option>
                                <option value="asc">Du plus petit au plus grand</option>
                                <option value="desc">Du plus grand au plus petit</option>
                            </select>
                        </div>
                    </div> -->
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
                    {{ pagination.total }} engagement(s)
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example1">
                    <thead>
                        <tr style="text-align: center;">
                            <th>#</th>
                            <th title="Exercice">{{ 'Exercice' | truncate(20) }}</th>
                            <th title="Imputation Budgétaire">{{ 'Imputation Budgétaire' | truncate(20) }}</th>
                            <th title="Nature Dépense">{{ 'Nature Dépense' | truncate(20) }}</th>
                            <th title="Libellé Imputation Budgétaire">{{ 'Libellé Imputation Budgétaire' | truncate(20) }}</th>
                            <!-- <th>m_dispo</th> -->
                            <!-- <th>m_toteng</th> -->
                            <!-- <th>m_tengvi</th> -->
                            <!-- <th>m_totliq</th> -->
                            <!-- <th>m_tordvi</th> -->
                            <!-- <th>m_totord</th> -->
                            <!-- <th>m_dotini</th> -->
                            <th title="N° enagement">{{ 'N° enagement' | truncate(20) }}</th>
                            <th title="Montant engagé">{{ 'Montant engagé' | truncate(20) }}</th>
                            <th title="Date de dépôt Agence Comptable ANINF">{{ 'Date de dépôt Agence Comptable ANINF' | truncate(20) }}</th>
                            <th title="Date de paiements">{{ 'Date paiement' | truncate(20) }}</th>
                            <th title="Montant payé">{{ 'Montant payé' | truncate(20) }}</th>
                            <th title="Dates d’engagement">{{ 'Dates d’engagement' | truncate(20) }}</th>
                            <!-- <th>mois_</th> -->
                            <!-- <th>m_tliqenga</th> -->
                            <th title="Montants non payé">{{ 'Montants non payé' | truncate(20) }}</th>
                            <th title="Libellé de la dépense">{{ 'Libellé dépense' | truncate(20) }}</th>
                            <th title="Fournisseurs">{{ 'Fournisseurs' | truncate(20) }}</th>
                            <th title="N° matricule">{{ 'N° matricule' | truncate(20) }}</th>
                            <th title="Code matricule">{{ 'Code matricule' | truncate(20) }}</th>
                            <th title="Chapitre">{{ 'Chapitre' | truncate(20) }}</th>
                            <th title="N° devis (factures)">{{ 'N° devis (factures)' | truncate(20) }}</th>
                            <!-- <th>nip</th> -->
                            <th>Réengagement</th>
                            <th>Date d'échéance</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px">
                        <tr>
                            <td colspan="20" v-if="engagements.length <= 0">
                                Aucun engagement trouvé
                            </td>
                        </tr>
                        <tr v-for="(engagement, index) in engagements" v-bind:key="engagement.id"
                            v-bind:class="{ 'text-success':  engagement.is_paid, 'text-danger': engagement.is_late}"
                            data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            <td>
                                <a v-bind:href="'/engagements/'+engagement.id">
                                    <button class="btn btn-sm btn-info" title="Visualiser">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </a>
                            </td>
                            <td>{{ engagement.d_exerci }}</td>
                            <td>{{ engagement.c_dest }}</td>
                            <td>{{ engagement.nat_dep }}</td>
                            <td data-toggle="tooltip" data-placement="top" :title="engagement.l_dep">{{ engagement.format_l_dep }}</td>
                            <!-- <td>{{ engagement.m_dispo|numFormat }}</td> -->
                            <!-- <td>{{ engagement.m_toteng|numFormat }}</td> -->
                            <!-- <td>{{ engagement.m_tengvi|numFormat }}</td> -->
                            <!-- <td>{{ engagement.m_totliq|numFormat }}</td> -->
                            <!-- <td>{{ engagement.m_tordvi|numFormat }}</td> -->
                            <!-- <td>{{ engagement.m_totord|numFormat }}</td> -->
                            <!-- <td>{{ engagement.m_dotini|numFormat }}</td> -->
                            <td>{{ engagement.n_engage }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ engagement.m_engage|numFormat }}</span>
                            </td>
                            <td>
                                <span v-if="engagement.date_depot_ac">{{ engagement.date_depot_ac | moment("DD/MM/YYYY")}}</span>
                                <span v-if="!engagement.date_depot_ac">N/A</span>
                            </td>
                            <td>
                                <span v-if="engagement.date_paiement">{{ engagement.date_paiement | moment("DD/MM/YYYY")}}</span>
                                <span v-if="!engagement.date_paiement">N/A</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning">{{ engagement.m_paye|numFormat }}</span>
                            </td>
                            <td>
                                <span v-if="engagement.d_engage">{{ engagement.d_engage | moment("DD/MM/YYYY")}}</span>
                                <span v-if="!engagement.d_engage">N/A</span>
                            </td>
                            <!-- <td>{{ engagement.mois_ }}</td> -->
                            <!-- <td>{{ engagement.m_tliqenga|numFormat }}</td> -->
                            <td>{{ engagement.m_non_paye|numFormat }}</td>
                            <td data-toggle="tooltip" data-placement="top" :title="engagement.l_depeng">{{ engagement.format_l_depeng }}</td>
                            <td>{{ engagement.l_nmtir }}</td>
                            <td>{{ engagement.n_mattir }}</td>
                            <td>{{ engagement.c_mattir }}</td>
                            <td>{{ engagement.l_chap }}</td>
                            <td>{{ engagement.n_devis }}</td>
                            <!-- <td>{{ engagement.nip }}</td> -->
                            <td>{{ engagement.desc_r_engage }}</td>
                            <td>
                                <span v-if="engagement.date_echeance">{{ engagement.date_echeance | moment("DD/MM/YYYY")}}</span>
                                <span v-if="!engagement.date_echeance">N/A</span>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                    <tr style="text-align: center;">
                        <th>#</th>
                        <th title="Exercice">{{ 'Exercice' | truncate(20) }}</th>
                        <th title="Imputation Budgétaire">{{ 'Imputation Budgétaire' | truncate(20) }}</th>
                        <th title="Nature Dépense">{{ 'Nature Dépense' | truncate(20) }}</th>
                        <th title="Libellé Imputation Budgétaire">{{ 'Libellé Imputation Budgétaire' | truncate(20) }}</th>
                        <!-- <th>m_dispo</th> -->
                        <!-- <th>m_toteng</th> -->
                        <!-- <th>m_tengvi</th> -->
                        <!-- <th>m_totliq</th> -->
                        <!-- <th>m_tordvi</th> -->
                        <!-- <th>m_totord</th> -->
                        <!-- <th>m_dotini</th> -->
                        <th title="N° enagement">{{ 'N° enagement' | truncate(20) }}</th>
                        <th title="Montant engagé">{{ 'Montant engagé' | truncate(20) }}</th>
                        <th title="Date de dépôt Agence Comptable ANINF">{{ 'Date de dépôt Agence Comptable ANINF' | truncate(20) }}</th>
                        <th title="Date de paiements">{{ 'Date paiement' | truncate(20) }}</th>
                        <th title="Montant payé">{{ 'Montant payé' | truncate(20) }}</th>
                        <th title="Dates d’engagement">{{ 'Dates d’engagement' | truncate(20) }}</th>
                        <!-- <th>mois_</th> -->
                        <!-- <th>m_tliqenga</th> -->
                        <th title="Montants non payé">{{ 'Montants non payé' | truncate(20) }}</th>
                        <th title="Libellé de la dépense">{{ 'Libellé dépense' | truncate(20) }}</th>
                        <th title="Fournisseurs">{{ 'Fournisseurs' | truncate(20) }}</th>
                        <th title="N° matricule">{{ 'N° matricule' | truncate(20) }}</th>
                        <th title="Code matricule">{{ 'Code matricule' | truncate(20) }}</th>
                        <th title="Chapitre">{{ 'Chapitre' | truncate(20) }}</th>
                        <th title="N° devis (factures)">{{ 'N° devis (factures)' | truncate(20) }}</th>
                        <!-- <th>nip</th> -->
                        <th>Réengagement</th>
                        <th>Date d'échéance</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a class="page-link" href="javascript:" tabindex="-1" @click="fetchEngagements(pagination.prev_page_url)">Précédent</a>
                    </li>
                    <li class="page-item disabled"><a class="page-link" href="javascript:">{{ pagination.current_page }}</a></li>
                    <!--<li class="page-item"><a class="page-link" href="#!">2</a></li>-->
                    <!--<li class="page-item"><a class="page-link" href="#!">3</a></li>-->
                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="javascript:" @click="fetchEngagements(pagination.next_page_url)">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Importer engagements</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeImport">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputFile">Fichier à importer</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" @change="uploadFile" ref="file">
                                    <label class="custom-file-label" for="exampleInputFile">{{ file.name }}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id=""><i class="fa fa-upload"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Exercice</label>
                            <select class="form-control" v-model="exercice">
                                <option v-for="(year, index) in years" v-bind:value="year">{{ year }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeImport">Annuler</button>
                        <button type="button" class="btn btn-primary" :disabled="file.size <= 0" @click="importFile" v-if="!btnLoading">Importer</button>
                        <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                            <span class="spinner-grow spinner-grow-sm" role="status"></span>
                            Traitement...
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
    export default {
        mounted() {
            let vm = this
            //Initialize Select2 Elements
            $('.select2').select2()

            $('.select2').on('select2:select', function (e) {
                var data = e.params.data;
                vm.filter.provider = data.id
                console.log(vm.filter.provider);
                vm.search()
            });

        },

        props : ['importer', 'exporter'],

        data(){
            return{
                engagements: [],
                chapitres: [],
                providers: [],
                selectedProviders: [],
                amounts: {
                  engage: 0,
                  paye: 0,
                  non_paye: 0
                },
                file: {
                    name: 'Sélectionnez un fichier',
                    size: 0
                },
                filter: {
                    keyword: '',
                    exercice: '',
                    is_late: false,
                    status: '',
                    order: '',
                    nature: '',
                    reengagement: false,
                    chapitre: '',
                    realized: '',
                    provider: '',
                    month: 0,
                    providers: []
                },
                spinner: false,
                api_token: '',
                pagination: {
                    current_page: 1,
                    total: 0
                },
                btnLoading: false,
                years: [],
                months: [{name: 'Janvier', value: 1}, {name: 'Février', value: 2}, {name: 'Mars', value: 3}, {name: 'Avril', value: 4}, {name: 'Mai', value: 5},
                        {name: 'Juin', value: 6}, {name: 'Juillet', value: 7}, {name: 'Aout', value: 8}, {name: 'Septembre', value: 9}, {name: 'Octobre', value: 10},
                        {name: 'Novembre', value: 11}, {name: 'Décembre', value: 1}, ],
                exercice: 0,
                natures: []

            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token

                this.loadYears()
                this.fetchNatures()
                this.fetchChapitres()
                this.fetchProviders()
            }

        },

        methods: {
            fetchEngagements(page) {
                let vm = this;
                this.spinner = true;
                vm.filter.providers = vm.selectedProviders

                let url_parameters = `api_token=${this.api_token}&keyword=${this.filter.keyword}&exercice=${this.filter.exercice}`
                    +`&late=${this.filter.is_late}&status=${this.filter.status}&order=${this.filter.order}`
                    +`&nature=${this.filter.nature}&reengagement=${this.filter.reengagement}&chapitre=${this.filter.chapitre}`
                    +`&realized=${this.filter.realized}&provider=${this.filter.provider}`
                    +`&month=${this.filter.month}`

                let page_url = `/api/engagements/search?${url_parameters}`
                if(page) page_url = `${page}&${url_parameters}`

                fetch(page_url, {
                        method: 'post',
                        body: JSON.stringify(this.filter),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {

                        this.amounts.engage = res.m_engage
                        this.amounts.paye = res.m_paye
                        this.amounts.non_paye = res.m_non_paye
                        this.spinner = false
                        this.engagements = res.resources.data
                        let meta = {
                            current_page: res.resources.current_page,
                            total: res.resources.total,
                            last_page: res.last_page,
                        }

                        let links = {
                            next: res.resources.next_page_url,
                            prev: res.resources.prev_page_url,
                        }
                        vm.makePagination(meta, links)
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinner = false
                    });
            },
            fetchNatures(){
                let url_parameters = `api_token=${this.api_token}`

                let page_url = `/api/nature-depense?${url_parameters}`

                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.natures = res.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
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
            fetchProviders(page_url) {
                let vm = this;

                page_url = page_url || `/api/providers?api_token=${this.api_token}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.providers = res.data
                        setTimeout(function(){
                            $('#providers').multiselect({
                                maxHeight: 400,
                                includeSelectAllOption: true,
                                // dropUp: true,
                                enableFiltering: true,
                                numberDisplayed: 1,
                                onChange: function(option, checked) {
                                    if(checked == true){
                                        vm.selectedProviders.push(option[0].value);
                                    }else{
                                        let index = vm.selectedProviders.indexOf(option[0].value);
                                        vm.selectedProviders.splice(index, 1)
                                    }
                                    // alert('onChange triggered ...');
                                    // console.log(vm.selectedProviders.length);
                                    vm.fetchEngagements()
                                },
                                onSelectAll: function(){
                                    vm.providers.forEach((item)=>{
                                        let indexT = vm.selectedProviders.indexOf(item.name)
                                        if(indexT == -1){
                                            vm.selectedProviders.push(item.name)
                                        }
                                    })
                                    vm.fetchEngagements()
                                },
                                onDeselectAll: function(){
                                    vm.selectedProviders = []
                                    vm.fetchEngagements()
                                }
                            });
                            vm.providers.forEach((item)=>{
                                let indexT = vm.selectedProviders.indexOf(item.name)
                                if(indexT == -1){
                                    vm.selectedProviders.push(item.name)
                                }
                            })
                            // $('#providers').multiselect('selectAll', true);
                            $('#providers').multiselect('select', vm.selectedProviders);
                            vm.$forceUpdate();

                            vm.fetchEngagements()
                        }, 500);

                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
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
            openImportForm(){
                $('#modal-default').modal({
                    show: true,
                    backdrop: 'static'
                })
            },
            search(){
                this.fetchEngagements();
            },
            uploadFile(event){
                this.file = event.target.files[0]
            },
            closeImport(){
                // this.file.name = 'Sélectionnez un fichier'
                // this.file.size = 0
            },
            importFile(){
                this.btnLoading = true
                let formData = new FormData()
                this.filter.exercice = this.exercice
                formData.append('file', this.file)
                formData.append('exercice', this.exercice)
                fetch(`/api/engagements/import?api_token=${this.api_token}`, {
                    method: 'post',
                    body: formData
                })
                    .then(res => res.json())
                    .then(res => {
                        this.btnLoading = false
                        $('#modal-default').modal('hide')
                        toastr.success('Engagements importés!.')
                        this.fetchEngagements()
                    })
                    .catch(error => {
                        this.btnLoading = false
                        toastr.error('Erreur import du fichier!.')
                        this.spinner = false
                    });
            },
            loadYears(){
                var dt = new Date();
                let start = parseInt(dt.getFullYear())
                // this.filter.exercice = parseInt(dt.getFullYear())
                this.exercice = parseInt(dt.getFullYear())
                for(var i=0; i <= parseInt(dt.getFullYear()); i++){
                    this.years[i] = start
                    start --
                    if(start < 2010) break
                }
            }
        }

    }
</script>
