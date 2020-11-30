<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-flag text-danger"></i>
                            {{ client.raison_sociale }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted text-lg">Somme due {{ client.m_not_paid|numFormat }} Fcfa</p>
                        <div class="row">
                            <div class="col-md-4 pr-0">
                                <div class="alert alert-warning" role="alert">
                                    <h5 style="color: white">En retard</h5>
                                </div>
                            </div>
                            <div class="col-md-4 pl-0">
                                <div class="alert alert-primary" role="alert">
                                    <h5>A venir</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alert alert-primary" role="alert">
                                    <h5>Payé</h5>
                                </div>
                            </div>
                        </div>
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

        props : ['client_id'],

        data(){
            return{
                client: new Client(),
            }
        },
        created(){
            this.fetchClient()
        },

        methods: {
            fetchClient(){
                let vm = this;

                axios.get(`/api/clients/${this.client_id}`)
                    .then(res => {
                        vm.client = res.data.data
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement du client!')
                    });
            }
        }

    }
</script>
