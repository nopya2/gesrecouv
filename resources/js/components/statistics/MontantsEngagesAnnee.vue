<template>
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Montants engagés par année</h3>

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
                <canvas id="montants-engages-annee" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
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

                let page_url = `/api/statistics/montants-engages-annee?api_token=${this.api_token}&year=${this.filter.year}`
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
                                    label               : 'Engagements',
                                    fill                : false,
                                    borderWidth         : 2,
                                    lineTension         : 0,
                                    spanGaps : true,
                                    borderColor         : '#0069D9',
                                    pointRadius         : 3,
                                    pointHoverRadius    : 7,
                                    pointColor          : '#0069D9',
                                    pointBackgroundColor: '#0069D9',
                                    data                : engagements
                                },
                                {
                                    label               : 'Payés',
                                    fill                : false,
                                    borderWidth         : 2,
                                    lineTension         : 0,
                                    spanGaps : true,
                                    borderColor         : '#009954',
                                    pointRadius         : 3,
                                    pointHoverRadius    : 7,
                                    pointColor          : '#009954',
                                    pointBackgroundColor: '#009954',
                                    data                : payes
                                },
                                {
                                    label               : 'Non Payés',
                                    fill                : false,
                                    borderWidth         : 2,
                                    lineTension         : 0,
                                    spanGaps : true,
                                    borderColor         : '#DC3545',
                                    pointRadius         : 3,
                                    pointHoverRadius    : 7,
                                    pointColor          : '#DC3545',
                                    pointBackgroundColor: '#DC3545',
                                    data                : non_payes
                                },
                            ]
                        }

                        var areaChartOptions = {
                            maintainAspectRatio : false,
                            responsive : true,
                            legend: {
                                display: true
                            },
                            scales: {
                                xAxes: [{
                                    gridLines : {
                                        display : true,
                                    }
                                }],
                                yAxes: [{
                                    gridLines : {
                                        display : true,
                                    }
                                }]
                            }
                        }

                        // -------------
                        // - LINE CHART -
                        // --------------
                        var lineChartCanvas = $('#montants-engages-annee').get(0).getContext('2d')
                        var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
                        var lineChartData = jQuery.extend(true, {}, areaChartData)
                        lineChartData.datasets[0].fill = false;
                        lineChartData.datasets[1].fill = false;
                        lineChartOptions.datasetFill = false

                        var lineChart = new Chart(lineChartCanvas, {
                            type: 'line',
                            data: lineChartData,
                            options: lineChartOptions
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
