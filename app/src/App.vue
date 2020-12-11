<template>
  <div id="app">
    <Header></Header>
    <router-view></router-view>
    <div class="loader-container" v-if="show_loader"><div class="loader"></div></div>
  </div>
</template>

<script>
import Header from './components/Header'
export default {
  name: 'App',
  components: {
    Header
  },
  data() {
    return {
      show_loader: false,
      
    }
  },
  created() {
    this.get_jobs_interval();
  },
  watch: {
    '$job_options.loader' () {
      console.log( 'Loader Status Changed : ' + this.$job_options.loader )
      this.show_loader = this.$job_options.loader
    }
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap');
* {
  font-family: 'Montserrat', sans-serif;
  box-sizing: border-box;
  transition: all 0.3s ease-in-out;
}
html {
  background: #f3f3f3;
}
body {
  margin: 0;
}
h1,
h2,
h3 {
  margin-top: 0;
}
main {
  padding: 110px 40px 70px;
}
.form-group {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
.form-group .form-field {
  width: calc(50% - 5px);
}
.form-field {
  margin-bottom: 10px;
}
.field-input,
.field-textarea {
    background: #f3f3f3;
    border: none;
    padding: 12px 20px;
    width: 100%;
}
.button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 40px;
  text-align: center;
  text-decoration: none;
  text-transform: uppercase;
  color: #fff;
  background: #183c40;
  border: none;
  border-bottom: 5px solid #DD8041;
  transition: none;
}
input[type="submit"]:disabled {
    background: #828282;
}
.container-placeholder {
  height: 200px;
  background: #d0d0d0;
  margin-bottom: 30px;
}

.message {
    padding: 10px 20px;
    margin: 0 0 10px;
    color: #fff !important;
}
.message.success {
    background: green;
}
.message.error {
    background: red;
}

.loader-container {
  position: fixed;
  top: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  background: #fff;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  padding: 20px;
  left: 50%;
  z-index: 100;
}

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #183c40;
  border-right: 4px solid #dd8041;
  border-bottom: 4px solid #183c40;
  border-left: 4px solid #dd8041;
  width: 50px;
  height: 50px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 480px) {
  main {
    padding: 85px 10px 70px;
  }
}
</style>
