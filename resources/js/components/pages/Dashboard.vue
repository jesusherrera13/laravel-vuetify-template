<template>
    <v-container>
        <v-row no-gutters>
            <v-col
            cols="12"
            >
            <h3>Dashboard</h3>
        </v-col>
        </v-row>
      <v-row no-gutters>
        <v-col
          cols="12"
          sm="6"
        >
          <v-sheet class="ma-2 pa-2">
            
            <Bar
              id="my-chart-id"
              :options="chartOptions"
              :data="chartData"
            />
          </v-sheet>
        </v-col>
        <v-col
          cols="12"
          sm="6"
        >
          <v-sheet class="ma-2 pa-2">
            <Pie :data="chartUpdte" :options="pieOptions" />
          </v-sheet>
        </v-col>
      </v-row>
    </v-container>
  </template>

<script>

import store from '../../store';
import { computed } from 'vue';
import axiosClient from '../../axios';
import Overlay from '../Overlay.vue';

import {
  Chart as ChartJS,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'
import { Bar, Pie } from 'vue-chartjs'
ChartJS.register(CategoryScale, LinearScale, BarElement, ArcElement, Title, Tooltip, Legend)

export default {
  name: 'BarChart',
  components: { Bar, Pie },
  data() {
    return {
      chartData: {
        labels: ['Liquidaciones','Solicitudes','Anticipos','Comprobaciones','Usuarios'],
        datasets: [ {
          label: 'Vamonos de viaje',
          data: [63, 91, 89, 73, 34], 
          backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)','rgba(255, 206, 86, 0.5)','rgba(255, 0, 0, 0.5)','rgba(60, 179, 113, 0.5)'],
          borderColor: ['rgba(255, 99, 132)', 'rgba(54, 162, 235)','rgba(255, 206, 86)','rgba(255, 0, 0)','rgba(60, 179, 113)'],
          borderWidth: 1,
        }]
      },
      chartOptions: {
        responsive: true,
      },
      pieData: {},
      pie_data: [],
      pieOptions: {
        responsive: true,
        maintainAspectRatio: true
      }
    }
  },
  created() {
    this.getData();
  },
  methods: {
    async getData() {
        let _this = this;
        this.loading = true;
        _this.pie_data = [];
        // _this.pieData.datasets[0].data = [];
     
        axiosClient.post(`/dashboard/`)
            .then(response => {
              let data = response.data.data
              let x = []
              for(var i in data) {
                x.push(data[i]);
              }

              _this.pie_data = x;
            })
            .catch(function (error) {
                _this.loading = false;
            });
    },
  },
  computed: {
    chartUpdte() {
      return {
        labels: ['Liquidaciones','Solicitudes','Anticipos','Comprobaciones','Usuarios'],
        datasets: [ 
          { 
            data: this.pie_data, 
            backgroundColor: ['#FFF033', '#E46651', '#00D8FF', '#007A21', '#FF0000'],
          } 
        ]
      }
    }
  }
}
</script>