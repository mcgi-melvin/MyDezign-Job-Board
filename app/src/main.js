import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import router from '@/router'
import { ApiURL } from '@/helpers'
import wysiwyg from "vue-wysiwyg";

Vue.use(VueRouter)
Vue.use(VueResource)
Vue.use(wysiwyg, {
  hideModules: {
    "italic": true,
    "underline": true,
    "image": true,
    "code": true,
    "table": true,
    "removeFormat": true
  },
});
Vue.config.productionTip = false

const job_options = Vue.observable({
  loader: false,
  jobs_url: ApiURL + '/list',
  jobs: [],
  paged: 1,
  keyword: '',
  location: '',
  job_type: 0,
  job_category: 0,
  get_url() {
    let last_url = job_options.jobs_url
    if( job_options.paged ) {
      last_url += '?paged=' + job_options.paged
    }
    if( job_options.keyword ) {
      last_url += '&q=' + job_options.keyword
    }
    if( job_options.location ) {
      last_url += '&location=' + job_options.location
    }
    if( job_options.job_type !== 0 ) {
      last_url += '&type=' + job_options.job_type
    }
    if( job_options.job_category !== 0 ) {
      last_url += '&category=' + job_options.job_category
    }
    return last_url
  }
})


Vue.prototype.$job_options = job_options;


Vue.mixin({
  data: function() {
    return {
      paged: 1,
      jobs: [],
      job_data: [],
      keyword: '',
      location: '',
      job_type: null,
      job_category: null,
      jobs_interval: null
    }
  },
  methods: {
    get_jobs( loader = false ) {
      // Show Loader
      this.$job_options.loader = loader

      // Fetch Data from API
      this.$http.get( this.$job_options.get_url() ).then( response => {
          //console.log( response );
          if( response.status == 200 ) {
            // Set Initial Data For Jobs
            this.jobs = response.body.jobs

            // Set Data to Watch
            Vue.set(Vue.prototype, '$job_options.jobs', response.body.jobs);

            // Get Total Pages for Pagination
            this.total_pages = Math.ceil( response.body.total_pages )

            // Hide Loader
            this.$job_options.loader = false
          }
          
      }).bind(this);
      
    },
    get_jobs_interval() {
      this.jobs_interval = setInterval( () => {
          this.get_jobs()
      }, 5000)
    },
    get_job( job_id = null ) {
      this.$job_options.loader = true;
      this.$http.get( ApiURL + '/single?id='+ job_id ).then( response => {
          if( response.status == 200 ) {
              this.job_data = response.body;
              console.log( response.body )
              this.$job_options.loader = false
          }
      });
    }
    
  },
  computed: {
    get_param( url_string, key ) {
      var url = new URL(url_string);
      return url.searchParams.get(key);
    }
  },
  watch: {
  }
})


new Vue({
  render: h => h(App),
  router
}).$mount('#app')
