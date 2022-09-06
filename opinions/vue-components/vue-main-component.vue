<!-- /vue-components/vue-main-component.vue -->
<!-- https://webdeasy.de/en/vue-app-without-build-tool/ -->
<template>
  <div>
    <h2 v-if="isLo">{{ msg }}</h2>
    <div v-for="opinion in opinions" :key="opinion.id">
      <h2>{{ opinion.reviewer }}</h2>
      <span>{{ opinion.raiting }}</span>
      <p v-html=" opinion.reviewer "></p>
      <hr>
    </div>
  </div>
</template>

<script>
export default {
   data(){
        return {
            msg: "lodding",
            opinions: [],
            isLo: false,
        }
    },
    methods: {
        loadOpinions(){
          this.isLo = true;
            var authCode = btoa('ck_c086751120d32cfb9173e832bc9a24e17b1cc3af:cs_943da74ff6cbc2d0d53b401ee35ca519cc6c2177');
            fetch('https://www.przygotowaniemotoryczne.com/wp-json/wc/v3/products/reviews', {
                method: 'GET',
                headers: {
                    'Authorization': "Basic " + authCode
                },
                
            })
            .then(function(response) {
                if(response.ok){
                    return response.json();
                }
            } )
            .then( function(data) {
              const results = [];
              for(const id in data){
                results.push({
                  id : data[id].id,
                  data: data[id].date_created_gmt,
                  raiting : data[id].rating,
                  review : data[id].review,
                  email: data[id].reviewer_email,
                  status: data[id].status,
                  reviewer : data[id].reviewer,
                  produkt_name: data[id].product_name,
                  produkt_url: data[id].product_name,
                });
              };
              this.opinions = results;
              this.isLo = false;
           
            }.bind(this) );
        }
    },

    mounted(){
        this.loadOpinions();
    }
};
</script>