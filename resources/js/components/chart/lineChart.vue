<script>
import {Line} from "vue-chartjs";
export default {
    extends: Line,
     async mounted() {
         let req1  = axios.get('/api/dashboard/graph',{headers : { 'Authorization' : 'Bearer ' + this.$store.state.token }})
        await req1.then(e=>{
            this.renderChart(
                {
                    labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre",],
                    datasets: [
                        {
                            label: `Utilisateurs par mois - ${(parseInt(new Date().getFullYear()) - 1)} / ${new Date().getFullYear()}`,
                            data: e.data,
                            backgroundColor: "transparent",
                            borderColor: "rgba(1, 116, 188, 0.50)",
                            pointBackgroundColor: "rgba(171, 71, 188, 1)"
                        }
                    ]
                },
                {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: "Tous les utilisateurs"
                    }
                }
            );
         })
    },

};
</script>
