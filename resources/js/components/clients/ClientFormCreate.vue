<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Formulaire de création</h3>
                    </div>
                    <div class="card-body">
                        <form role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="raison_sociale">Raison sociale</label>
                                        <input type="text" class="form-control" placeholder="Entrez la raion sociale" 
                                            v-model.trim="$v.client.raison_sociale.$model" name="raison_sociale"
                                            autocomplete="off">
                                        <small class="form-text text-danger" v-if="!$v.client.raison_sociale.required">Champs requis.</small>
                                        <small class="form-text text-danger" v-if="!$v.client.raison_sociale.minLength">{{$v.client.raison_sociale.$params.minLength.min}} caractères minimum.</small>
                                        <small class="form-text text-danger" v-if="!$v.client.raison_sociale.maxLength">{{$v.client.raison_sociale.$params.maxLength.max}} caractères maximum.</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nif">NIF</label>
                                        <input type="text" class="form-control" placeholder="Entrez le NIF" 
                                            v-model.trim="$v.client.nif.$model" name="nif"
                                            autocomplete="off">
                                        <small class="form-text text-danger" v-if="!$v.client.nif.required">Champs requis.</small>
                                        <small class="form-text text-danger" v-if="!$v.client.nif.minLength">{{$v.client.nif.$params.minLength.min}} caractères minimum.</small>
                                        <small class="form-text text-danger" v-if="!$v.client.nif.maxLength">{{$v.client.nif.$params.maxLength.max}} caractères maximum.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ville">Secteur d'activités</label>
                                        <select class="form-control" v-model="$v.client.secteur_id.$model" name="secteur_id">
                                            <option v-for="(secteur, index) in secteurs" :key="index" :value="secteur.id">{{ secteur.name }}</option>
                                        </select>
                                        <small class="form-text text-danger" v-if="!$v.client.secteur_id.required">Champs requis.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="bp">Boite postale</label>
                                        <input type="text" class="form-control" placeholder="Entrez la boite postale" 
                                            v-model.trim="$v.client.bp.$model" name="bp"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="adresses">Adresse</label>
                                        <textarea class="form-control" placeholder="Entrez l'adresse" 
                                            v-model="$v.client.adresse.$model" name="adresse"
                                            autocomplete="off"></textarea>
                                        <small class="form-text text-danger" v-if="!$v.client.adresse.required">Champs requis.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ville">Ville</label>
                                        <select class="form-control" v-model="$v.client.ville.$model" name="ville">
                                            <option v-for="item in villes" :key="item" :value="item">{{ item }}</option>
                                        </select>
                                        <small class="form-text text-danger" v-if="!$v.client.ville.required">Champs requis.</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="pays">Pays</label>
                                        <select class="form-control" v-model="$v.client.pays.$model" name="pays">
                                            <option v-for="item in pays" :key="item">{{ item }}</option>
                                        </select>
                                        <small class="form-text text-danger" v-if="!$v.client.pays.required">Champs requis.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tel">Téléphone de l'entreprise</label>
                                        <input type="text" class="form-control" placeholder="Entrez le téléphone de l'entreprise"
                                            v-model="$v.client.tel.$model" name="tel"
                                            autocomplete="off">
                                        <small class="form-text text-danger" v-if="!$v.client.tel.required">Champs requis.</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="responsable">Responsable/Référend</label>
                                        <input type="text" class="form-control" placeholder="Identité de la ressource" 
                                            v-model="$v.client.responsable.$model" name="responsable"
                                            autocomplete="off">
                                        <small class="form-text text-danger" v-if="!$v.client.responsable.required">Champs requis.</small>
                                        <small class="form-text text-danger" v-if="!$v.client.responsable.minLength">{{$v.client.responsable.$params.minLength.min}} caractères minimum.</small>
                                        <small class="form-text text-danger" v-if="!$v.client.responsable.maxLength">{{$v.client.responsable.$params.maxLength.max}} caractères maximum.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label form="tel_responsable">Téléphone responsable</label>
                                        <input type="text" class="form-control" placeholder="Tapez le numéro de téléphone" 
                                            v-model="$v.client.tel_responsable.$model" name="tel_responsable"
                                            autocomplete="off">
                                        <small class="form-text text-danger" v-if="!$v.client.tel_responsable.required">Champs requis.</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" placeholder="Tapez l'e-mail" 
                                            v-model="$v.client.email.$model" name="email"
                                            autocomplete="off">
                                        <small class="form-text text-danger" v-if="!$v.client.email.required">Champs requis.</small>
                                        <small class="form-text text-danger" v-if="!$v.client.email.email">E-mail invalide.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col">
                                    <button class="btn btn-success" :disabled="$v.client.$invalid" type="button" @click="create()" v-if="!btnLoading">
                                        <i class="fas fa-save mr-1"></i>Créer
                                    </button>
                                    <a :href="'/clients'" v-if="!btnLoading">
                                        <button class="btn btn-danger" type="button">
                                            <i class="fas fa-times mr-1"></i>Annuler
                                        </button>
                                    </a>
                                    <button class="btn btn-primary shadow-2" type="button" disabled="" v-if="btnLoading">
                                        <span class="spinner-grow spinner-grow-sm" role="status"></span>
                                        Création en cours...
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Client from './../../models/client'
    import { required, minLength, maxLength, between, email, sameAs } from 'vuelidate/lib/validators';

    export default {

        props : [],

        data(){
            return{
                client: new Client(),
                villes: [],
                pays: [],
                secteurs: [],
                filter: {
                    keyword: '',
                },
                btnLoading: false,
                api_token: ''
            }
        },
        validations: {
            client: {
                raison_sociale: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(100),
                },
                nif: {
                    required,
                    minLength: minLength(1),
                    maxLength: maxLength(50),
                },
                secteur_id: {
                    required
                },
                bp: {
                },
                adresse: {
                    required
                },
                ville: {
                    required
                },
                pays: {
                    required
                },
                tel: {
                    required
                },
                responsable: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(100),
                },
                tel_responsable: {
                    required
                },
                email: {
                    email,
                    required
                },
            }
        },
        created(){

            this.fetchVilles()
            this.fetchPays()
            this.fetchSecteurs()

        },

        methods: {
            fetchVilles(){
                fetch('/api/resources/villes')
                    .then(res => res.json())
                    .then(res => {
                        this.villes = res.villes
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des villes!')
                    });
            },
            fetchPays(){
                fetch('/api/resources/pays')
                    .then(res => res.json())
                    .then(res => {
                        this.pays = res.pays
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des pays!')
                    });
            },
            fetchSecteurs(){
                let vm = this
                axios.get('/api/secteurs-activites?limit=100')
                    .then(res => {
                        vm.secteurs = res.data.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des secteurs!')
                    })
            },
            create(){
                let vm = this;
                vm.btnLoading = true

                axios.post(`/api/clients`, this.client)
                    .then(res => {
                        console.log(res)
                        vm.btnLoading = false
                        vm.client = new Client()
                        toastr.success('Client créé!')
                        window.location = `/clients/${res.data.data.id}`
                    })
                    .catch(error => {
                        vm.btnLoading = false
                        toastr.error('Erreur création du client!.')
                    });

            },
        }

    }
</script>
