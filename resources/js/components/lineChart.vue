<template>
    <Line :data="chartData" :options="options" />
</template>

<script lang="ts">
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)

export default {
    name: 'App',
    components: {
        Line
    },
    props: {
        labels: {
            type: Array,
            required: true
        },
        data: {
            type: Array,
            required: true
        }
    },
    computed: {
        chartData() {
            return {
                labels: this.labels,
                datasets: this.data
            }
        }
    },
    data() {
        return {
            options: {
                responsive: true,
                maintainAspectRatio: false
            },

        }
    }

}
</script>
