<template>
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title">
                Situation du compte
            </h3>
            <div class="card-tools">
                <div class="btn-group">
                    <button 
                        v-bind:class="[{disabled: !pagination.prev_page_url}]"
                        type="button" class="btn btn-sm btn-info"
                        @click="getALlFactures(pagination.prev_page_url)"
                        :disabled="!pagination.prev_page_url">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button
                        v-bind:class="[{disabled: !pagination.next_page_url}]" 
                        type="button" class="btn btn-sm btn-info"
                        @click="getALlFactures(pagination.next_page_url)"
                        :disabled="!pagination.next_page_url">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="d-flex justify-content-center mb-3" v-if="spinner">
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date d'écriture</th>
                        <th>N° Pièce</th>
                        <th>Mode de règlement</th>
                        <th>Date d'échéance</th>
                        <th></th>
                        <th>Débit</th>
                        <th>Crédit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(facture, index) in factures" :key="index">
                        <td class="text-center">{{ facture.date_creation|moment('DD/MM/YYYY') }}</td>
                        <td>{{ facture.num_facture }}</td>
                        <td>Mode de règlement</td>
                        <td class="text-center">{{ facture.date_echeance|moment('DD/MM/YYYY') }}</td>
                        <td class="text-center">
                            <span class="badge right text-sm" :class="[{'badge-danger': calculateNumberOfDays(facture) <0 }]">
                                {{calculateNumberOfDays(facture)}}
                            </span>
                        </td>
                        <th>Débit</th>
                        <th>Crédit</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    
    
</template>

<script>
import differenceInDays from 'date-fns/differenceInDays'
import parseISO from 'date-fns/parseISO'

    export default {
        props : ['client_id'],

        data(){
            return{
                factures: [],
                pagination: {
                    current_page: 1,
                    total: 0
                },
                spinner: true,
            }
        },
        created(){
            this.getALlFactures()
        },

        methods: {
            getALlFactures(page){
                let vm = this

                let page_url = `/api/clients/${this.client_id}/factures-client`
                if(page) page_url = page
                
                axios.get(page_url)
                    .then(res => {
                        vm.factures = res.data.data
                        vm.makePagination(res.data.meta, res.data.links)
                        this.spinner = false
                        
                    })
                    .catch(error => {
                        toastr.error('Erreur chargement du client!')
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
            calculateNumberOfDays(facture){
                let $days = differenceInDays(parseISO(facture.date_echeance), Date.now());
                return $days
            }
        }

    }
</script>

<style scoped>
</style>
