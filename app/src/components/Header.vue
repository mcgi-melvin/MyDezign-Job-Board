<template>
  <header>
    <div class="main">
      <div class="menu">
        <a href="javascript:void(0)" v-on:click="toggleModal()">
          <span class="hamburger"></span>
          <span class="hamburger"></span>
          <span class="hamburger"></span>
        </a>
      </div>
      <div class="logo">
        <img src="../assets/logo.png" alt="Job Employ PH Logo">
      </div>
      <div class="filter">
        <a href="javascript:void(0);" v-on:click="toggleFilter();get_taxonomies();">
          <img src="../assets/filter-solid.svg" alt="Filter Icon">
        </a>
      </div>
    </div>
    <div class="filter-modal" :class="{ show: showFilter }">
      <form id="filter" ref="filter" v-on:submit.prevent="get_form_data" autocomplete="off">
        <div class="form-group">
          <div class="form-field">
            <input type="text" class="field-input" name="keyword" placeholder="Search Keyword" />
          </div>
          <div class="form-field">
            <input type="text" class="field-input" name="location" placeholder="Enter Location" />
          </div>
        </div>
        <div class="form-group">
          <div class="form-field">
            <select class="field-input" name="job_type" ref="job_type">
              <option value="0">All Types</option>
              <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
            </select>
          </div>
          <div class="form-field">
            <select class="field-input" name="job_category" ref="job_category">
              <option value="0">All Categories</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
          </div>
        </div>
        <input class="button" type="submit" value="Filter" />
      </form>
    </div>
    <div class="menu-modal" :class="{ show: showModal }">
      <ul>
        <li v-on:click="toggleModal()"><router-link to="/">View Listings</router-link></li>
        <li v-on:click="toggleModal()"><router-link to="/add">Post a Job</router-link></li>
        <li v-on:click="toggleModal()"><router-link to="/disclaimer">Disclaimer</router-link></li>
      </ul>
    </div>
    
  </header>
</template>

<script>
export default {
  name: 'Header',
  data() {
    return {
      showModal: false,
      showFilter: false,
      types: [],
      categories: [],
      render: true
    }
  },
  methods: {
    toggleModal() {
      if( this.showModal === true ) {
        this.showModal = false;
        return;
      }
      this.showModal = true;
    },
    toggleFilter() {
      if( this.showFilter === true ) {
        this.showFilter = false;
        return;
      }
      this.showFilter = true;
    },
    get_taxonomies() {
      this.$http.get('https://jobemployph.tk/wp-json/jobs/v1/taxonomies').then( function( response ) {
          if( response.status == 200 ) {
              this.types = response.body.job_types
              this.categories = response.body.job_categories
          }
      });
    },
    get_form_data() {

        let form_fields = this.$refs.filter.querySelectorAll('.field-input')
        form_fields.forEach(element => {
          //this[element.name] = element.value
          this.$job_options[element.name] = element.value
        });

        //this.$root.$emit('updateJobList', this.get_jobs())
        if( this.$route.name != 'home' ) {
          this.$router.push({
            name: 'home',
            params: {
              keyword: this.keyword,
              location: this.location,
              job_type: this.job_type,
              job_category: this.job_category
            }
          })
        }
        this.get_jobs()
        this.showFilter = false
        this.$refs.filter.reset()
    }
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
header {
  position: fixed;
  width: 100%;
  z-index: 2;
}
header .main {
  background: #183c40;
  height: 75px;
  padding: 0 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
  z-index: 10;
}
header .logo img {
  width: 250px;
  max-width: 100%;
  image-rendering: pixelated;
}
header .filter img {
  filter: invert(1);
  width: 30px;
}
header .menu span.hamburger {
  display: block;
  width: 30px;
  height: 2px;
  background: #fff;
}
header .menu span:not(:last-child) {
  margin: 0 0 10px;
}
header .menu-modal {
  position: absolute;
  z-index: 1;
  width: 300px;
  height: 100%;
  min-height: 100vh;
  top: 75px;
  left: -300px;
  background: #fff;
  box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease-in-out;
}
header .menu-modal.show {
  left: 0;
}
header .menu-modal ul {
  padding: 0;
  margin: 0;
}
header .menu-modal li a {
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  color: #183c40;
  font-size: 15px;
  font-weight: bold;
  text-transform: uppercase;
  border-bottom: 1px solid #f3f3f3;
  position: relative;
}
header .menu-modal li a::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 5px;
  background: #fff;
}
header .menu-modal li a.router-link-exact-active {
  background: #dd8041;
  color: #fff;
}
header .menu-modal li a.router-link-exact-active::after {
  background: #183c40;
}
header .filter-modal {
  position: absolute;
  z-index: 1;
  width: 100%;
  height: auto;
  padding: 30px;
  background: #fff;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.4);
  top: -75px;
  visibility: hidden;
  opacity: 0;
  left: 0;
  transition: all 0.8s ease-in-out;
}
header .filter-modal.show {
  top: 75px;
  visibility: visible;
  opacity: 1;
}
@media (max-width: 400px) {
  header .logo img {
    width: 200px;
  }
}
</style>
