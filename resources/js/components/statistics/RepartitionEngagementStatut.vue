<template>
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Engagements par statut</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <!--<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <select class="form-control form-control-sm col-md-3" @change="fetchData" v-model="filter.year">
                    <option v-for="year in years" :value="year">{{year}}</option>
                </select>
            </div>
            <div class="chart">
                <canvas id="engagements-par-statut-annee" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : [],
        mounted() {
        },
        data(){
            return{
                years: [],
                filter: {
                    year: ''
                },
                data: {
                    engagement_paye: 0,
                    engagement_non_paye: 0
                },
                spinner: false
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token
            }

            this.loadYears()
            this.fetchData()

        },

        methods: {
            loadYears(){
                var dt = new Date();
                let start = parseInt(dt.getFullYear())
                // this.filter.exercice = parseInt(dt.getFullYear())
                this.filter.year = parseInt(dt.getFullYear())
                for(var i=0; i <= parseInt(dt.getFullYear()); i++){
                    this.years[i] = start
                    start --
                    if(start < 2010) break
                }
            },
            fetchData(){
                $('#engagements-par-statut-annee').html()

                let vm = this;
                this.spinner = true;
                this.data = {}

                let page_url = `/api/statistics/engagements-statut-annee?api_token=${this.api_token}&year=${this.filter.year}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        this.data.engagement_paye = res.payes
                        this.data.engagement_non_paye = res.non_payes

                        var donutChartCanvas = $('#engagements-par-statut-annee').get(0).getContext('2d')
                        var donutData        = {
                            labels: [
                                'Engagement payé',
                                'Engagement non payé',
                            ],
                            datasets: [
                                {
                                    data: [ this.data.engagement_paye,this.data.engagement_non_paye],
                                    backgroundColor : ['#00a65a', '#f56954'],
                                }
                            ]
                        }
                        var donutOptions     = {
                            maintainAspectRatio : false,
                            responsive : true,
                        }
                        //Create pie or douhnut chart
                        // You can switch between pie and douhnut using the method below.
                        var donutChart = new Chart(donutChartCanvas, {
                            type: 'doughnut',
                            data: donutData,
                            options: donutOptions
                        })
                        donutChart.update()

                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinner = false
                    });
            }
        }

    }
</script>
