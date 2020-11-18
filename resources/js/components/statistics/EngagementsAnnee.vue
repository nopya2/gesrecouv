<template>
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Engagements par année</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <!--<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <select class="form-control form-control-sm col-md-3" @change="fetchEngagementsAnnee" v-model="filter.year">
                    <option v-for="year in years" :value="year">{{year}}</option>
                </select>
            </div>
            <div class="chart">
                <canvas id="engagements-annee" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
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
                spinner: false
            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token
            }

            this.loadYears()
            this.fetchEngagementsAnnee()

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
            fetchEngagementsAnnee(){
                let vm = this;
                this.spinner = true;

                let page_url = `/api/statistics/engagements-annee?api_token=${this.api_token}&year=${this.filter.year}`
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.spinner = false
                        let labels = res.months
                        let engagements = res.engagements
                        let payes = res.payes
                        let non_payes = res.non_payes

                        var areaChartData = {
                            labels  : labels,
                            datasets: [
                                {
                                    label               : 'Total engages',
                                    backgroundColor     : '#0069D9',
                                    borderColor         : '#0069D9',
                                    pointRadius          : false,
                                    pointColor          : '#0069D9',
                                    pointStrokeColor    : '#0069D9',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: '#0069D9',
                                    data                : engagements
                                },
                                {
                                    label               : 'Total payes',
                                    backgroundColor     : '#009954',
                                    borderColor         : '#009954',
                                    pointRadius         : false,
                                    pointColor          : '#009954',
                                    pointStrokeColor    : '#009954',
                                    pointHighlightFill  : '#009954',
                                    pointHighlightStroke: '#009954',
                                    data                : payes
                                },
                                {
                                    label               : 'Total non payes',
                                    backgroundColor     : '#DC3545',
                                    borderColor         : '#DC3545',
                                    pointRadius         : false,
                                    pointColor          : '#DC3545',
                                    pointStrokeColor    : '#DC3545',
                                    pointHighlightFill  : '#DC3545',
                                    pointHighlightStroke: '#DC3545',
                                    data                : non_payes
                                },
                            ]
                        }

                        //-------------
                        //- BAR CHART -
                        //-------------
                        var barChartCanvas = $('#engagements-annee').get(0).getContext('2d')
                        var barChartData = jQuery.extend(true, {}, areaChartData)
                        var temp0 = areaChartData.datasets[0]
                        var temp1 = areaChartData.datasets[1]
                        barChartData.datasets[0] = temp1
                        barChartData.datasets[1] = temp0

                        var barChartOptions = {
                            responsive              : true,
                            maintainAspectRatio     : false,
                            datasetFill             : false
                        }

                        var barChart = new Chart(barChartCanvas, {
                            type: 'bar',
                            data: barChartData,
                            options: barChartOptions
                        })

                    })
                    .catch(error => {
                        toastr.error('Erreur chargement des données!.')
                        this.spinner = false
                    });
            }
        }

    }
</script>
